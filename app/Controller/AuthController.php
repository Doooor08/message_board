<?php
header('Content_type: application/json');
App::uses('AppController', 'Controller');

class AuthController extends AppController {
    public $uses = array('User');
    
    public function register() {
        if ($this->request->is('post')) {
            $data = $this->request->input('json_decode', true);
            $this->User->set($data);

            if ($this->User->save($data)) {
                http_response_code(201);
                $response = array(
                    'status' => 201,
                    'message' => 'Registration successful',
                );
            } else {
                http_response_code(422);
                $response = array(
                    'status' => 422,
                    'message' => 'Unprocessable Content: Registration failed',
                );
            }
        }
        else {
            http_response_code(405);
            $response = array(
                'status' => 405,
                'message' => 'Method not Allowed',
            );
        }
        $this->autoRender = false;
        $this->response->type('json');
        $this->response->body(json_encode($response));
    }

    public function login() {
        if ($this->request->is('post')) {
            if ($this->User->login()) {
                // Successful login
                return $this->redirect($this->User->redirectUrl());
            } else {
                // Failed login, handle accordingly
                $this->Flash->error(__('Invalid username or password, try again'));
            }
        }
        else {
            http_response_code(405);
            $response = array(
                'status' => 405,
                'message' => 'Method not Allowed',
            );
        }
        $this->autoRender = false;
        $this->response->type('json');
        $this->response->body(json_encode($response));
    }
    
    public function logout() {
        return $this->redirect($this->User->logout());
    }

}