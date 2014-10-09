<?php

namespace model;

require_once('./model/LoginModel.php');    
	
//Hur ska jag spara bilder?

class BlogModel {
	
	public function __construct() {
		$this->loginModel = new LoginModel();
	}
	
	public function loginStatus(){
		return $this->loginModel->loginstatus();
	}
}
	