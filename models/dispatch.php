<?php
class Dispatch extends AppModel {

	var $name = 'Dispatch';

	var $hasMany = array(
		'Entry' => array(
			'className' => 'Entry',
			'foreignKey' => 'dispatch_id',
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