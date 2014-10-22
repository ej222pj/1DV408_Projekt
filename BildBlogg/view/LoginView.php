<?php

namespace view;

class LoginView {
	private $loginModel;
	private $message;
	private $user;
	private $Uvalue = "";
	
	private $username = "username";
	private $password = "password";
	private $login = "Login";
	private $checkbox = "checkbox";
	private $cookieUsername = "Username";
	private $cookiePassword = "Password";
	private $cookieTimePath = "CookieTime.txt";
	

	public function __construct(\model\LoginModel $loginModel) {
		$this->loginModel = $loginModel;
	}

	//Sätter kakor
	//Spara ner cookietiden i en fil
	//Kryptera lösenordet
	public function RememberMe(){
		setcookie($this->cookieUsername, $_POST[$this->username], time()+60*60*24*30);
		setcookie($this->cookiePassword, md5($_POST[$this->password]), time()+60*60*24*30);

		$CookieTime = time()+60*60*24*30;
		file_put_contents($this->cookieTimePath, $CookieTime);
	}

	//Kollar om kakan är satt.
	public function isRemembered(){
		if(isset($_COOKIE[$this->cookieUsername]) && isset($_COOKIE[$this->cookiePassword])){
			return true;
		}
		else{
			return false;
		}
	}
	
	//Sätter Användarnamn boxen om man lyckas registrera sig
	public function setUsername($username){
		$ret = $this->Uvalue = $username;
		return $ret;
	}

	//Hämta kaknamnet
	public function getCookieUsername(){
		return $_COOKIE[$this->cookieUsername];
	}

	//Hämtar kaklösenordet
	public function getCookiePassword(){
		return $_COOKIE[$this->cookiePassword];
	}

	//Kollar om anvnändaren klickat i håll mig inloggad rutan
	public function Checkbox(){
		if(isset($_POST[$this->checkbox])){
			return true;
		}
	}

	//Hämtar ut användarnamnet
	public function getUsername(){
		if(isset($_POST[$this->username])){
			return $_POST[$this->username];
		}
	}

	//Hämtar ut lösenordet
	public function getPassword(){
		if(isset($_POST[$this->password])){
			return $_POST[$this->password];
		}
	}

	//Kollar om man klickat på login knappen.
	//Kollar om användaren skickar med input och skriver ut felmeddelanden.
	//Sätter användanamnet till value på inmatningssträngen
	public function didUserPressLogin(){
		if(isset($_POST[$this->login])){
			return true;
		}
	}

	//Förstör kakorna.
	public function removeCookie(){
		setcookie ($this->cookieUsername, "", time() - 3600);
		setcookie ($this->cookiePassword, "", time() - 3600);
	}

	//Skriver ut HTMLkod efter om användaren är inloggad eller inte.
	public function HTMLPage($Message){
		$user = "user";
		if(isset($_SESSION[$user]) === false){
			$_SESSION[$user] = $this->user;
		}
		$ret = "";
				$ret .= "	
				<img src='./pic/bild.jpg' class='headerpic' alt=''>
				<div class='border'>				
					<h2>Ej inloggad</h2>
						<form method='post' id='login'>
							<fieldset>
								<legend>Logga in</legend>
								<p>$this->message</p>
								<p>$Message</p>
								<label>Användarnamn:</label>
								<input type=text size=2 name=$this->username id='UserNameID' value='$this->Uvalue'>
								<label>Lösenord:</label>
								<input type=password size=2 name=$this->password id='PasswordID' value=''>
								<label>Håll mig inloggad  :</label>
								<input type=checkbox name=$this->checkbox>
								<input type=submit name=$this->login value='Logga in'>
							</fieldset>
						</form>
					</div>				
				";
		return $ret;
			
	}
}