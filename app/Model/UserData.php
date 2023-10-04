<?php
App::uses('AppModel', 'Model');

class UserData extends AppModel {
    public $useTable = 'tbl_users_data';
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
        ),
    );
    
    public $validate = array(
        'photo' => array(
            'rule' => array('fileSize', '<=', '5MB'), // Max file size: 5MB
            'message' => 'The photo must be less than 5MB in size.',
            'allowEmpty' => true, // Allow empty photo
            'required' => false, // Not required
            'on' => 'create', // Apply this rule on create action
        ),
        'gender' => array(
            'rule' => array('inList', array('M', 'F', 'O')), // M: Male, F: Female, O: Other
            'message' => 'Invalid gender value.',
        ),
        'birthdate' => array(
            'rule' => 'date',
        ),
    );
}
