<?php
require_once ('Repository.php');

class Model {

	private $Repository;
	
	public function __construct() {
		$this->Repository = new Repository();
	}
	
	//Förstör sessionen.
	public function logout(){
		session_unset();
		session_destroy();
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

	//Kollar om sessionen är satt och retunera ture om användaren är inloggad
	//Kollar även om användaren försöker att logga in med fake session.
	public function loginstatus(){
		if(isset($_SESSION["browserstatus"]) && $_SESSION["browserstatus"] == $_SERVER['HTTP_USER_AGENT']){
			if(isset($_SESSION["loginstatus"])){
				return true;
			}
		}
		return false;
	}

	//Kollar så att cookie uppgifterna stämmer
	public function CheckloginWithCookie($username, $password){
		$CookieTime = file_get_contents('CookieTime.txt');

		$db = $this->Repository->connection();
			
			$sql = "SELECT * FROM registernew WHERE name = ?";
			$params = array($username);
			
			$query = $db -> prepare($sql);
			$query -> execute($params);
			$result = $query -> fetch();

		if ($username == $result['name'] && $password == md5($result['password']) && $CookieTime > time()){
			$_SESSION["loginstatus"] = $username;
			$_SESSION["browserstatus"] = $_SERVER['HTTP_USER_AGENT'];
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

	//Kollar om det inmatade värdena stämmer överens med inloggnings uppgifterna
	//Via en databas
	public function Checklogin($username, $password){
		try{
			$db = $this->Repository->connection();
			
			$sql = "SELECT * FROM registernew WHERE name = ? && password = ?";
			$params = array($username, $password);
			
			$query = $db -> prepare($sql);
			$query -> execute($params);
			$result = $query -> fetch();
	
			if($username == $result['name'] && $password == $result['password']){
				$_SESSION["loginstatus"] = $username;
				$_SESSION["browserstatus"] = $_SERVER['HTTP_USER_AGENT'];
				return true;
			}
			else {
				return false;
			}
		}
		catch(\Exception $e){
			throw new \Exception("Databas error, Kolla inloggning!");
		}
	}
	//Kollar om användarnamnet redan finns via en databas och om de gör de lägger inte till en ny.
	public function compareUsername($regusername){
		try{
			$db = $this->Repository->connection();
			
			$sql = "SELECT * FROM registernew WHERE name = ?";
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