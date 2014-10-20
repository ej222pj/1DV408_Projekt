<?php

namespace controller;

require_once("./model/RegisterModel.php");
require_once("./view/RegisterView.php");

class RegisterController {
	private $registerView;
	
	private $registerModel;
	
	private $Message = "";

	public function __construct() {
		$this->registerModel = new \model\RegisterModel();
		
		$this->registerView = new \view\RegisterView($this->registerModel);
	}
	
	public function doRegister(){
		$regusername = $this->registerView->getUsername();
		$regpassword = $this->registerView->getPassword();
		$repregpassword = $this->registerView->getRepPassword();

		//Kollar om man vill registrera sig. Kollar om allt stämmer.
		if(strlen($regusername) > 2 && strlen($regpassword) > 5 && $repregpassword == $regpassword){
			if($this->registerModel->compareUsername($regusername)){
				if($this->registerModel->addUser($regusername, $regpassword)){
					$this->Message = "Registrering av ny användare lyckades";		
					$this->registerView->setUsername($regusername);		
					return $this->registerView->HTMLPage($this->Message);
				}
			}
			else{//Sätter användarnamnet i Namnboxen
				$this->registerView->setUsername($regusername);
				$this->Message = "Användarnamnet är redan upptaget";
			}
			return $this->registerView->HTMLPage($this->Message);	
		}
		return $this->registerView->HTMLPage($this->Message);	
	}
}