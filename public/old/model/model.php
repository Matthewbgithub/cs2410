<?php

include_once("model/account.php");
include_once("model/event.php");
include_once("model/user.php");
include_once("model/eventprinter.php");

class Model {

    private $server;
    private $dbname;
    private $username;
    private $password;
    private $pdo;

    public function __construct($server, $dbname, $username, $password) {
		$this->pdo=null;
        $this->server = $server;
        $this->dbname = $dbname;
        $this->username = $username;
        $this->password = $password;
    }

    //Connect function to create a db connection
    public function connect() {
        try{
			$this->pdo = new PDO("mysql:host=$this->server;dbname=$this->dbname", "$this->username", "$this->password");
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $ex) {
			echo "<p> a database error occurred: <em> <?= $ex->getMessage() ?> </em></p>";
		}
    }

    //Function to get user by id, returns an account object
    /*public function getAccountById($id) {
        $query = "SELECT * from savings WHERE id='$id'";
		try {
			$rows = $this->pdo-> query($query);
			if ($rows && $rows->rowCount() ==1) {
				$row=$rows->fetch();
				$account=new Account($row["id"], $row["balance"]);
				return $account;
			}
			else return null;
		} catch (PDOException $ex) {
			echo "<p> database error occurred: <em> $ex->getMessage() </em></p>";
		}
	}*/
	
	//function to get an event back by its event id, returns event object
	public function getEventById($id) {
		$query = "Select * from events where id='$id'";
		try {
			$rows = $this->pdo-> query($query);
			if($rows && $rows->rowCount() ==1) {
				$row = $rows->fetch();
				$event = new Event($row["id"],$row["type"],$row["name"],$row["imagesrc"],$row["description"],$row["date"],$row["authorid"],$row["venue"]);
				return $event;
			}
			else return null;
		} catch (PDOException $ex) {
			echo "<p> database error occurred: <em> $ex->getMessage() </em></p>";
		}
	}
	public function getEventsIdsByType($type){
		$query = "Select id from events where type = '$type'";
		try {
			$rows = $this->pdo->query($query);
			if($rows) {
				$rows = $rows->fetchAll(\PDO::FETCH_ASSOC);
				//expand to make an array of only ids, removing the id association
				for($i=0;$i<count($rows); ++$i)
				{
					$result[$i] = $rows[$i]["id"];
				}
				return $result;
			}
			else return null;
		} catch (PDOException $ex) {
			echo "<p> database error occurred: <em> $ex->getMessage() </em></p>";
		}
	}
	public function getAllEventsId(){
		$query = "Select id from events";
		try {
			$rows = $this->pdo->query($query);
			if($rows) {
				$rows = $rows->fetchAll(\PDO::FETCH_ASSOC);
				//expand to make an array of only ids, removing the id association
				for($i=0;$i<count($rows); ++$i)
				{
					$result[$i] = $rows[$i]["id"];
				}
				return $result;
			}
			else return null;
		} catch (PDOException $ex) {
			echo "<p> database error occurred: <em> $ex->getMessage() </em></p>";
		}
	}
	//return author name from their id
	public function getAuthorById($id){
		$query = "Select * from users where id='$id'";
		try {
			$rows = $this->pdo-> query($query);
			if($rows && $rows->rowCount() ==1) {
				$row = $rows->fetch();
				$user = new User($row["id"], $row["name"], $row["contact"]);
				return $user;
			}
			else return null;
		} catch (PDOException $ex) {
			echo "<p> database error occurred: <em> $ex->getMessage() </em></p>";
		}
	}
	
	
	/*
	//Function to deposit amount to account id
    public function deposit($id, $amount) {
        $query = "SELECT * from savings WHERE id='$id'";
		
		try {
			$rows = $this->pdo-> query($query);
			if ($rows && $rows->rowCount() ==1) {
				$row=$rows->fetch();
				$balance = $row['balance'] + $amount;
				$query = "update savings set balance=$balance where id='$id'";
				$result = $this->pdo-> exec($query);
					
				if ($result) return $balance;
			}
			return null;
		} catch (PDOException $ex) {
			echo "<p> database error occurred: <em> $ex->getMessage() </em></p>";
		}
	}*/
	
}