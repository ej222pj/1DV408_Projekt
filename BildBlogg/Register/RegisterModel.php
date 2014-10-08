<?php

require_once ('./Login/Repository.php');

class RegisterModel {

	private $Repository;
	
	public function __construct() {
		$this->Repository = new Repository();
	}
	
	public function registerUser(){
		return true;
	}
	//Kollar mot datorbasen om en användare finns
	public function CheckRegisterNew($regusername){
		if($this->username !== $regusername){
			return true;
		}
		else{
			return false;
		}
	}

	//Lägger till användare till en datorbas
	public function addUser($regusername, $regpassword){
		try{
			$db = $this->Repository->connection();
	
			$sql = "INSERT INTO registernew (name, password) VALUES (?, ?)";
			$params = array($regusername, $regpassword);
	
			$query = $db->prepare($sql);
			$query->execute($params);
			return true;
		}
		catch(\Exception $e){
			throw new \Exception("Databas error, Lägga till användare!");
		}
	}
}