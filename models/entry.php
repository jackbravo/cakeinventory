<?php
class Entry extends AppModel {

	var $name = 'Entry';
	var $validate = array(
		'part_id' => array('numeric'),
        'pieces' => array('numeric')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Part' => array(
			'className' => 'Part',
			'foreignKey' => 'part_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
        'Receipt' => array(
            'className' => 'Receipt',
			'foreignKey' => 'receipt_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
        ),
        'Dispatch' => array(
            'className' => 'Receipt',
			'foreignKey' => 'dispatch_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
        )
	);
    
    var $hasOne = array(
        'Identifier' => array(
			'className' => 'Identifier',
			'foreignKey' => 'entry_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
    );
}
?>