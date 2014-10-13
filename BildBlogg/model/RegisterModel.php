<?php

namespace model;

require_once('./model/Repository.php');

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
	
			$sql = "INSERT INTO registerforblog (name, password) VALUES (?, ?)";
			$params = array($regusername, $regpassword);
	
			$query = $db->prepare($sql);
			$query->execute($params);
			return true;
		}
		catch(\Exception $e){
			throw new \Exception("Databas error, Lägga till användare!");
		}
	}
	//Kollar om användarnamnet redan finns via en databas och om de gör de lägger inte till en ny.
	public function compareUsername($regusername){
		try{
			$db = $this->Repository->connection();
			
			$sql = "SELECT * FROM registerforblog WHERE name = ?";
			$params = array($regusername);
			
			$query = $db -> prepare($sql);
			$query -> execute($params);
			$result = $query -> fetch();
			
			if($result == false){
				return true;
			}
			else{
				return false;
			}
		}
		catch(\Exception $e){
			throw new \Exception("Databas error, Kollar om användaren finns!");
		}
	}
}