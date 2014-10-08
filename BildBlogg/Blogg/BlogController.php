<?php

require_once("BlogModel.php");
require_once("BlogView.php");
require_once('./Register_Login/index.php');

class BlogController {
	private $view;
	private $model;

	public function __construct() {
		$this->model = new BlogModel();
		$this->view = new BlogView($this->model);
	}
	
	public function BlogControl(){
		if($this->view->didUserPressLogin()){
			$this->loginView->
		}
		return $this->view->HTMLPage();
	}
}