<?php

namespace view;

class RegisterView {
	private $model;
	private $message;
	private $RegUvalue = "";
	private $RegPvalue = "";
	private $RepRegPvalue = "";
	
	public function __construct(\model\RegisterModel $model) {
		$this->model = $model;
	}
	
	//Hämtar användarnamnet
	public function getUsername(){
		if(isset($_POST["regusername"])){
			 if($_POST["regusername"] !== $this->cleanInput($_POST["regusername"])){
			 	$this->message = "Användarnamnet innehåller ogiltiga tecken";
			 	$this->RegUvalue = $this->cleanInput($_POST["regusername"]);
			 }
			 else{
			 	return $this->cleanInput($_POST["regusername"]);
			 }
		}
	}
	
	//FILTER_SANITIZE_STRING
	//FILTER_FLAG_STRIP_LOW
	//This filter removes data that is potentially harmful for your application. 
	//It is used to strip tags and remove or encode unwanted characters.
	//Inte helt 100% på vad strip_low gör men hittade på Stackoverflow och de funkar.
	public function cleanInput($username){
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
		if(isset($_POST["regpassword"])){
			return $_POST["regpassword"];
		}
	}
	
	public function getRepPassword(){
		if(isset($_POST["repregpassword"])){
			return $_POST["repregpassword"];
		}
	}
	
	public function didUserPressRegister(){
		if(isset($_POST['Register'])){
			return true;
		}
		else{
			return false;
		}
	}
	
	public function didUserPressRegisterNew(){
		if(isset($_POST['RegisterNew'])){
			if(($_POST["regusername"]) == "" && ($_POST["regpassword"]) == ""){
				$this->RegUvalue = $_POST["regusername"];
				$this->message = "Användarnamnet har för få tecken. Minst 3 tecken!\nLösenordet har för få tecken. Minst 6 tecken";
			}
			elseif(strlen(($_POST["regusername"])) < 3){
				$this->RegUvalue = $_POST["regusername"];
				$this->message = "Användarnamnet har för få tecken. Minst 3 tecken";
			}
			elseif(($_POST["regpassword"]) == "" && ($_POST["regusername"]) != "" || strlen(($_POST["regpassword"])) < 6) {
					//var_dump(strlen(($_POST["regusername"])));
				$this->RegUvalue = $_POST["regusername"];
				$this->message = "Lösenordet har för få tecken. Minst 6 tecken";
			}
			elseif(($_POST["repregpassword"]) !== ($_POST["regpassword"])) {
				$this->RegUvalue = $_POST["regusername"];
				//$this->RegPvalue = $_POST["regpassword"]; Väljer att ta bort lösenordet
				$this->message = "Lösenorden matchar inte";
			}
			return true;
		}
		else{
			return false;
		}
	}
}