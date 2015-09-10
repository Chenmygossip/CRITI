<?php

class tbxImporter
{
	private $path;
	private $name;
	private $file;
		
	public function __construct($filePath, $fileName)
	{
		$this->path = SERVER."/import";
		$this->file = $filePath;
		$this->name = $fileName;
	}
	
	public function post()
	{
		$apiCaller = new apiCaller();
		
		$post = array(
			'file'=>'@'.$this->file,
			'name'=>$this->name
		);
		
		$result = $apiCaller->post($this->path, $post);
		return $result;
	}
	
	
}



?>
