<?php

namespace WordPress_org\Main_2022\ExportToPatterns\Parsers;

class BasicText implements BlockParser {
	use DomUtils;
	use TextNodesXPath;

	public function to_strings( array $block ) : array {
		$dom   = $this->get_dom( $block['innerHTML'] );
		$xpath = new \DOMXPath( $dom );

		$strings = [];

		foreach ( $xpath->query( $this->text_nodes_xpath_query() ) as $text ) {
			if ( trim( $text->nodeValue ) ) {
				$strings[] = $text->nodeValue;
			}
		}

		return $strings;
	}

	public function replace_strings( array $block, array $replacements ) : array {
		$dom         = $this->get_dom( $block['innerHTML'] );
		$xpath       = new \DOMXPath( $dom );
		$xpath_query = $this->text_nodes_xpath_query();

		foreach ( $xpath->query( $xpath_query ) as $text ) {
			if ( trim( $text->nodeValue ) && isset( $replacements[ $text->nodeValue ] ) ) {
				$text->parentNode->replaceChild( $dom->createCDATASection( $replacements[ $text->nodeValue ] ), $text );
			}
		}

		$block['innerHTML'] = $this->removeHtml( $dom->saveHTML() );

		foreach ( $block['innerContent'] as &$inner_content ) {
			if ( is_string( $inner_content ) ) {
				$dom = $this->get_dom( $inner_content );
				$xpath = new \DOMXPath( $dom );

				$text_nodes = $xpath->query( $xpath_query );
				$strings = array();

				// Get a unique list of things to replace.
				foreach ( $text_nodes as $text ) {
					if ( ! in_array( $text->nodeValue, $strings ) ) {
						$strings[] = $text->nodeValue;
					}
				}

				foreach ( $strings as $string ) {
					if ( trim( $string ) && isset( $replacements[ $string ] ) ) {
						// Replace only things inside HTML tags or attributes, to prevent nested replacements.
						// For example, if we have "Jetpack" and "Use Jetpack!", this prevents the latter
						// string from becoming `<?php _e( 'Use <?php _e( 'Jetpack', 'wporg' );!', 'wporg' ).
						// There might be edge cases where the string is not wrapped in tags/quotes, but I
						// haven't seen one in testing.
						$regex = '#(<([^>]*)>|=")' . preg_quote( $string, '#' ) . '(<([^>]*)>|")#s';
						$inner_content = preg_replace( $regex, '${1}' . $replacements[ $string ] . '${3}', $inner_content );
					}
				}
			}
		}

		return $block;
	}

}
