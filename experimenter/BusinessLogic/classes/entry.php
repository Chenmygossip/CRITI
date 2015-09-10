<?php

class entry
{
	public $id;
	public $subject_field;
	public $references; //array of objects
	public $transactions; //array of objects
	public $definitions; //array of objects
	public $notes; //array of strings
	public $external_references; //array of objects
	public $images; //array of objects
	public $languages; //array of objects
	
	public function __construct($languages)
	{
		$this->languages = $languages;
		
		$this->references = array();
		$this->transactions = array();
		$this->definitions = array();
		$this->notes = array();
		$this->external_references = array();
		$this->images = array();
	}
	
	public function clean()
	{
		if (empty($this->id) || $this->id=="") unset($this->id);
		if (empty($this->subject_field) || $this->subject_field=="") unset ($this->subject_field);
		
		if (empty($this->references) || count($this->references) < 1) unset ($this->references);
		else foreach ($this->references as $reference) $reference->clean();
		if (empty($this->transactions) || count($this->transactions) < 1) unset ($this->transactions);
		else foreach ($this->transactions as $transaction) $transaction->clean();
		if (empty($this->definitions) || count($this->definitions) < 1) unset ($this->definitions);
		else foreach ($this->definitions as $definition) $definition->clean();
		if (empty($this->notes) || count($this->notes) < 1) unset ($this->notes);
		else foreach ($this->notes as $note) $note->clean();
		if (empty($this->external_references) || count($this->external_references) < 1) unset ($this->external_references);
		else foreach ($this->external_references as $external_reference) $external_reference->clean();
		if (empty($this->images) || count($this->images) < 1) unset ($this->images);
		else foreach ($this->images as $image) $image->clean();
		if (empty($this->languages) || count($this->languages) < 1) unset ($this->languages);
		else foreach ($this->languages as $language) $language->clean();
		
	}
}

class reference
{
	public $content; //required string
	public $target; //required string
	
	public function __construct($content, $target)
	{
		$this->content = $content;
		$this->target = $target;
	}
	
	public function clean()
	{
		if (empty($this->content) || $this->content=="") unset ($this->content);
		if (empty($this->target) || $this->target=="") unset ($this->target);
	}
}

class transaction
{
	public $person; //string
	public $type; //must either be 'oriniation' or 'modification'
	public $date; //string
	public $target; //string
	
	public function clean()
	{
		if (empty($this->person) || $this->person=="") unset ($this->person);
		if (empty($this->type) || $this->type=="") unset ($this->type);
		if (empty($this->date) || $this->date=="") unset ($this->date);
		if (empty($this->date) || $this->date=="") unset ($this->date);
	}
}

class definition
{
	public $content; //string required
	public $source; //string
	
	public function __construct($content)
	{
		$this->content = $content;
	}
	
	public function clean()
	{
		if (empty($this->content) || $this->content=="") unset ($this->content);
		if (empty($this->source) || $this->source=="") unset ($this->source);
	}
}

class external_reference
{
	public $content; //required string
	public $target; //required string
	
	public function __construct($content, $target)
	{
		$this->content = $content;
		$this->target = $target;
	}
}

class image
{
	public $content; //required string
	public $target; //required string
	
	public function __construct($content, $target)
	{
		$this->content = $content;
		$this->target = $target;
	}
	
	public function clean()
	{
		if (empty($this->content) || $this->content=="") unset ($this->content);
		if (empty($this->target) || $this->target=="") unset ($this->target);
	}
}

class language
{
	public $code; //string
	public $definitions; //array of definition objects
	public $transactions; //array of transaction objects
	public $terms; //array of term objects
	
	public function __construct($code, $terms)
	{
		$this->code = $code;
		$this->terms = $terms;
		
		$this->definitions = array();
		$this->transactions = array();
	}
	
	public function addTerm($term)
	{
		array_push($this->terms, $term);
	}
	
	public function clean()
	{
		if (empty($this->code) || $this->code=="") unset ($this->code);
		
		if (empty($this->transactions) || count($this->transactions) < 1) unset ($this->transactions);
		else foreach ($this->transactions as $transaction) $transaction->clean();
		if (empty($this->definitions) || count($this->definitions) < 1) unset ($this->definitions);
		else foreach ($this->definitions as $definition) $definition->clean();
		if (empty($this->terms) || count($this->terms) < 1) unset ($this->terms);
		else foreach ($this->terms as $term) $term->clean();
	}
}

class term
{
	public $gender;//string: masculine|feminine|neuter|other
	public $source; //string
	public $projects; //array of strings
	public $status; //string: preferredTerm-admn-sts|admittedTerm-admn-sts|deprecatedTerm-admn-sts|supersededTerm-admn-sts
	public $term; //string required
	public $type; //string: fullForm|acronym|abbreviation|shortForm|variant|phrase
	public $customers; //array of strings
	public $geo; //string
	public $pos; //string: noun|verb|adjective|adverb|properNoun|other
	public $location; //string
	public $external_references; //array of external_reference objects
	public $references; //array of reference objects
	public $transactions; //array of transaction objects
	public $contexts; //array of context objects
	
	public function __construct($term)
	{
		$this->term = $term;
		
		$this->projects = array();
		$this->customers = array();
		$this->external_references = array();
		$this->references = array();
		$this->transactions = array();
		$this->contexts = array();
	}
	
	public function clean()
	{
		if (empty($this->gender) || $this->gender=="") unset ($this->gender);
		if (empty($this->source) || $this->source=="") unset ($this->source);
		if (empty($this->status) || $this->status=="") unset ($this->status);
		if (empty($this->term) || $this->term=="") unset ($this->term);
		if (empty($this->type) || $this->type=="") unset ($this->type);
		if (empty($this->geo) || $this->geo=="") unset ($this->geo);
		if (empty($this->location) || $this->location=="") unset ($this->location);
		if (empty($this->pos) || $this->pos=="") unset ($this->pos);
		
		if (empty($this->projects) || count($this->projects) < 1) unset ($this->projects);
		else foreach ($this->projects as $project) $project->clean();
		if (empty($this->customers) || count($this->customers) < 1) unset ($this->customers);
		else foreach ($this->customers as $customer) $customer->clean();
		if (empty($this->external_references) || count($this->external_references) < 1) unset ($this->external_references);
		else foreach ($this->external_references as $external_reference) $external_reference->clean();
		if (empty($this->references) || count($this->references) < 1) unset ($this->references);
		else foreach ($this->references as $reference) $reference->clean();
		if (empty($this->transactions) || count($this->transactions) < 1) unset ($this->transactions);
		else foreach ($this->transactions as $transaction) $transaction->clean();
		if (empty($this->contexts) || count($this->contexts) < 1) unset ($this->contexts);
		else foreach ($this->contexts as $context) $context->clean();
	}
}

class context
{
	public $content; //string required
	public $source; //string
	
	public function __construct($content)
	{
		$this->content = $content;
	}
	
	public function clean()
	{
		if (empty($this->content) || $this->content=="") unset ($this->content);
		if (empty($this->source) || $this->source=="") unset ($this->source);
	}
}
