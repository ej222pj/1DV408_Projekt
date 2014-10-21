<?php

namespace view;

class RegisterView {
	private $registerModel;
	private $message;
	private $RegUvalue = "";
	
	private $regUsername = "regusername";
	private $regPassword = "regpassword";
	private $repRegPassword = "repregpassword";
	private $registerNew = "RegisterNew";
	
	
	
	public function __construct(\model\RegisterModel $registerModel) {
		$this->registerModel = $registerModel;
	}
	
	//Hämtar användarnamnet
	public function getUsername(){
		if(isset($_POST[$this->regUsername])){
			 if(empty($_POST[$this->regUsername])){
			 	$this->message = "Användarnamnet innehåller ogiltiga tecken";
			 	$this->RegUvalue = $this->cleanInput($_POST[$this->regUsername]);
			 }
			 else{
			 	return $this->cleanInput($_POST[$this->regUsername]);
			 }
		}
	}
	
	//FILTER_SANITIZE_STRING
	//FILTER_FLAG_STRIP_LOW
	//This filter removes data that is potentially harmful for your application. 
	//It is used to strip tags and remove or encode unwanted characters.
	//Inte helt 100% på vad strip_low gör men hittade på Stackoverflow och de funkar.
	public function cleanInput($username){
		$username = ucfirst(strtolower($username));
		$clean = trim($username);
		$superClean = filter_var($clean, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
		
		return $superClean;
	}
	
	public function setUsername($username){
		$ret = $this->RegUvalue = $username;
		return $ret;
	}

	//Hämtar ut lösenordet
	public function getPassword(){
		if(isset($_POST[$this->regPassword])){
			return $_POST[$this->regPassword];
		}
	}
	
	public function getRepPassword(){
		if(isset($_POST[$this->repRegPassword])){
			return $_POST[$this->repRegPassword];
		}
	}
	
	public function setUsernameAndStatusMessage($message){
		$this->RegUvalue = $_POST[$this->regUsername];
		$this->message = $message;
	}
	
	public function didUserPressRegisterNew(){
		if(isset($_POST[$this->registerNew])){
			if(($_POST[$this->regUsername]) == "" && ($_POST[$this->regPassword]) == ""){
				//$this->RegUvalue = $_POST[$this->regUsername];
				//$this->message = "Användarnamnet har för få tecken. Minst 3 tecken!\nLösenordet har för få tecken. Minst 6 tecken";
				$this->setUsernameAndStatusMessage("Användarnamnet har för få tecken. Minst 3 tecken!\nLösenordet har för få tecken. Minst 6 tecken");
			}
			elseif(strlen(($_POST[$this->regUsername])) < 3){
				//$this->RegUvalue = $_POST[$this->regUsername];
				//$this->message = "Användarnamnet har för få tecken. Minst 3 tecken";
				$this->setUsernameAndStatusMessage("Användarnamnet har för få tecken. Minst 3 tecken");
			}
			elseif(($_POST[$this->regPassword]) == "" && ($_POST[$this->regUsername]) != "" || strlen(($_POST[$this->regPassword])) < 6) {
				//$this->RegUvalue = $_POST[$this->regUsername];
				//$this->message = "Lösenordet har för få tecken. Minst 6 tecken";
				$this->setUsernameAndStatusMessage("Lösenordet har för få tecken. Minst 6 tecken");
			}
			elseif(($_POST[$this->repRegPassword]) !== ($_POST[$this->regPassword])) {
				//$this->RegUvalue = $_POST[$this->regUsername];
				//$this->message = "Lösenorden matchar inte";
				$this->setUsernameAndStatusMessage("Lösenorden matchar inte");
			}
			return true;
		}
		else{
			return false;
		}
	}
	
	public function HTMLPage($Message){
		$ret = "
				<div class='bordertwo'>	
				<h2>Registrerar användare</h2>
	
				<form method='post' id='register'>
					<fieldset>
						<legend>Registrera ny användare</legend>
						<p>$this->message</p>
						<p>$Message</p>
						<label>Namn:</label>
						<input type=text size=5 name=$this->regUsername id='regUserNameID' value='$this->RegUvalue'>
						<label>Lösenord:</label>
						<input type=password size=5 name=$this->regPassword id='regPasswordID' value=''>
						<label>Repetera Lösenord:</label>
						<input type=password size=5 name=$this->repRegPassword id='repregPasswordID' value=''>
						<input type=submit name=$this->registerNew value='Registrera'>
					</fieldset>
				</form>
			</div>";
				
		return $ret;
	}
}