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
		
		if($this->registerView->didUserPressRegisterNew()){
			if($regusername == "" && $regpassword == ""){
				$this->registerView->setUsernameAndStatusMessage($regusername, "Användarnamnet har för få tecken. Minst 3 tecken!\nLösenordet har för få tecken. Minst 6 tecken");
				return $this->registerView->HTMLPage($this->Message);
			}
			elseif(strlen($regusername) < 3){
				$this->registerView->setUsernameAndStatusMessage($regusername, "Användarnamnet har för få tecken. Minst 3 tecken");
				return $this->registerView->HTMLPage($this->Message);
			}
			elseif($regpassword == "" && $regusername != "" || strlen($regpassword) < 6) {
				$this->registerView->setUsernameAndStatusMessage($regusername, "Lösenordet har för få tecken. Minst 6 tecken");
				return $this->registerView->HTMLPage($this->Message);
			}
			elseif($repregpassword !== $regpassword) {
				$this->registerView->setUsernameAndStatusMessage($regusername, "Lösenorden matchar inte");
				return $this->registerView->HTMLPage($this->Message);
			}
			
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
		}
		return $this->registerView->HTMLPage($this->Message);
	}
}