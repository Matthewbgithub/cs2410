<?php

class User {
	
	private $id=null;
	private $name=null;
	private $contact=null;
	
	public function __construct($id, $name, $contact)
	{
		$this->id = $id;
		$this->name = $name;
		$this->contact = $contact;
	}
	# __get method
	public function __get($var){
	return $this->$var;
	}
	public function __set($var, $value){
	  $this->$var = $value;
	}
}