<?php
class IdentifiersController extends AppController {

	var $name = 'Identifiers';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->Identifier->recursive = 0;
		$this->set('identifiers', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Identifier.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('identifier', $this->Identifier->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Identifier->create();
			if ($this->Identifier->save($this->data)) {
				$this->Session->setFlash(__('The Identifier has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Identifier could not be saved. Please, try again.', true));
			}
		}
		$parts = $this->Identifier->Part->find('list');
		$this->set(compact('parts'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Identifier', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Identifier->save($this->data)) {
				$this->Session->setFlash(__('The Identifier has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Identifier could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Identifier->read(null, $id);
		}
		$parts = $this->Identifier->Part->find('list');
		$this->set(compact('parts'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Identifier', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Identifier->del($id)) {
			$this->Session->setFlash(__('Identifier deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>