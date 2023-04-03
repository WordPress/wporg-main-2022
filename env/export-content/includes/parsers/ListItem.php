<?php

namespace WordPress_org\Main_2022\ExportToPatterns\Parsers;

class ListItem implements BlockParser {
	use GetSetAttribute;

	public function to_strings( array $block ) : array {
		$strings = $this->get_attribute( 'placeholder', $block );

		$matches = [];

		if ( preg_match( '/<li[^>]*>(.+)<\/li>/is', $block['innerHTML'], $matches ) ) {
			if ( ! empty( $matches[1] ) ) {
				// If the child string is totally wrapped in `a` tags, extract the a's text.
				if ( preg_match( '/^<a[^>]*>(.+)<\/a>$/is', $matches[1], $a_matches ) ) {
					$strings[] = $a_matches[1];
				} else {
					$strings[] = $matches[1];
				}
			}
		}

		return $strings;
	}

	public function _do_replacement( array $block, array $replacements, $html ) {
		if ( ! $html ) {
			return $html;
		}

		foreach ( $this->to_strings( $block ) as $original ) {
			if ( ! empty( $original ) && isset( $replacements[ $original ] ) ) {
				$regex = '#(<li[^>]*>)(<a[^>]*>)?(' . preg_quote( $original, '/' ) . ')(<\/a>)?(<\/li>)?#is';
				$html  = preg_replace( $regex, '$1$2' . addcslashes( $replacements[ $original ], '\\$' ) . '$4$5', $html );
			}
		}

		return $html;
	}

	public function replace_strings( array $block, array $replacements ) : array {
		$this->set_attribute( 'placeholder', $block, $replacements );

		foreach ( $block['innerContent'] as $i => $html ) {
			$block['innerContent'][ $i ] = $this->_do_replacement( $block, $replacements, $html );
		}

		$block['innerHTML'] = $this->_do_replacement( $block, $replacements, $block['innerHTML'] );

		return $block;
	}
}
