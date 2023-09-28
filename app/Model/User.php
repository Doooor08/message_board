<?php
App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Auth');

class User extends AppModel {
    public $validate = array(
        'name' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => 'Name is required'
            ),
            'minLength' => array(
                'rule' => array('minLength', 5),
                'message' => 'Password should be at least 5 characters'
            )
        ),
        'email' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => 'Email is required'
            ),
            'validEmail' => array(
                'rule' => 'email',
                'message' => 'Invalid email format'
            ),
        ),
        'password' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => 'Password is required'
            ),
            'minLength' => array(
                'rule' => array('minLength', 6),
                'message' => 'Password should be at least 6 characters'
            )
        )
    );

    public function beforeSave($options = array()) {
        if (isset($this->data['User']['password'])) {
            $passwordHasher = new BlowfishPasswordHasher();
            $this->data['User']['password'] = $passwordHasher->hash(
                $this->data['User']['password']
            );
        }
        $this->data['User']['created_at'] = self::getDate();
        $this->data['User']['user_id'] = self::GenerateUserID();
    
        return true;
    }
    private function getDate() {
        date_default_timezone_set('Asia/Manila');
        return date('Y-m-d G:i:s');
    }
    private function GenerateUserID() {
        $min = 1000000000;
        $max = 9999999999;
        return mt_rand($min, $max);        
    }
}
