<?php 
header('Content_type: application/json');
App::uses('AppController', 'Controller');


class MessageController extends AppController {
    // public $uses = array('User','UserData','Message');
    public $uses = array('Message'); 

    public function index() {
        $this->autoRender = false;
        if ($this->request->is('get')) {
            $sql = "SELECT tbl_users.user_id, tbl_users.name, tbl_users_data.photo, tbl_messages.message_id, tbl_messages.recipient, tbl_messages.message_body, tbl_messages.created_at 
                    FROM tbl_messages  
                    LEFT JOIN tbl_users ON (tbl_messages.user_id = tbl_users.user_id) 
                    LEFT JOIN tbl_users_data ON (tbl_users_data.user_id = tbl_users.user_id) 
                    WHERE tbl_messages.deleted_at IS NULL AND (tbl_messages.user_id, tbl_messages.recipient, tbl_messages.created_at) IN (
                        SELECT
                            tbl_messages.user_id,
                            tbl_messages.recipient,
                            MIN(tbl_messages.created_at) AS min_created_at
                        FROM tbl_messages
                        WHERE tbl_messages.deleted_at IS NULL AND tbl_messages.recipient = :recipient
                        GROUP BY
                            tbl_messages.user_id,
                            tbl_messages.recipient
                        )
                    ORDER BY
                        tbl_messages.created_at DESC;";
            $params = array(
                ':recipient' => $this->Session->read('User.user_id'),
                // ':user_id' => $this->Session->read('User.user_id'),
            );

            $results = $this->Message->query($sql, $params);
            
            $data = array();

            foreach ($results as $res) {
                $data[] = array(
                    'user_id' => $res['tbl_users']['user_id'],
                    'name' => $res['tbl_users']['name'],
                    'photo' => $res['tbl_users_data']['photo'],
                    'message_id' => $res['tbl_messages']['message_id'],
                    'recipient' => $res['tbl_messages']['recipient'],
                    'message_body' => $res['tbl_messages']['message_body'],
                    'created_at' => $res['tbl_messages']['created_at'],
                );
            }
            http_response_code(200);
            $response = array(
                'message' => 'Data fetched',
                'data' => $data
            );

        } else {
            http_response_code(405);
            $response = array(
                'status' => 405,
                'message' => 'Method not Allowed',
            );
        }
        
        // debug($this->Message->getDataSource()->getLog(false, false));
        $this->response->type('json');
        $this->response->body(json_encode($response));
    }

    public function get() {
        $this->autoRender = false;
        if ($this->request->is('get')) {
            $id = $this->request->params['id'];
            
            $sql = 'SELECT tbl_users.user_id, tbl_users.name, tbl_users_data.photo, tbl_messages.message_id, tbl_messages.user_id, tbl_messages.recipient, tbl_messages.message_body, tbl_messages.is_deleted, tbl_messages.created_at, tbl_messages.deleted_at 
                    FROM tbl_messages  
                    LEFT JOIN tbl_users ON (tbl_messages.user_id = tbl_users.user_id) 
                    LEFT JOIN tbl_users_data ON (tbl_users_data.user_id = tbl_users.user_id) 
                    WHERE tbl_messages.message_id = :id AND tbl_messages.deleted_at IS NULL AND tbl_messages.is_deleted = 0
                    ORDER BY tbl_messages.created_at ASC';

            $params = array(
                ':id' => $id,
            );

            $getMessage = $this->Message->query($sql, $params);
            $data = array();
            
            foreach ($getMessage as $res) {
                $data[] = array(
                    'user_id' => $res['tbl_users']['user_id'],
                    'name' => $res['tbl_users']['name'],
                    'photo' => $res['tbl_users_data']['photo'],
                    'message_id' => $res['tbl_messages']['message_id'],
                    'recipient' => $res['tbl_messages']['recipient'],
                    'message_body' => $res['tbl_messages']['message_body'],
                    'is_deleted' => $res['tbl_messages']['is_deleted'],
                    'created_at' => $res['tbl_messages']['created_at'],
                    'deleted_at' => $res['tbl_messages']['deleted_at'],
                );
            }
            
            http_response_code(200);
            $response = array(
                'message' => 'Data fetched',
                'data' => $data
            );
        } else {
            http_response_code(405);
            $response = array(
                'status' => 405,
                'message' => 'Method not Allowed',
            );
        }
        $this->response->type('json');
        return $this->response->body(json_encode($response));
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

    public function storeReply() {
        $this->autoRender = false;
        if ($this->request->is('post')) { 
            $message_id = $this->request->params['id'];
            $data = $this->request->input('json_decode', true);
            // Set message_id for reply in convo, 
            // Set user_id based on user_id set in session
            $data['message_id'] = $message_id;
            $data['user_id'] = $this->Session->read('User.user_id');
            $this->Message->set($data);

            if ($this->Message->save($data)) {
                http_response_code(201);
                $response = array(
                    'status' => 201,
                    'message' => 'Message Sent',
                    'data' => $this->Message->read()
                );
            } else {
                http_response_code(422);
                $response = array(
                    'status' => 422,
                    'message' => 'Unprocessable Content: Failed to send reply',
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