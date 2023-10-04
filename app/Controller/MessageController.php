<?php 
header('Content_type: application/json');
App::uses('AppController', 'Controller');

class MessageController extends AppController {
    public $components = array('Paginator');
    public $uses = array('Message'); 

    public function index() {
        $this->autoRender = false;
        
        $this->Paginator->settings = array(
            'conditions' => array(
                'Message.deleted_at' => null,
            ),
            'limit' => 10, // Number of records per page
            'order' => array('Message.created_at' => 'desc'), // Sorting order
        );

        if ($this->request->is('get')) {
            $data = $this->Message->find('all', array(
                'conditions' => array(
                    'Message.deleted_at' => null,
                ),
            ));

            $formattedData = array();

            foreach ($data as $message) {
                $formattedData[] = [
                    'message_id' => $message['Message']['message_id'],
                    'user_id' => $message['Message']['user_id'],
                    'recipient' => $message['Message']['recipient'],
                    'message_body' => $message['Message']['message_body'],
                    'created_at' => $message['Message']['created_at'],
                ];
            }

            $formattedData = $this->Paginator->paginate('Message');

            $response = array(
                'data' => $formattedData,
            );

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