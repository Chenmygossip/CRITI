<?php

class termbase
{
	private $path;
	private $apiCaller;
	private $originalId; //used when updating
	public $working_language;
	public $baseId;
	public $name;
	
	public function __construct()
	{
		$this->apiCaller = new apiCaller();
	}
	
	//termbaseController
	public function loadFromId($id) //fetch object info
	{
		$baseId = $id;
		$this->originalId = $id;
		$this->path = SERVER."/termbases/".$baseId;
		
		$result = json_decode($this->apiCaller->get($this->path));
		
		$this->baseId = $result->id;
		$this->working_language = $result->working_language;
		$this->name = $result->name;
	}
	
	public function createFromValues($working_language, $baseId, $name) //post
	{
		$this->working_language = $working_language;
		$this->baseId = $baseId;
		$this->name = $name;
		$this->path = SERVER."/termbases";

		$post = json_encode(array(
			'id'=>$this->baseId,
			'working_language'=>$this->working_language,
			'name'=>$this->name
		));
		
		$result = $this->apiCaller->post($this->path, $post);
		
		return $result;
	}
	
	public function update()
	{
		$this->path = SERVER."/termbases/".$this->originalId;

		$post = array(
			
			'working_language'=>$this->working_language,
			'name'=>$this->name
		);
		
		$result = $this->apiCaller->put($this->path, $post);
		
		return $result;
	}
	
	public function get()
	{
		if (empty($this->id)) return "Please Load ID FIRST";
		$result = $this->apiCaller->get($this->path);
		
		return $result;
	}
	
	public function delete()
	{
		$result = $this->apiCaller->delete($this->path);
		
		return $result;
	}
	//end termbase controller
	
	//export
	public function export() //returns xml string
	{
		$exportPath = $this->path."/export";
		$result = $this->apiCaller->get($exportPath);
		
		
		return $result;
	}
	
	public function exportToFile() //returns temp file name for download, is not perfect
	{
		$termbase = json_decode($this->apiCaller->get($this->path));
		
		$exportPath = $this->path."/export";
		$result = $this->apiCaller->get($exportPath);
		
		$tmpName = tempnam(sys_get_temp_dir(), $termbase->name);
		$tbxFile = fopen($tmpName, 'w');
		
		fwrite($tbxFile, $result);
		
		header('Content-Description: File Transfer');
		header('Content-Type: text/xml');
		header('Content-Disposition: attachment; filename='.$termbase->name);
		header('Cache-Control: must-revalidate');
		header('Content-Length: '.filesize($tmpName));
		
		ob_clean();
		flush();
		readfile($tmpName);
		
		unlink($tmpName);
		
		return $result;
	}
	//end export
	
	//Person Controller
	public function getPeople()
	{
		$peoplePath = $this->path."/people";
		
		$result = $this->apiCaller->get($peoplePath);
		
		return $result;
	}
	
	public function postPerson($person) //person object
	{
		$peoplePath = $this->path."/people";
		
		$data = array(
			'id'=> $person->id,
			'email'=> $person->email,
			'fn'=> $person->fn,
			'role'=> $person->role
		);

		$result = $this->apiCaller->post($peoplePath, $data);
		
		return $result;
	}
	
	public function updatePerson($person)
	{
		$peoplePath = $this->path."/people/".$person->id;
		
		$data = array(
			'id'=> $person->id,
			'email'=> $person->email,
			'fn'=> $person->fn,
			'role'=> $person->role
		);
		
		$result = $this->apiCaller->put($peoplePath, $data);
		
		return $result;
		
	}
	
	public function deletePerson($person)
	{
		$peoplePath = $this->path."/people/".$person->id;
		
		$result = $this->apiCaller->delete($peoplePath);
		
		return $result;
	}
	//END Person controller
	
	
	//Entry Controller
	public function getEntries()
	{
		$entriesPath = $this->path."/entries";
		$result = $this->apiCaller->get($entriesPath);
		
		return $result;
	}
	
	public function addEntry($entry)
	{
		$entriesPath = $this->path."/entries";
		$entry->clean();
		$result = $this->apiCaller->post($entriesPath, json_encode($entry));
		
		return $result;
	}
	
	public function updateEntry($entry)
	{
		$entriesPath = $this->path."/entries/".$entry->id;
		$entry->clean();
		$result = $this->apiCaller->put($entriesPath, $entry);
		
		return $result;
	}
	
	public function deleteEntry($entryId)
	{
		$entriesPath = $this->path."/entries/".$entryId;
		$result = $this->apiCaller->delete($entriesPath);
		
		return $result;
	}
	//END entry controller
	
}



?>
