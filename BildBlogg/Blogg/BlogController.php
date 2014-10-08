<?php

require_once("BlogModel.php");
require_once("BlogView.php");
//require_once('./Login/index.php');
require_once("./HTMLView.php");
require_once("./Login/Controller.php");
require_once("./Register/RegisterController.php");


class BlogController {
	private $view;
	private $model;
	

	public function __construct() {
		$this->model = new BlogModel();
		$this->view = new BlogView($this->model);
	}
	
	public function BlogControl(){
		if($this->view->didUserPressLoginView()){
			//Skapar ny controller
			$c = new Controller();
			$HTMLBody = $c->doLogin();
			
			//Skapar ny HTMLView
			$view = new HTMLView();
			$view->echoHTML($HTMLBody);
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