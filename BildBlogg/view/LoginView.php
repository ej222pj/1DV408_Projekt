<?php

namespace view;

class LoginView {
	private $model;
	private $message;
	private $user;
	private $Uvalue = "";
	private $Pvalue = "";

	public function __construct(\model\LoginModel $model) {
		$this->model = $model;
	}

	//Sätter kakor
	//Spara ner cookietiden i en fil
	//Kryptera lösenordet
	public function RememberMe(){
		setcookie('Username', $_POST["username"], time()+60*60*24*30);
		setcookie('Password', md5($_POST["password"]), time()+60*60*24*30);

		$CookieTime = time()+60*60*24*30;
		file_put_contents('CookieTime.txt', $CookieTime);
	}

	//Kollar om kakan är satt.
	public function isRemembered(){
		if(isset($_COOKIE['Username']) && isset($_COOKIE['Password'])){
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
		return $_COOKIE['Username'];
	}

	//Hämtar kaklösenordet
	public function getCookiePassword(){
		return $_COOKIE['Password'];
	}

	//Kollar om anvnändaren klickat i håll mig inloggad rutan
	public function Checkbox(){
		if(isset($_POST['checkbox'])){
			return true;
		}
	}

	//Hämtar ut användarnamnet
	public function getUsername(){
		if(isset($_POST["username"])){
			return $_POST["username"];
		}
	}

	//Hämtar ut lösenordet
	public function getPassword(){
		if(isset($_POST["password"])){
			return $_POST["password"];
		}
	}

	//Kollar om man klickat på login knappen.
	//Kollar om användaren skickar med input och skriver ut felmeddelanden.
	//Sätter användanamnet till value på inmatningssträngen
	public function didUserPressLogin(){
		if(isset($_POST['Login'])){
			if(($_POST["username"]) == ""){
				$this->message = "Användarnamn saknas!";
			}
			if(($_POST["password"]) == "" && ($_POST["username"]) != "") {
				$this->Uvalue = $_POST["username"];
				$this->message = "Lösenord saknas!";
			}
			if(($_POST["password"]) != "" && ($_POST["username"]) != ""){
				$this->Uvalue = $_POST["username"];
			}
			return true;
		}
		else {
			return false;
		}
	}

	//Förstör kakorna.
	public function removeCookie(){
		setcookie ('Username', "", time() - 3600);
		setcookie ('Password', "", time() - 3600);
	}

	//Kollar om man klickat på logout knappen.
	public function didUserPressLogout(){
		if(isset($_POST['Logout'])){
			$this->removeCookie();
			return true;
		}
		else {
			return false;
		}
	}

	//Skriver ut HTMLkod efter om användaren är inloggad eller inte.
	public function HTMLPage($Message){
		if(isset($_SESSION['user']) === false){
			$_SESSION['user'] = $this->user;
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
								<input type=text size=2 name='username' id='UserNameID' value='$this->Uvalue'>
								<label>Lösenord:</label>
								<input type=password size=2 name='password' id='PasswordID' value=''>
								<label>Håll mig inloggad  :</label>
								<input type=checkbox name='checkbox'>
								<input type=submit name='Login' value='Logga in'>
							</fieldset>
						</form>
					</div>				
				";
		return $ret;
			
	}
}