<?php
class DispatchesController extends AppController {

	var $name = 'Dispatches';
	var $helpers = array('Html', 'Form', 'Javascript');
	var $pageTitle = 'Salidas';
    var $paginate = array(
                    'order'=> array('id'=>'desc'),
                    'limit'=> 50,
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
    		$this->Dispatch->recursive = 0;
    		$this->set('dispatches', $this->paginate(array('created BETWEEN \''.$date1.'\' AND \''.$date2.'\'')));
        }
        else
        {
            $this->Dispatch->recursive = 0;
            $this->set('dispatches', $this->paginate());
        }
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Receipt.', true));
			$this->redirect(array('action'=>'index'));
		}
        $this->Dispatch->recursive = -1;
		$this->set('dispatch', $this->Dispatch->read(null, $id));
        $entries = $this->Dispatch->Entry->find('all',array(
            'conditions'=>array('dispatch_id'=>$id),
            'order'=>array('Entry.id'),
        ));
        $this->set('entries', $entries);
        
        $families = $this->Dispatch->Entry->Part->Family->find('list',
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

    function preview()
    {
        if (!empty($this->data)) {
            if (isset($this->data['codes']))
            {
                $text = $this->data['codes']; 
                $lines = explode("\r",$text);
                $isThereAMUV = false;
                foreach($lines as $id)
                {
                    $entries[] = $this->Dispatch->Entry->read(null, $id);
                    $family = $this->Dispatch->Entry->Part->Family->read(null, 
                                $entries[count($entries)-1]['Part']['family_id']);
                    if ($family['Family']['name'] == 'MUV')
                    {
                        $isThereAMUV = true;
                    }
                }
                
                $this->Session->write('entries', serialize($entries));
                if (!$isThereAMUV)
                {
                    $this->redirect(array('action'=>'add'));
                }
                else
                {
                    for($index =0; $index<count($entries); $index++)
                    {
                        $family = $this->Dispatch->Entry->Part->Family->read(null, 
                                $entries[$index]['Part']['family_id']);
                        if ($family['Family']['name'] != 'MUV')
                        {
                            continue;
                        }
                        $part = $this->Dispatch->Entry->Part->read(null, $entries[$index]['Part']['id']);
                        $totalPieces = 0;
                        foreach($part['Entry'] as $entry)
                        {
                            // SI NO HAY DISPATCH ID, QUIERE DECIR QUE ES UNA SALIDA
                            if ($entry['dispatch_id'] != null)
                            {
                                $totalPieces -= $entry['pieces'];
                            }
                            // SI HAY RECEIPT ID, QUIERE DECIR QUE ES UNA ENTRADA
                            if ($entry['receipt_id'] != null)
                            {
                                $totalPieces += $entry['pieces'];
                            }
                        }
                        $entries[$index]['Part']['totalPieces'] = $totalPieces;
                    }
        
                    $this->set('entries',$entries);
                }
            }
            else
            {
                return;
            }
        }
    }

	function add($save = null) {
	   if ($this->Session->check('entries'))
       {
            if ($save != null)
            {
                $savedOK = true;
                
    			$this->Dispatch->create();
                if ($save == 'validate')
                {
                    $savedOK = $this->Dispatch->validates() & $savedOK;
                }
                else
                {
                    $savedOK = $this->Dispatch->save() & $savedOK;
                }
                $dispatch_id = $this->Dispatch->getInsertID();
            
                $entries = unserialize($this->Session->read('entries'));
                $families = $this->Dispatch->Entry->Part->Family->find('list',array('Family.name'));
                foreach($entries as $entry)
                {
                    $family = $families[$entry['Part']['family_id']];
                    $pieces = $entry['Entry']['pieces'];
                    if ($family == 'MUV')
                    {
                        $this->Dispatch->Entry->create();
                        $this->Dispatch->Entry->set(array(
                                        'part_id' => $entry['Part']['id'],
                                        'dispatch_id' => $dispatch_id,
                                        'pieces' => $pieces
                                    ));
                        if ($save == 'validate')
                        {
                            $savedOK = $this->Dispatch->Entry->validates() & $savedOK;
                        }
                        else
                        {
                            $savedOK = $this->Dispatch->Entry->save() & $savedOK;
                        }
                        
                    }
                    else
                    {
                        $this->Dispatch->Entry->id = $entry['Entry']['id'];
                        $this->Dispatch->Entry->set(array(
                                        'active' => 0, // ignorar al calcular inventario en /parts
                                        'dispatch_id' => $dispatch_id,
                                    ));
                        if ($save == 'validate')
                        {
                            $savedOK = $this->Dispatch->Entry->validates() & $savedOK;
                        }
                        else
                        {
                            $savedOK = $this->Dispatch->Entry->save() & $savedOK;
                        }
                    }
                }
                
                if ($savedOK) {
                    if ($save == 'validate')
                    {
                        $this->redirect(array('action'=>'add','save'));
                    }
                    
        			$this->Session->setFlash(__('La salida ha sido guardada.', true));
        			$this->redirect(array('action'=>'view',$dispatch_id));
        		} else {
  		            
                    $this->Session->setFlash(__('La salida no pudo ser guardada correctamente, intente de nuevo.', true));
                    $this->redirect(array('action'=>'preview'));              
        			
        		}
            }
            else
            {
                $entries = unserialize($this->Session->read('entries'));
                
                $families = $this->Dispatch->Entry->Part->Family->find('list',array('Family.name'));
                
                $partsByFamily = array();
                
                foreach($entries as $idx => $entry)
                {
                    // if a balnk line appears on preview form
                    if (!$entry) {
                        unset($entries[$idx]);
                        continue;
                    }
                    $family_id = $entry['Part']['family_id'];
                    
                    // encontrar número de piezas puesto en forma anterior (sólo MUV)
                    if ($families[$family_id] == 'MUV')
                    {
                        for ($index =0; $index<count($this->data['Entry']['id']); $index++)
                        {
                            if ($this->data['Entry']['id'][$index] == $entry['Entry']['id'])
                            {
                                // entry será desplegado en la forma de confirmación
                                $entry['Entry']['pieces'] = $this->data['Entry']['pieces'][$index];
                                // entries es lo que se guarda en la sesión para ser guardado después
                                $entries[$idx]['Entry']['pieces'] = $this->data['Entry']['pieces'][$index];
                                break;
                            }
                        }
                    }
                    // quitar entradas que no tengan piezas que sacar de inventario
                    if ($entry['Entry']['pieces'] <= 0) {
                        unset($entries[$idx]);
                        continue;
                    }
                    // quitar entradas que ya fueron sacadas de inventario
                    if ($entry['Entry']['dispatch_id']) {
                        $entry = "El c&oacute;digo {$entry['Entry']['id']} ya fue removido del inventario anteriormente";
                        $partsByFamily[$family_id][] = $entry;
                        unset($entries[$idx]);
                        continue;
                    }
                    $partsByFamily[$family_id][] = $entry;
                }
                $this->Dispatch->recursive = 0;
                $dispatch_id = $this->Dispatch->find('first',array('order'=>array('id DESC')));
                $dispatch = array(
                    'Dispatch'=>array(
                        'id'=>$dispatch_id['Dispatch']['id']+1,
                        'created'=>date('Y-m-d')                        
                    ));
                
                $this->Session->write('entries', serialize($entries));
                
                $this->set('entries', $entries);
                
                $this->set('families', $families);
                
                $this->set('dispatch',$dispatch);
                
                $this->set('partsByFamily', $partsByFamily);
                
                $this->Session->setFlash(__('Esta salida a&uacute;n no est&aacute; guardada, compruebe los datos y despu&eacute;s haga clic en \'Guardar\'', true));
                
            }
       }
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Dispatch', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Dispatch->save($this->data)) {
				$this->Session->setFlash(__('The Dispatch has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Dispatch could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Dispatch->read(null, $id);
		}
		$entries = $this->Dispatch->Entry->find('list');
		$this->set(compact('entries'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Dispatch', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Dispatch->del($id)) {
			$this->Session->setFlash(__('Dispatch deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
