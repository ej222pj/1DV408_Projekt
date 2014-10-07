<?php

require_once("Model.php");
require_once("LoginView.php");
require_once("RegisterView.php");

class Controller {
	private $view;
	private $registerView;
	private $model;

	public function __construct() {
		$this->model = new Model();
		$this->view = new LoginView($this->model);
		$this->registerView = new RegisterView($this->model);
	}

	//Kollar om användaren vill logga in
	public function doLogin() {
		$Message = "";
		
		//Inloggning via cookies
		if($this->model->loginstatus() == false){
			if($this->view->isRemembered()){
				if($this->model->CheckloginWithCookie($this->view->getCookieUsername(), $this->view->getCookiePassword())){
					$this->view->setUser($this->view->getCookieUsername());	
					$Message = "Inloggning lyckades via cookies!";
				}else{
					$this->view->removeCookie();
					$Message = "Felaktig information i cookie!";
				}
			}
		}
		
		$regusername = $this->registerView->getUsername();
		$regpassword = $this->registerView->getPassword();
		$repregpassword = $this->registerView->getRepPassword();
		
		//Kollar om man vill registrera sig. Kollar om allt stämmer.
		if($this->registerView->didUserPressRegisterNew()){
			if(strlen($regusername) > 2 && strlen($regpassword) > 5 && $repregpassword == $regpassword){
				if($this->model->compareUsername($regusername)){
					if($this->model->addUser($regusername, $regpassword)){
						$Message = "Registrering av ny användare lyckades";		
						$this->view->setUsername($regusername);		
						return $this->view->HTMLPage($Message);
					}
				}
				else{//Sätter användarnamnet i Namnboxen
					$this->registerView->setUsername($regusername);
					$Message = "Användarnamnet är redan upptaget";
				}
			}
			return $this->registerView->registerPage($Message);
		}
		//Registrera ny användare
		//Öppnar registerpage viewn
		if($this->registerView->didUserPressRegister()){
			return $this->registerView->registerPage($Message);
		}
		
		
		//Hämtar ut användarnamnet och lösenordet.
		$username = $this->view->getUsername();
		$password = $this->view->getPassword();

		//Kollar om användaren vill logga in.
		//Kollar så att det är rätt användarnamn och lösenord. Om inte, skicka felmeddelande.
		if($this->view->didUserPressLogin()){
			if($username != "" && $password != ""){
				if($this->model->Checklogin($username, $password) == false){
					$Message = "Felaktigt användarnamn och/eller lösenord";
				}
				else {
					$this->view->setUser($username);//Sätter användarnamnet som loggar in
					//Kollar om användaren vill hålla sig inloggd
					if($this->view->Checkbox()){
						$this->view->RememberMe();
					}else{
						$Message = "Inloggningen lyckades!";
					}
				}
			}
		}

		//Kollar om man klickat på logout knappen.
		//Anropar logout funktionen som förstör sessionen.
		if($this->view->didUserPressLogout()){
			$this->model->logout();
		}

		return $this->view->HTMLPage($Message);
	}
}