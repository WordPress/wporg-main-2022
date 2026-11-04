<?php

namespace WordPress_org\Main_2022\ExportToPatterns\Parsers;

class ListItem implements BlockParser {
	public function to_strings( array $block ): array {
		$strings = array();

		$matches = array();

		if ( preg_match( '/<li[^>]*>(.+)<\/li>/is', $block['innerHTML'], $matches ) ) {
			if ( ! empty( $matches[1] ) ) {
				$strings[] = $matches[1];
			}
		}

		return $strings;
	}

	private function do_replacement( array $block, array $replacements, $html ) {
		if ( ! $html ) {
			return $html;
		}

		foreach ( $this->to_strings( $block ) as $original ) {
			if ( ! empty( $original ) && isset( $replacements[ $original ] ) ) {
				$regex = '#(<li[^>]*>)(' . preg_quote( $original, '/' ) . ')(<\/li>)?#is';
				$html  = preg_replace( $regex, '$1' . addcslashes( $replacements[ $original ], '\\$' ) . '$3', $html );
			}
		}

		return $html;
	}

	public function replace_strings( array $block, array $replacements ): array {

		foreach ( $block['innerContent'] as $i => $html ) {
			$block['innerContent'][ $i ] = $this->do_replacement( $block, $replacements, $html );
		}

		$block['innerHTML'] = $this->do_replacement( $block, $replacements, $block['innerHTML'] );

		return $block;
	}
}
