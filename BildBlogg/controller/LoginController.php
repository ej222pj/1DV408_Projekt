<?php

namespace controller;

require_once("./model/LoginModel.php");
require_once("./model/BlogModel.php");

require_once("./view/LoginView.php");
require_once("./view/BlogView.php");

class LoginController {
	private $loginView;
	private $loginModel;
	private $blogView;
	private $blogModel;
	private $model;


	public function __construct() {
		$this->loginModel = new \model\LoginModel();
		$this->loginView = new \view\LoginView($this->loginModel);
		
		$this->blogModel = new \model\BlogModel();
		$this->blogView = new \view\BlogView($this->blogModel);
	}

	//Kollar om användaren vill logga in
		public function doLogin() {
		$Message = "";
		$User = "";
		//Inloggning via cookies
		if($this->loginModel->loginstatus() == false){
			if($this->loginView->isRemembered()){
				if($this->loginModel->CheckloginWithCookie($this->loginView->getCookieUsername(), $this->loginView->getCookiePassword())){
					$User = $this->loginView->getCookieUsername();	
					$Message = "Inloggning lyckades via cookies!";
				}else{
					$this->loginView->removeCookie();
					$Message = "Felaktig information i cookie!";
				}
			}
		}
	
		//Hämtar ut användarnamnet och lösenordet.
		$username = $this->loginView->getUsername();
		$password = $this->loginView->getPassword();

		//Kollar om användaren vill logga in.
		//Kollar så att det är rätt användarnamn och lösenord. Om inte, skicka felmeddelande.
			if($username != "" && $password != ""){
				if($this->loginModel->Checklogin($username, $password) == false){
					$Message = "Felaktigt användarnamn och/eller lösenord";
					return $this->loginView->HTMLPage($Message);
				}
				else {
					$User = $username;//Sätter användarnamnet som loggar in
					//Kollar om användaren vill hålla sig inloggd
					if($this->loginView->Checkbox()){
						$this->loginView->RememberMe();
						$Message = "Inloggning lyckades och vi kommer ihåg dig nästa gång!";
						
					}else{
						$Message = "Inloggningen lyckades!";
					}
				}
			}
		//Kollar om man klickat på logout knappen.
		//Anropar logout funktionen som förstör sessionen.
		if($this->loginView->didUserPressLogout()){
			$this->loginModel->logout();
			$Message = "Du är nu utloggad!";
			return $this->loginView->HTMLPage($Message);
		}
		return $this->blogView->HTMLPage($Message);
	}
}