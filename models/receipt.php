<?php
class Receipt extends AppModel {

	var $name = 'Receipt';

	var $hasMany = array(
		'Entry' => array(
			'className' => 'Entry',
			'foreignKey' => 'receipt_id',
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