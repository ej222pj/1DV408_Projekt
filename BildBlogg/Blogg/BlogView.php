<?php

class BlogView {
	private $model;

	public function __construct(BlogModel $model) {
		$this->model = $model;
	}
	
	public function didUserPressLoginView(){
		if(isset($_POST['LoginView'])){
			return true;
		}
	}
	
	public function didUserPressRegister(){
		if(isset($_POST['Register'])){
			return true;
		}
	}
	
	public function HTMLPage(){
		$ret = "";
			
			$ret = "
				<img src='./pic/bild.jpg' style='Width:960px;Height:200px' alt=''>
				<form method='post'>
						<input type=submit name='' value='Något'>
						<input type=submit name='LoginView' value='Logga in'>
						<input type=submit name='Register' value='Registrera'>
				</form>
			
			";
		
		return $ret;
	}
}