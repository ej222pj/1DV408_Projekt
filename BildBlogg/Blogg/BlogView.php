<?php

class BlogView {
	private $model;

	public function __construct(BlogModel $model) {
		$this->model = $model;
	}
	
	public function didUserPressLogin(){
		if(isset($_POST['Login'])){
			return true;
		}
	}
	
	public function HTMLPage(){
		//$ret = "";
			
		$ret = "
			<img src='./pic/bild.jpg' style='Width:960px;Height:200px' alt=''>
			<form method='post'>
					<input type=submit name='' value='Något'>
					<input type=submit name='Login' value='Logga in'>
					<input type=submit name='RegisterNew' value='Registrera'>
			</form>
		
		";
		
		return $ret;
	}
}