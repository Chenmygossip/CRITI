<?php

class termbases
{
	private $path;
	
	public function __construct()
	{
		$this->path = SERVER."/termbases";
	}
	
	public function get()
	{
		$apiCaller = new apiCaller();
		$result = $apiCaller->get($this->path);
		
		return $result;
	}
	
}



?>
