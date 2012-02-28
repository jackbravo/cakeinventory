<?php

/**
 * @author Pavooou
 * @copyright 2009
 */

class EntradasController extends AppController {

	var $name = 'Entrada';	
	var $uses = array('Entries','Parts','Identifiers','Families');
	var $paginate = array(
		'Entradas' => array('limit' => 50)
	);
	
	function index() 
	{
		$this->__validateLoginStatus();
		$this->Entry->recursive = 0;
		$this->set('entries', $this->paginate());
	}
	
	function add()
	{
		$this->__validateLoginStatus();
	}

	
	private function __validateLoginStatus()
	{
		if($this->Session->check('User') == false)
		{
			$this->redirect(array('controller'=>'users','action'=>'login'));
			$this->Session->setFlash('The URL you\'ve followed requires you login.');
		}
	}
	
}

?>