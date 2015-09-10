<?php

class person
{
	public $person; //object from database, may be used to access other properties
	public $id; //string, required
	public $email; //string, format email
	public $fn; //string
	public $role; //string
	
	public function createFromObject($person)
	{
		$this->person = $person;
		$this->id = $person->id;
		$this->email = $person->email;
		$this->fn = $person->fn;
		$this->role = $person->role;
	}
	
	public function createFromValues($id, $email, $fn, $role)
	{
		$this->id = $id;
		$this->email = $email;
		$this->fn = $fn;
		$this->role = $role;
	}
	
}


?>
