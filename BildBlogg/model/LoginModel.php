<?php

namespace model;

require_once('./model/Repository.php'); 

class LoginModel {
	private $browserstatus = "browserstatus";
	private $loginstatus = "loginstatus";
	private $HTTP_USER_AGENT = "HTTP_USER_AGENT";
	private $cookietime = "CookieTime.txt";
	private $loginsucess = "LoginSucess";
	private $name = "name";
	private $password = "password";
	
	public function __construct() {
		$this->Repository = new Repository();
	}
	
	//Förstör sessionen.
	public function logout(){
		session_unset();
		session_destroy();
	}
	
	public function cookiePassword($password){
		return md5($password);
	}

	//Kollar om sessionen är satt och retunera ture om användaren är inloggad
	//Kollar även om användaren försöker att logga in med fake session.
	public function loginstatus(){
		if(isset($_SESSION[$this->browserstatus]) && $_SESSION[$this->browserstatus] == $_SERVER[$this->HTTP_USER_AGENT]){
			if(isset($_SESSION[$this->loginstatus])){
				return true;
			}
		}
		return false;
	}

	//Kollar så att cookie uppgifterna stämmer
	public function CheckloginWithCookie($username, $password){
		$CookieTime = file_get_contents($this->cookietime);

		$db = $this->Repository->connection();
			
			$sql = "SELECT * FROM NewUserForBlog WHERE name = ?";
			$params = array($username);
			
			$query = $db -> prepare($sql);
			$query -> execute($params);
			$result = $query -> fetch();

		if ($username == $result[$this->name] && $password == md5($result[$this->password]) && $CookieTime > time()){
			$_SESSION[$this->loginstatus] = $username;
			$_SESSION[$this->browserstatus] = $_SERVER[$this->HTTP_USER_AGENT];
			return true;
		}
		else{
			return false;
		}
	}

	//Kollar om det inmatade värdena stämmer överens med inloggnings uppgifterna
	//Via en databas
	public function Checklogin($username, $password){
		try{
			$db = $this->Repository->connection();
			
			$sql = "SELECT * FROM NewUserForBlog WHERE name = ? && password = ?";
			$params = array($username, $password);
			
			$query = $db -> prepare($sql);
			$query -> execute($params);
			$result = $query -> fetch();
	
			if($username == $result[$this->name] && $password == $result[$this->password]){
				$_SESSION[$this->loginstatus] = $username;
				$_SESSION[$this->browserstatus] = $_SERVER[$this->HTTP_USER_AGENT];
				$_SESSION[$this->loginsucess] = true;
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
}