<?php
namespace Devture\Component\DBAL\Model;

abstract class BaseModel {

	private $record = array();

	public function __construct(array $record = array()) {
		$this->record = $record;
	}

	protected function getAttribute($key, $defaultValue = null) {
		return (isset($this->record[$key]) || array_key_exists($key, $this->record) ? $this->record[$key] : $defaultValue);
	}

	protected function setAttribute($key, $value) {
		if(is_string($value)) {
			$value = \voku\helper\UTF8::cleanup($value);
		}
		
		$this->record[$key] = $value;
	}

	public function export() {
		return $this->record;
	}

	public function getId() {
		return $this->getAttribute('_id', null);
	}

	public function setId($value) {
		$this->setAttribute('_id', $value);
	}

}
