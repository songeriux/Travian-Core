<?php
###################################################
##-= YOU MAY NOT REMOVE OR CHANGE THIS NOTICE =- ##
## ----------------------------------------------##
## Project starters: Akakori, TTMMTT and other   ##
## Travian-Core project owner: Songer		     ##
## Project devoloper's: Songer				     ##
## Editors: Dzoki and other...				     ##
## Licence: Travian-Core					     ##
## Release date: 2012.03.17 15:40			     ##
## All right reserverd						     ##
## ENJOY THE TRAVIAN!!						     ##
###################################################

class Form {
	
	private $errorarray = array();
	public $valuearray = array();
	private $errorcount;
	
	public function Form() {
		if(isset($_SESSION['errorarray']) && isset($_SESSION['valuearray'])) {
			$this->errorarray = $_SESSION['errorarray'];
			$this->valuearray = $_SESSION['valuearray'];
			$this->errorcount = count($this->errorarray);
			
			unset($_SESSION['errorarray']);
			unset($_SESSION['valuearray']);
		}
		else {
			$this->errorcount = 0;
		}
	}
	
	public function addError($field,$error) {
		$this->errorarray[$field] = $error;
		$this->errorcount = count($this->errorarray);
	}
	
	public function getError($field) {
		if(array_key_exists($field,$this->errorarray)) {
			return $this->errorarray[$field];
		}
		else {
			return "";
		}
	}
	
	public function getValue($field) {
		if(array_key_exists($field,$this->valuearray)) {
			return $this->valuearray[$field];
		}
		else {
			return "";
		}
	}
	
	public function getDiff($field,$cookie) {
		if(array_key_exists($field,$this->valuearray) && $this->valuearray[$field] != $cookie) {
			return $this->valuearray[$field];
		}
		else {
			return $cookie;
		}
	}
	
	public function getRadio($field,$value) {
		if(array_key_exists($field,$this->valuearray) && $this->valuearray[$field] == $value) {
			return "checked";
		}
		else {
			return "";
		}
	}
	
	public function returnErrors() {
		return $this->errorcount;
	}
	
	public function getErrors() {
		return $this->errorarray;
	}
};
?>