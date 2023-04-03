<?php

namespace WordPress_org\Main_2022\ExportToPatterns\Parsers;

class AttributeParser implements BlockParser {
	use GetSetAttribute;

	public $attributes = [];

	public function __construct( $attributes = array() ) {
		$this->attributes = (array) $attributes;
	}

	public function to_strings( array $block ) : array {
		$strings = [];
		foreach ( $this->attributes as $attr ) {
			$results = $this->get_attribute( $attr, $block );
			$strings = array_merge( $strings, $results );
		}

		return $strings;
	}

	public function replace_strings( array $block, array $replacements ) : array {
		foreach ( $this->attributes as $attr ) {
			$this->set_attribute( $attr, $block, $replacements );
		}

		return $block;
	}
}
