<?php
# An event object holds details of the event
class Event {
  private $id=null;
  private $type=null;
  private $name=null;
  private $imagesrc=null;
  private $description=null;
  private $date=null;
  private $authorid=null;
  private $venue=null;
  
  # Creates a new account with the given name balance
  public function __construct($id,$type, $name, $imagesrc,  $description, $date, $authorid, $venue) {
	$this->id = $id;
	$this->type = $type;
	$this->name = $name;
	$this->imagesrc = $imagesrc;
    $this->description = $description;
    $this->date = $date;
    $this->authorid = $authorid;
    $this->venue = $venue;
  }
  
  # __get method
  public function __get($var){
	return $this->$var;
  }
  public function __set($var, $value){
	  $this->$var = $value;
  }
 
}
?>
