<?php

require_once("BlogModel.php");
require_once("BlogView.php");
require_once("./HTMLView.php");
require_once("./Login/Controller.php");
require_once("./Register/RegisterController.php");


class BlogController {
	private $view;
	private $model;
	private $LController;

	public function __construct() {
		$this->model = new BlogModel();
		$this->view = new BlogView($this->model);
		$this->LController = new LoginController();
	}
	
	public function BlogControl(){
		if($this->view->didUserPressLoginView()){
			$_SESSION['UserWantsToLogin'] = true;
			$this->LController->doLogin();
		}
		elseif($this->view->didUserPressRegister()){
			//Skapar ny controller
			$c = new RegisterController();
			$HTMLBody = $c->doRegister();
			
			//Skapar ny HTMLView
			$view = new HTMLView();
			$view->echoHTML($HTMLBody);
		}
		else{
			return $this->view->HTMLPage();
		}
	}
}