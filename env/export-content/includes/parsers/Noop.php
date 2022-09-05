<?php

namespace WordPress_org\Main_2022\ExportToPatterns\Parsers;

class Noop implements BlockParser {
	public function to_strings( array $block ) : array {
		return [];
	}

	public function replace_strings( array $block, array $replacements ) : array {
		return $block;
	}
}
