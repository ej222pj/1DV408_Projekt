<?php

require_once("./Login/Model.php");
require_once("./Login/LoginView.php");
require_once("RegisterView.php");
require_once("RegisterModel.php");

class RegisterController {
	private $view;
	private $registerView;
	private $model;
	private $RegisterModel;

	public function __construct() {
		$this->model = new Model();
		$this->view = new LoginView($this->model);
		$this->RegisterModel = new RegisterModel();
		$this->registerView = new RegisterView($this->RegisterModel);
	}

	public function doRegister(){
		$Message = "";
		
		$regusername = $this->registerView->getUsername();
		$regpassword = $this->registerView->getPassword();
		$repregpassword = $this->registerView->getRepPassword();
		
		//Kollar om man vill registrera sig. Kollar om allt stämmer.
		if($this->registerView->didUserPressRegisterNew()){
			if(strlen($regusername) > 2 && strlen($regpassword) > 5 && $repregpassword == $regpassword){
				if($this->model->compareUsername($regusername)){
					if($this->RegisterModel->addUser($regusername, $regpassword)){
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
	}
}