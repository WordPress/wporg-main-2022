<?php

namespace WordPress_org\Main_2022\ExportToPatterns;

require_once __DIR__ . '/parsers/BlockParser.php';
require_once __DIR__ . '/parsers/BasicText.php';
require_once __DIR__ . '/parsers/Button.php';
require_once __DIR__ . '/parsers/Heading.php';
require_once __DIR__ . '/parsers/Noop.php';
require_once __DIR__ . '/parsers/RichText.php';

// Unused.
require_once __DIR__ . '/parsers/ShortcodeBlock.php';
require_once __DIR__ . '/parsers/TextNode.php';

class BlockParser {
	public $pattern;
	public $parsers = [];
	public $fallback;

	public function __construct() {
		$this->parsers = [
			// Core blocks that have custom parsers.
			'core/paragraph'   => new Parsers\RichText(),
			'core/list-item'   => new Parsers\RichText(),
			'core/heading'     => new Parsers\Heading(),
			'core/button'      => new Parsers\Button(),
			'core/spacer'      => new Parsers\Noop(),

			// Common core blocks that use the default parser.
			'core/buttons'     => new Parsers\BasicText(),
			'core/list'        => new Parsers\BasicText(),
			'core/column'      => new Parsers\BasicText(),
			'core/columns'     => new Parsers\BasicText(),
			'core/cover'       => new Parsers\BasicText(),
			'core/group'       => new Parsers\BasicText(),
			'core/image'       => new Parsers\BasicText(),
			'core/media-text'  => new Parsers\BasicText(),
			'core/separator'   => new Parsers\BasicText(),
			'core/social-link' => new Parsers\BasicText(),
		];

		$this->fallback = new Parsers\BasicText();
	}

	public function replace_with_i18n( string $content ) : string {
		$strings = $this->to_strings( $content );
		$i18n_strings = [];
		foreach ( $strings as $string ) {
			$i18n_strings[ $string ] = sprintf( "<?php _e( '%s', 'wporg' ); ?>", str_replace( "'", '&#039;', $string ) );
		}
		return $this->replace_strings( $content, $i18n_strings );
	}

	public function block_parser_to_strings( array $block ) : array {
		$parser = $this->parsers[ $block['blockName'] ] ?? $this->fallback;

		$strings = $parser->to_strings( $block );

		foreach ( $block['innerBlocks'] as $inner_block ) {
			$strings = array_merge( $strings, $this->block_parser_to_strings( $inner_block ) );
		}

		return $strings;
	}

	public function block_parser_replace_strings( array &$block, array $replacements ) : array {
		$parser = $this->parsers[ $block['blockName'] ] ?? $this->fallback;
		$block = $parser->replace_strings( $block, $replacements );

		foreach ( $block['innerBlocks'] as &$inner_block ) {
			$inner_block = $this->block_parser_replace_strings( $inner_block, $replacements );
		}

		return $block;
	}

	public function to_strings( string $content ) : array {
		$blocks = parse_blocks( $content );

		$strings = [];

		foreach ( $blocks as $block ) {
			$strings = array_merge( $strings, $this->block_parser_to_strings( $block ) );
		}

		return array_unique( $strings );
	}

	public function replace_strings( string $content, array $replacements ) : string {
		$blocks = parse_blocks( $content );

		foreach ( $blocks as &$block ) {
			$block = $this->block_parser_replace_strings( $block, $replacements );
		}

		// If we pass `serialize_blocks` a block that includes unicode characters in the
		// attributes, these attributes will be encoded with a unicode escape character, e.g.
		// "subscribePlaceholder":"😀" becomes "subscribePlaceholder":"\ud83d\ude00".
		// After we get the serialized blocks back from `serialize_blocks` we need to convert these
		// characters back to their unicode form so that we don't break blocks in the editor.
		$new_content = $this->decode_unicode_characters( serialize_blocks( $blocks ) );

		return $new_content;
	}

	/**
	 * Decode a string containing unicode escape sequences.
	 * Excludes decoding characters not allowed within block attributes.
	 *
	 * @param string $string A string containing serialized blocks.
	 * @return string A string containing decoded unicode characters.
	 */
	public function decode_unicode_characters( string $string ): string {

		// In WordPress core, `serialize_block_attributes` intentionally leaves some characters
		// in the block attributes encoded in their unicode form. These are characters that would
		// interfere with characters in block comments e.g. consider potential values entered
		// in the placeholder attribute: <!-- wp:paragraph {"placeholder":"dangerous characters go here"} -->
		// Reference: https://github.com/WordPress/WordPress/blob/HEAD/wp-includes/blocks.php#L367

		$excluded_characters = [
			'\\u002d\\u002d', // '--'
			'\\u003c',        // '<'
			'\\u003e',        // '>'
			'\\u0026',        // '&'
			'\\u0022',        // '"'
		];

		// Match any uninterrupted sequence of \u escaped unicode characters.
		$decoded_string = preg_replace_callback(
			'#(\\\\u[a-zA-Z0-9]{4})+#',
			function ( $matches ) use ( $excluded_characters ) {
				// If we encounter any excluded characters, don't decode this match.
				foreach ( $excluded_characters as $excluded_character ) {
					if ( false !== mb_stripos( $matches[0], $excluded_character ) ) {
						return $matches[0];
					}
				}
				// If we didn't encounter excluded characters, use json_decode to do the heavy lifting.
				return json_decode( '"' . $matches[0] . '"' );
			},
			$string
		);

		return $decoded_string;
	}
}
