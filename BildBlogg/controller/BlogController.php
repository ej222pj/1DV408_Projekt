<?php

namespace controller;

require_once("./model/BlogModel.php");
require_once("./model/LoginModel.php");
require_once("./model/RegisterModel.php");
require_once("./view/BlogView.php");
require_once("./view/LoginView.php");
require_once("./view/RegisterView.php");


class BlogController{
	private $blogView;
	private $loginView;
	Private $registerView;
	private $blogModel;
	private $loginModel;
	private $registerModel;

	public function __construct() {
		$this->blogModel = new \model\BlogModel();
		$this->loginModel = new \model\LoginModel();
		$this->registerModel = new \model\RegisterModel();
		
		$this->blogView = new \view\BlogView($this->blogModel);
		$this->loginView = new \view\LoginView($this->loginModel);
		$this->registerView = new \view\RegisterView($this->registerModel);
	}
	
	public function BlogControl(){
		$Message = "";
		$_SESSION['UserWantsToLogin'] = false;
		if($this->loginView->didUserPressLogin()){
			$ret = $this->doLogin();
			return $ret;
		}
		elseif($this->registerView->didUserPressRegisterNew()){
			$ret = $this->doRegister();
			return $ret;
		}
		elseif($this->loginView->didUserPressLogout()){
			$ret = $this->doLogin();
			return $ret;
		}
		elseif($this->loginModel->loginstatus() == false){
			$ret = $this->doLogin();
			return $ret;
		}
		elseif($this->blogView->didUserpressUpload()){
			$ret= $this->doUpload();
			return $ret;
		}
		else{
			return $this->blogView->HTMLPage($Message);
		}
	}
	//Laddar upp bilder.
	//Strukturen till denna koden är tagen ifrån
	//http://www.w3schools.com/php/php_file_upload.asp
	//Men jag har gjort en hel del ändringar
	public function doUpload(){
		$Message = "";
		$newPicName = "";
		$rubrik = $this->blogView->getRubrik();

		if ($this->blogModel->checkPic()){
			if ($_FILES["file"]["error"] > 0 || empty($rubrik)) {
				$Message = "Det gick inte att ladda upp bilden!";
			} 
			else{
				// if($this->blogModel->imgExists()){
				// } 
				// else{
					$newPicName = $this->blogModel->changeImgName($_FILES["file"]["name"]);
					$this->blogModel->saveImg($newPicName, $rubrik);
					$Message = $newPicName . " är uppladdad!";
				// }
			}
		}
		else {
			$Message = "Fel filformat";
		}
		return $this->blogView->HTMLPage($Message);
	}
	
	public function doLogin() {
		$Message = "";
		//Inloggning via cookies
		if($this->loginModel->loginstatus() == false){
			if($this->loginView->isRemembered()){
				if($this->loginModel->CheckloginWithCookie($this->loginView->getCookieUsername(), $this->loginView->getCookiePassword())){
					$this->blogView->setUser($this->loginView->getCookieUsername());	
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
				}
				else {
					$this->blogView->setUser($username);//Sätter användarnamnet som loggar in
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
		}
		return $this->blogView->HTMLPage($Message);
	}
	
	public function doRegister(){
		$Message = "";
		
		$regusername = $this->registerView->getUsername();
		$regpassword = $this->registerView->getPassword();
		$repregpassword = $this->registerView->getRepPassword();

		//Kollar om man vill registrera sig. Kollar om allt stämmer.
		if(strlen($regusername) > 2 && strlen($regpassword) > 5 && $repregpassword == $regpassword){
			if($this->registerModel->compareUsername($regusername)){
				if($this->registerModel->addUser($regusername, $regpassword)){
					$Message = "Registrering av ny användare lyckades";		
					$this->registerView->setUsername($regusername);		
					return $this->blogView->HTMLPage($Message);
				}
			}
			else{//Sätter användarnamnet i Namnboxen
				$this->registerView->setUsername($regusername);
				$Message = "Användarnamnet är redan upptaget";
			}
			return $this->blogView->HTMLPage($Message);		
		}
	}
}