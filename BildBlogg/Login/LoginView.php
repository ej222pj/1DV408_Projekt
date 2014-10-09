<?php

require_once('./Blogg/BlogView.php');

class LoginView {
	private $model;
	private $blogView;
	private $message;
	private $user;
	private $Uvalue = "";
	private $Pvalue = "";

	public function __construct(Model $model) {
		$this->model = $model;
		$this->blogView = new BlogView();
	}

	//Sätter kakor
	//Spara ner cookietiden i en fil
	//Kryptera lösenordet
	public function RememberMe(){
		setcookie('Username', $_POST["username"], time()+60*60*24*30);
		setcookie('Password', md5($_POST["password"]), time()+60*60*24*30);

		$CookieTime = time()+60*60*24*30;
		file_put_contents('CookieTime.txt', $CookieTime);

		$this->message = "Inloggning lyckades och vi kommer ihåg dig nästa gång!";
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
	//Sätter vilken person som loggat in
	public function setUser($username){
		$ret = $this->user = $username;
		return $ret;
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
			return $this->blogView->getUsername();
	}

	//Hämtar ut lösenordet
	public function getPassword(){
		return $this->blogView->getPassword();
	}

	//Kollar om man klickat på login knappen.
	//Kollar om användaren skickar med input och skriver ut felmeddelanden.
	//Sätter användanamnet till value på inmatningssträngen
	public function didUserPressLogin(){
		if(isset($_GET['Login'])){
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
			$this->message = "Du är nu utloggad!";
			$this->removeCookie();
			return true;
		}
		else {
			return false;
		}
	}

	//Skriver ut HTMLkod efter om användaren är inloggad eller inte.
	// public function HTMLPage($Message){
		// if(isset($_SESSION['user']) === false){
			// $_SESSION['user'] = $this->user;
		// }
		// $ret = "";
// 
		// setlocale(LC_ALL, 'swedish');
		// date_default_timezone_set('Europe/Stockholm');
		// $Todaytime = ucwords(strftime("%A,den %d %B år %Y. Klockan är [%H:%M:%S]."));	
// 
		// if($this->model->loginstatus()){
			// $ret = "<h1>Laborationskod ej222pj</h1>
					// <h2>" . $_SESSION['user'] . " är inloggad</h2>
			 		// <p>$this->message</p>
			 		// <p>$Message</p>
					// <form method ='post'>
						// <input type=submit name='Logout' value='Logga ut'>
					// </form>
					// <p>$Todaytime</p>";
					// return $ret;
		// }
// 		
		// if($this->model->loginstatus() == false) {
				// $ret = "
					// <h1>Laborationskod ej222pj</h1>
					// <form method ='post'>
						// <input type=submit name='Register' value='Registrera ny användare'>
					// </form>
					// <h2>Ej inloggad</h2>
					// <form method='post'>
						// <fieldset>
							// <legend>Login - Skriv in användarnamn och lösenord</legend>
							// <p>$this->message</p>							
							// <p>$Message</p>
							// <label>Användarnamn:</label>
							// <input type=text size=20 name='username' id='UserNameID' value='$this->Uvalue'>
							// <label>Lösenord:</label>
							// <input type=password size=20 name='password' id='PasswordID' value='$this->Pvalue'>
							// <label>Håll mig inloggad  :</label>
							// <input type=checkbox name='checkbox'>
							// <p><a href='?Login'>Logga ut</a></p>
							// <input type=submit name='Login' value='Logga in'>
						// </fieldset>
					// </form>
					// <p>$Todaytime</p>";	
					// return $ret;
		// }	
	// }
}