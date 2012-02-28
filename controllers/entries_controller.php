<?php
class EntriesController extends AppController {

	var $name = 'Entries';
	var $helpers = array('html', 'form', 'javascript');
	var $components = array('RequestHandler');
	var $paginate = array(
		'Entries' => array('limit' => 50)
	);
	

	function index() {
		$this->Entry->recursive = 0;
		$this->set('entries', $this->paginate());
	}

	function view($id = null) {
	$entry = $this->Entry->read(null, $id);

	if(!empty($entry['Entry']['receipt_id'])){
		$redirect = $entry['Entry']['receipt_id'];
	} elseif(!empty($entry['Entry']['dispatch_id'])) {
		$redirect = $entry['Entry']['dispatch_id'];
	} else {
		$this->redirect(array('controller'=>'parts','action'=>'index'));
	}

		if (!$id) {
			$this->Session->setFlash(__('Invalid Entry.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->redirect(array('controller'=>'receipts', 'action'=>'view', $redirect ));
		//$this->set('entry', $this->Entry->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Entry->create();
			if ($this->Entry->save($this->data)) {
				$this->Session->setFlash(__('The Entry has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Entry could not be saved. Please, try again.', true));
			}
		}
		$parts = $this->Entry->Part->find('list');
		$this->set(compact('parts'));
	}

	function edit($id = null) {
		$this->Entry->id = $_REQUEST['id'];
		$this->Entry->saveField('comments', $_REQUEST['value']);
	
		$entry = $this->Entry->read(null, $id);

		Configure::write('debug', 0);

		echo str_replace("\n", "<br>", $entry['Entry']['comments']);
		exit();
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Entry', true));
			$this->redirect(array('action'=>'index'));
		}
        $entry = $this->Entry->read(array('dispatch_id', 'receipt_id', 'id'), $id);
        $entry = $entry['Entry'];
        $from = $this->params['named']['from'];
        $from_id = ($from == 'dispatches') ? $entry['dispatch_id'] : $entry['receipt_id'];
        if ($from == 'dispatches' && !empty($entry['receipt_id'])) {
            $this->Entry->set('dispatch_id', null);
            $this->Entry->save();
        }
		else {
            $this->Entry->del($id);
        }
        $this->Session->setFlash(__('Item borrado', true));
        $this->redirect(array('controller'=>$from, 'action'=>'view', $from_id));
	}
	


}
