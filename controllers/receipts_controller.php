<?php
class ReceiptsController extends AppController {

	var $name = 'Receipts';
	var $helpers = array('Html', 'Form', 'Javascript');
	var $pageTitle = 'Entradas';
    var $paginate = array(
    				'limit' => 50,
                    'order'=>
                        array('id'=>'desc')
                    );

	function index() {
	   if (!empty($this->params['form']))
       {
            $date1 = $this->params['form']['date-1'].'-'.
                     $this->params['form']['date-1-mm'].'-'.
                     $this->params['form']['date-1-dd'];
            $date2 = $this->params['form']['date-2'].'-'.
                     $this->params['form']['date-2-mm'].'-'.
                     $this->params['form']['date-2-dd'];
    		$this->Receipt->recursive = 0;
    		$this->set('receipts', $this->paginate(array('created BETWEEN \''.$date1.'\' AND \''.$date2.'\'')));
        }
        else
        {
            $this->Receipt->recursive = 0;
            $this->set('receipts', $this->paginate());
        }
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Receipt.', true));
			$this->redirect(array('action'=>'index'));
		}
        $this->Receipt->recursive = -1;
		$this->set('receipt', $this->Receipt->read(null, $id));
        $entries = $this->Receipt->Entry->find('all',array(
            'conditions'=>array('receipt_id'=>$id),
            'order'=>array('Entry.id'),
        ));
        $this->set('entries', $entries);
        
        $families = $this->Receipt->Entry->Part->Family->find('list',
            array('fields'=>array('Family.name')));
        
        $partsByFamily = array();
        
        foreach($entries as $entry)
        {
            $family_id = $entry['Part']['family_id'];
            $entry['Family'] = $families[$family_id];
            $partsByFamily[$family_id][] = $entry;
        }
        
        $this->set('partsByFamily', $partsByFamily);
	}

	function add($save = null) {
	    if ($save != null)
        {
            $this->data = unserialize($this->Session->read('data'));
        }
        
		if (!empty($this->data)) {
            
            $savedOK = true;
            
			$this->Receipt->create();
            if ($save != null)
            {
                $savedOK = $this->Receipt->save() & $savedOK;    
            }
            else
            {
                $savedOK = $this->Receipt->validates() & $savedOK;
            }
            
            $receipt_id = $this->Receipt->getInsertID();
            $totalEntries = count($this->data['Receipt']['Family']);
            
            for ($i=0; $i<$totalEntries; $i++)
            {
                if($this->data['Receipt']['Family'][$i] == '')
                {
                    continue;
                }
                if($this->data['Receipt']['Part'][$i] == 'new')
                {
                    if ($this->data['Receipt']['Part']['new'][$i] == '')
                    {
                        continue;
                    }
                    $this->Receipt->Entry->Part->create();
                    $this->Receipt->Entry->Part->set(array(
                        'family_id' => $this->data['Receipt']['Family'][$i],
                        'number' => $this->data['Receipt']['Part']['new'][$i]
                    ));
                }
                else
                {
                    $this->Receipt->Entry->Part->read(null, $this->data['Receipt']['Part'][$i]);
                }
                
                $this->Receipt->Entry->Part->set(array(
                    'long' => $this->data['Receipt']['long'][$i],
                    'width' => $this->data['Receipt']['width'][$i],
                    'height' => $this->data['Receipt']['height'][$i],
                ));
                if ($save == null)
                {
                    $savedOK = $this->Receipt->Entry->Part->validates() & $savedOK;
                    $part_id = '-1';
                }
                else
                {
                    $savedOK = $this->Receipt->Entry->Part->save() & $savedOK;
                    $part_id = $this->Receipt->Entry->Part->id;
                }                
                
                $this->Receipt->Entry->create();
                $this->Receipt->Entry->set(array(
                    'part_id' => $part_id,
                    'receipt_id' => $receipt_id,
                    'pieces' => $this->data['Receipt']['pieces'][$i],
                    'comments' => $this->data['Receipt']['comments'][$i]
                ));
                if ($save != null)
                {
                    $savedOK = $this->Receipt->Entry->save() & $savedOK;
                }
                else
                {
                    $savedOK = $this->Receipt->Entry->validates() & $savedOK;
                }
                
                $entry_id = $this->Receipt->Entry->id;
                // save first code if MUV family
                if($save && $this->data['Receipt']['Part'][$i] == 'new' && $this->data['Receipt']['Family'][$i] == 1)
                {
                    $this->Receipt->Entry->Part->set('first_code', $entry_id);
                    $this->Receipt->Entry->Part->save();
                }
                
                if (isset($this->data['Receipt']['Identifier']) && 
                    isset($this->data['Receipt']['Identifier'][$i]) &&
                    $this->data['Receipt']['Identifier'][$i] != '')
                {
                    $this->Receipt->Entry->Part->Identifier->create();
                    $this->Receipt->Entry->Part->Identifier->set(array(
                        'part_id' => $part_id,
                        'entry_id' => $entry_id,
                        'number' => $this->data['Receipt']['Identifier'][$i]
                    ));
                    if ($save != null)
                    {
                        $savedOK = $this->Receipt->Entry->Part->Identifier->save() & $savedOK;
                    }
                    else
                    {
                        $savedOK = $this->Receipt->Entry->Part->Identifier->validates() & $savedOK;
                    }
                }
            }
            
            if ($savedOK) {
                if ($save == null)
                {
                    $this->Session->write('data',serialize($this->data));
                    $this->redirect(array('action'=>'add','save'));
                }
                
    			$this->Session->setFlash(__('La entrada ha sido guardada.', true));
    			$this->redirect(array('action'=>'view',$receipt_id));
    		} else {
                $this->Session->setFlash(__('La entrada no pudo ser guardada correctamente, intente de nuevo.', true));
                $this->redirect(array('action'=>'add'));              
    		}
 
		}
        App::import('model','Family');
        $this->Family = new Family();
        $families = $this->Family->find('list');
        $this->set(compact('families'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Receipt', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Receipt->save($this->data)) {
				$this->Session->setFlash(__('The Receipt has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Receipt could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Receipt->read(null, $id);
		}
		$entries = $this->Receipt->Entry->find('list');
		$this->set(compact('entries'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Receipt', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Receipt->del($id)) {
			$this->Session->setFlash(__('Receipt deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

	
	function barcode($id = null){
		$this->layout = null;
		if (!$id) {
			$this->Session->setFlash(__('Invalid Receipt.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('receipt', $this->Receipt->read(null, $id));
        $this->Receipt->Entry->recursive = 1;
        $entries = $this->Receipt->Entry->find('all',array(
                    'conditions'=>array('receipt_id'=>$id)));
        $this->set('entries', $entries);
        
        $families = $this->Receipt->Entry->Part->Family->find('all',array('recursive'=>'0'));
        
        $partsByFamily = array();
        
        foreach($entries as $entry)
        {
            $part_id = $entry['Part']['id'];
            $part = $this->Receipt->Entry->Part->read(null, $part_id);
            $family_id = $part['Family']['id'];
            
            $partsByFamily[$family_id][] = $part;
        }
        
        $this->set('partsByFamily', $partsByFamily);
        
	}

}
?>
