<?php
App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class User extends AppModel {
    public $useTable = 'tbl_users';

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

    // Register: Hash password
    // Then set user_id and created_at
    public function beforeSave($options = array()) {
        if($this->id === null && isset($this->data['User']['password'])) {
            $passwordHash = new BlowfishPasswordHasher();
            $this->data['User']['password'] = $passwordHash->hash(
                $this->data['User']['password']
            );
            $this->data['User']['user_id'] = self::GenerateUserID();
            $this->data['User']['created_at'] = $this->getDate();
        }
        
        return true;
    }

    // Login: Verify the password.
    // $password = Password Input
    // $passwordHashed = Hashed password fetched from database
    public function verifyPassword($password, $passwordHashed) {
        $passwordHasher = new BlowfishPasswordHasher();
        if ($passwordHasher->check($password, $passwordHashed)) {
            return true;
        }

        return false; 
    }

    public function getDate() {
        return date('Y-m-d G:i:s');
    }

    // Private classes
    private function GenerateUserID() {
        $min = 1000000000;
        $max = 9999999999;
        return mt_rand($min, $max);        
    }
}
