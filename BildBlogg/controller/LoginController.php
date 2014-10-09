<?php

namespace controller;

require_once("LoginModel.php");
require_once("./Blogg/BlogView.php");
require_once("./Register/RegisterView.php");
require_once("./Register/RegisterModel.php");

class LoginController {
	private $view;
	//private $blogView;
	private $registerView;
	private $model;
	private $RegisterModel;

	public function __construct() {
		$this->model = new \model\LoginModel();
		$this->view = new \view\LoginView($this->model);
		//$this->blogView = new BlogView($this->model);
		$this->RegisterModel = new \model\RegisterModel();
		$this->registerView = new \view\RegisterView($this->RegisterModel);
	}

	//Kollar om användaren vill logga in
	
}