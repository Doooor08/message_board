<?php
App::uses('AppModel', 'Model');

class Message extends AppModel {
    public $useTable = 'tbl_messages';
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
        ),
        'UserData' => array(
            'className' => 'UserData',
            'foreignKey' => false,
            'conditions' => array('UserData.user_id = Message.user_id')
        )
    );
    

    // Set message_id and created_at values
    public function beforeSave($options = array()) {
        if($this->id === null) {
            $this->data['Message']['created_at'] = self::getDate();
        }
        
        if(!isset($this->data['Message']['message_id'])) {
            $this->data['Message']['message_id'] = self::GenerateMessageID();
        }
        
        return true;
    }

    // Private classes
    private function getDate() {
        return date('Y-m-d G:i:s');
    }

    private function GenerateMessageID() {
        $min = 100000000000;
        $max = 999999999999;
        return mt_rand($min, $max);        
    }
}
