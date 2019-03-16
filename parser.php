<?php

namespace GammaScout;

class Parser {

	/**
	 * @var \SimpleXMLElement
	 */
	private $intervals;

	/**
	 * @var integer
	 */
	private $index = 0;

	/**
	 * @var integer
	 */
	private $count;

	/**
	 * @param string $data
	 * @throws \RuntimeException
	 */
	public function __construct($data) {
		$xml = @simplexml_load_string($data);
		if (!$xml) {
			throw new \RuntimeException('No XML content.');
		}
		if ($xml->getName() !== 'gammascout') {
			throw new \RuntimeException('Wrong XML format.');
		}
		$this->intervals = $xml->children();
		$this->count     = $this->intervals->count();
	}

	/**
	 * @return array(mixed)
	 */
	public function getNext() {
		if ($this->index < $this->count) {
			$values   = array();
			$row      = $this->intervals[$this->index++];
			$values[] = str_replace('T', ' ', $row['from']);
			$values[] = str_replace('T', ' ', $row['to']);
			$values[] = (int)$row['counts'];
			return $values;
		}
		return null;
	}

}

?>