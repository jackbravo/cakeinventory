<?php
class FamiliesController extends AppController {

	var $name = 'Families';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->Family->recursive = 0;
		$this->set('families', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Family.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('family', $this->Family->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Family->create();
			if ($this->Family->save($this->data)) {
				$this->Session->setFlash(__('The Family has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Family could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Family', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Family->save($this->data)) {
				$this->Session->setFlash(__('The Family has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Family could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Family->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Family', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Family->del($id)) {
			$this->Session->setFlash(__('Family deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>