<?php
class PartsController extends AppController {

	var $name = 'Parts';
	var $helpers = array('Html', 'Form', 'Javascript', 'xls');
    var $pageTitle = 'Inventario';
	var $paginate = array(
		'Part' => array('limit' => 9999),
		'Entry' => array(
            'limit' => 9999,
            'recursive' => -1,
            'order' => array('Part.number', 'Entry.id'),
            'fields' => array('Entry.id', 'Part.id', 'Identifier.id', 'Part.family_id',
                'Entry.pieces', 'Entry.dispatch_id', 'Entry.receipt_id', 'Entry.created', 'Entry.comments',
                'Part.number', 'Part.long', 'Part.width', 'Part.height', 'Part.first_code',
                'Identifier.number',
            ),
            'joins' => array(
                array(
                    'table' => 'parts',
                    'alias' => 'Part',
                    'type' => 'INNER',
                    'conditions' => array('Part.id = Entry.part_id'),
                ),
                array(
                    'table' => 'identifiers',
                    'alias' => 'Identifier',
                    'type' => 'LEFT',
                    'conditions' => array('Identifier.entry_id = Entry.id'),
                ),
            ),
        ),
	);
	function index() {
        $families = $this->Part->Family->find('list', array('Family.name'));
		$this->set('families', $families);

        $options = array('Entry.active' => 1);
        if (isset($this->params['named']['family']))
        {
            $options['Part.family_id'] = $this->params['named']['family'];
            $this->set('family_id', $this->params['named']['family']);
        } 
        $entries = $this->paginate('Entry', $options);
        $this->set('entries', $entries);
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Part.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('part', $this->Part->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Part->create();
			if ($this->Part->save($this->data)) {
				$this->Session->setFlash(__('The Part has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Part could not be saved. Please, try again.', true));
			}
		}
		$families = $this->Part->Family->find('list');
		$this->set(compact('families'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Part', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Part->save($this->data)) {
				$this->Session->setFlash(__('The Part has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Part could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Part->read(null, $id);
		}
		
		$this->Part->Entry->recursive = null;
		$entries = $this->Part->Entry->find('all', array('conditions' => array('Entry.part_id' => $id)));		
		
		$families = $this->Part->Family->find('list');
		$this->set(compact('families', 'entries'));
	}

    function ajax($id = null, $dim = null)
    {
        $this->layout = 'ajax';
        if ($id == null)
        {
            $family = $this->params['named']['family'];
            if ($family <= 0)
            {
                $this->set('nothingSelected',1);
            }
            else
            {
                $this->Part->recursive = -1;
                $parts = $this->Part->find('all',array(
                    'conditions'=>'family_id = '.$family,
                    'order' => array('Part.number'),
                    'group' => array('Part.number'),
                ));
                $this->set('parts', $parts);
            }
        }
        else
        {
            $part = $this->Part->read(null, $id);
            if ($dim == 'all') {
                echo json_encode($part['Part']);
                exit;
            } else {
                $this->set('dim', $part['Part'][$dim]);
            }
        }
    }
    
	function export($family = null) {
        $families = $this->Part->Family->find('list', array('Family.name'));
		$this->set('families', $families);

        $options = $this->paginate['Entry'];
        $options['conditions'] = array('Entry.active' => 1, 'Entry.part_id !=' => 0);
        if ($family)
        {
            $options['conditions']['Part.family_id'] = $family;
        } 
        $entries = $this->Part->Entry->find('all', $options);
        $this->set('entries', $entries);
	}    

}
?>
