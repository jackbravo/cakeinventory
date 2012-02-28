<?php
class Identifier extends AppModel {

	var $name = 'Identifier';
	var $validate = array(
		'part_id' => array('numeric')
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
        'Entry' => array(
            'className' => 'Entry',
            'foreignKey' => 'entry_id',
            'conditions' => '',
			'fields' => '',
			'order' => ''
        )
	);

}
?>