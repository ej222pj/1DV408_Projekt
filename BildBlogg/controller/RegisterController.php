<?php

namespace controller;

require_once("./Login/LoginModel.php");
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

	
}