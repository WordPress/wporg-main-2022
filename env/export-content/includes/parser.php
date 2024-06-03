<?php

namespace WordPress_org\Main_2022\ExportToPatterns;

require_once __DIR__ . '/parsers/BlockParser.php';
require_once __DIR__ . '/parsers/AttributeParser.php';
require_once __DIR__ . '/parsers/BasicText.php';
require_once __DIR__ . '/parsers/HTMLParser.php';
require_once __DIR__ . '/parsers/ListItem.php';
require_once __DIR__ . '/parsers/Noop.php';
require_once __DIR__ . '/parsers/ShortcodeBlock.php';
require_once __DIR__ . '/parsers/TextNode.php';

class BlockParser {
	public $content;
	public $parsers = [];
	public $fallback;

	public function __construct( string $content = '' ) {
		$this->content  = $content;
		$this->fallback = new Parsers\BasicText();
		$this->parsers  = [
			// Blocks that have custom parsers.
			'core/paragraph'   => new Parsers\HTMLParser( 'p', [], 2 /* minimum length of 2 characters. */ ),
			'core/image'       => new Parsers\HTMLParser( 'figcaption', [ 'alt', 'title' ] ),
			'core/heading'     => new Parsers\HTMLRegexParser( '/h[1-6]/' ),

			'core/list-item'   => new Parsers\ListItem(),
			'core/button'      => new Parsers\HTMLParser( 'a', [ 'title', 'href' ] ),

			// Attributes handler.
			'core/navigation-link' => new Parsers\AttributeParser( [ 'label' ] ),
			'core/social-link'     => new Parsers\AttributeParser( [ 'label' ] ),

			// Generic shortcode handler.
			'core/shortcode'   => new Parsers\ShortcodeBlock(),

			// These contain other blocks to be parsed.
			'core/column'      => new Parsers\Noop(),
			'core/columns'     => new Parsers\Noop(),
			'core/group'       => new Parsers\Noop(),
			'core/list'        => new Parsers\Noop(),
			'core/quote'       => new Parsers\Noop(),

			// Don't translate content.
			'core/code'  => new Parsers\Noop(),
			'core/embed' => new Parsers\Noop(),

			// No content.
			'core/spacer' => new Parsers\Noop(),

			// Common core blocks that use the default parser.
			'core/media-text'  => new Parsers\BasicText(),

			// Shared custom blocks.
			'wporg/link-wrapper' => new Parsers\HTMLParser( 'a', [ 'href' ] ),
		];
	}

	public static function post_to_strings( $post ) {
		// TODO: Detect post using a block template, pull strings from there.
		$self    = new self( $post->post_content );
		$strings = $self->to_strings();

		if ( $post->post_title ) {
			$strings[] = $post->post_title;
		}
		if ( $post->post_excerpt ) {
			$strings[] = $post->post_excerpt;
		}

		$post_meta_to_include = apply_filters( 'translatable_post_meta', [] );
		foreach ( $post_meta_to_include as $meta_key ) {
			$strings[] = get_post_meta( $post->ID, $meta_key, true );
		}

		return $strings;
	}

	public static function translate_post( $post, callable $callback_translate ) {
		$post->post_content = self::translate_blocks( $post->post_content, $callback_translate ) ?: $post->post_content;
		$post->post_title   = $callback_translate( $post->post_title ) ?: $post->post_title;
		$post->post_excerpt = $callback_translate( $post->post_excerpt ) ?: $post->post_excerpt;

		return $post;
	}

	public static function translate_blocks( string $content, callable $callback_translate ) /*: bool|string*/ {
		$self         = new self( $content );

		$translations = [];
		$translated   = false;
		$strings      = $self->to_strings();

		foreach ( $strings as $string ) {
			$translations[ $string ] = $callback_translate( $string );

			$translated = $translated || ( $string !== $translations[ $string ] );
		}

		// Are there any translations?
		if ( ! $translated ) {
			return false;
		}

		return $self->replace_strings_with_kses( $translations );
	}

	public static function translate_block( string $content, $block, callable $callback_translate ) /* :bool|string */ {
		$self    = new self();
		$parser  = $self->parsers[ $block['blockName'] ] ?? $self->fallback;
		$strings = $parser->to_strings( $block ); // does not do innerBlocks, intentionally.

		if ( ! $strings ) {
			return $content;
		}

		$replacements = [];
		foreach ( $strings as $string ) {
			$replacements[ $string ] = $callback_translate( $string ) ?: $string;
		}

		$block = $parser->replace_strings( $block, $replacements );

		return $block['innerContent'][0] ?: $content;
	}

	public function block_parser_to_strings( array $block ) : array {
		$parser = $this->parsers[ $block['blockName'] ] ?? $this->fallback;

		$strings = $parser->to_strings( $block );

		foreach ( $block['innerBlocks'] as $inner_block ) {
			$strings = array_merge( $strings, $this->block_parser_to_strings( $inner_block ) );
		}

		return array_unique( $strings );
	}

	public function block_parser_replace_strings( array &$block, array $replacements ) : array {
		$parser = $this->parsers[ $block['blockName'] ] ?? $this->fallback;
		$block = $parser->replace_strings( $block, $replacements );

		foreach ( $block['innerBlocks'] as &$inner_block ) {
			$inner_block = $this->block_parser_replace_strings( $inner_block, $replacements );
		}

		return $block;
	}

	public function to_strings() : array {
		$strings = [];

		$blocks = parse_blocks( $this->content );

		foreach ( $blocks as $block ) {
			$strings = array_merge( $strings, $this->block_parser_to_strings( $block ) );
		}

		$strings = array_unique( $strings );
		$strings = array_filter( $strings, array( $this, 'filter_out_shortcodes' ) );

		return $strings;
	}

	public function filter_out_shortcodes( string $string ) : bool {
		return ! preg_match( '#^\[[a-z_-]{5,}\]$#', $string );
	}

	public function replace_strings_with_kses( array $replacements ) : string {
		// Sanitize replacement strings before injecting them into blocks and block attributes.
		$sanitized_replacements = $replacements;
		foreach ( $sanitized_replacements as &$replacement ) {
			$replacement = wp_kses_post( $replacement );
		}
		return $this->replace_strings( $sanitized_replacements );
	}

	public function replace_strings( array $replacements ) : string {
		$translated = $this->content;

		$blocks = parse_blocks( $translated );
		foreach ( $blocks as &$block ) {
			$block = $this->block_parser_replace_strings( $block, $replacements );
		}

		// If we pass `serialize_blocks` a block that includes unicode characters in the
		// attributes, these attributes will be encoded with a unicode escape character, e.g.
		// "subscribePlaceholder":"😀" becomes "subscribePlaceholder":"\ud83d\ude00".
		// After we get the serialized blocks back from `serialize_blocks` we need to convert these
		// characters back to their unicode form so that we don't break blocks in the editor.
		$translated = $this->decode_unicode_characters( serialize_blocks( $blocks ) );

		return $translated;
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

		// Decode < & > if they're part of a PHP tag.
		$decoded_string = str_replace( [ '\\u003c?', '?\\u003e' ], [ '<?', '?>' ], $decoded_string );

		return $decoded_string;
	}
}

/**
 * Helper function to replace all strings in content with i18n-wrapped strings.
 */
function replace_with_i18n( string $content, string $textdomain = 'wporg' ) : string {
	$parser = new BlockParser( $content );
	$strings = $parser->to_strings();

	$i18n_strings = [];
	foreach ( $strings as $string ) {
		if ( preg_match_all( '#\[[a-z_-]{5,}\]#', $string, $matches ) ) {
			if ( count( $matches[0] ) > 1 ) {
				$translator_comment = sprintf( '/* translators: %s are shortcodes and should not be translated. */', implode( ', ', $matches[0] ) );
			} else {
				$translator_comment = sprintf( '/* translators: %s is a shortcode and should not be translated. */', implode( ', ', $matches[0] ) );
			}
			$i18n_strings[ $string ] = sprintf(
				"<?php\n%s\n_e( '%s', '%s' );\n?>",
				$translator_comment,
				str_replace( "'", '&#039;', $string ),
				$textdomain
			);
		} else {
			$i18n_strings[ $string ] = sprintf(
				"<?php _e( '%s', '%s' ); ?>",
				str_replace( "'", '&#039;', $string ),
				$textdomain
			);
		}
	}

	return $parser->replace_strings( $i18n_strings );
}
