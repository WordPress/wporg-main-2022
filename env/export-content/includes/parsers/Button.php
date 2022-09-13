<?php

namespace WordPress_org\Main_2022\ExportToPatterns\Parsers;

class Button implements BlockParser {
	use DomUtils;
	use SwapTags;
	use GetSetAttribute;
	use TextNodesXPath;

	public function to_strings( array $block ) : array {
		$strings = $this->get_attribute( 'placeholder', $block );

		$encoded_html = $this->encode_tags( $block['innerHTML'] );

		$dom   = $this->get_dom( $encoded_html );
		$xpath = new \DOMXPath( $dom );

		foreach ( $xpath->query( $this->text_nodes_xpath_query() ) as $text ) {
			if ( trim( $text->nodeValue ) ) {
				$strings[] = $this->decode_tags( $text->nodeValue );
			}
		}

		return $strings;
	}

	public function replace_strings( array $block, array $replacements ) : array {
		$this->set_attribute( 'placeholder', $block, $replacements );

		$encoded_html = $this->encode_tags( $block['innerHTML'] );

		$dom   = $this->get_dom( $encoded_html );
		$xpath = new \DOMXPath( $dom );

		foreach ( $xpath->query( $this->text_nodes_xpath_query() ) as $text ) {
			if ( trim( $text->nodeValue ) && isset( $replacements[ $this->decode_tags( $text->nodeValue ) ] ) ) {
				$text->parentNode->replaceChild(
					$dom->createCDATASection(
						$this->encode_tags(
							$replacements[ $this->decode_tags( $text->nodeValue ) ]
						)
					),
					$text
				);
			}
		}

		// Replace shortcodes in `href`, as these are url-encoded by `saveHTML()`.
		// This is probably overkill since there should only be one `a` per button,
		// but just to be safe, we loop over any `a`s found.
		$elements = $dom->getElementsByTagName( 'a' );
		$replacements = [];
		foreach ( $elements as $element ) {
			$link = $element->getAttribute( 'href' );
			// If we find a shortcode in the URL, save it.
			if ( $link && preg_match( '/\[.*\]/', $link ) ) {
				$replacements[ urlencode( $link ) ] = $link;
			}
		}

		$html = $this->removeHtml( $dom->saveHTML() );
		if ( count( $replacements ) ) {
			$html = str_replace( array_keys( $replacements ), array_values( $replacements ), $html );
		}
		$decoded_html = $this->decode_tags( $html );
		$block['innerHTML']    = $decoded_html;
		$block['innerContent'] = [ $decoded_html ];

		return $block;
	}
}
