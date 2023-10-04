<?php 
header('Content_type: application/json');
App::uses('AppController', 'Controller');

class MessageController extends AppController {
    public $uses = array('User','UserData','Message'); 

    public function index() {
        $this->autoRender = false;

        if ($this->request->is('get')) {
            $getMsgData = $this->Message->find('all', array(
                'fields' => array(
                    'User.user_id',
                    'User.name',
                    'UserData.photo',
                    'Message.message_id',
                    'Message.recipient',
                    'Message.message_body',
                    'Message.created_at',
                ),
                'conditions' => array(
                    'Message.deleted_at' => null,
                    'Message.recipient' => $this->Session->read('User.user_id')
                ),
                'contain' => array(
                    'User', // Include the User model
                    'UserData', // Include the UserData model
                ),
            ));
            
            $data = array();

            foreach ($getMsgData as $res) {
                $data[] = array(
                    'user_id' => $res['User']['user_id'],
                    'name' => $res['User']['name'],
                    'photo' => $res['UserData']['photo'],
                    'message_id' => $res['Message']['message_id'],
                    'recipient' => $res['Message']['recipient'],
                    'message_body' => $res['Message']['message_body'],
                    'created_at' => $res['Message']['created_at'],
                );
                
            }
            http_response_code(200);
            $response = array(
                'message' => 'Data fetched',
                'data' => $getMsgData
            );

        } else {
            http_response_code(405);
            $response = array(
                'status' => 405,
                'message' => 'Method not Allowed',
            );
        }
        debug($this->Message->getDataSource()->getLog(false, false));
        $this->response->type('json');
        $this->response->body(json_encode($response));
    }

    public function store() {
        $this->autoRender = false;
        if ($this->request->is('post')) {
            $data = $this->request->input('json_decode', true);
            // Set user_id based on user_id set in session
            $data['user_id'] = $this->Session->read('User.user_id');
            $this->Message->set($data);

            if ($this->Message->save($data)) {
                
                http_response_code(201);
                $response = array(
                    'status' => 201,
                    'message' => 'Message Sent',
                );
            } else {
                http_response_code(422);
                $response = array(
                    'status' => 422,
                    'message' => 'Unprocessable Content: Failed to send message',
                );
            }
        } else {
            http_response_code(405);
            $response = array(
                'status' => 405,
                'message' => 'Method not Allowed',
            );
        }
        $this->response->type('json');
        $this->response->body(json_encode($response));
    }
}