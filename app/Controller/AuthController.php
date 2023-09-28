<?php
header('Content_type: application/json');
App::uses('AppController', 'Controller');

class AuthController extends AppController {
    public $uses = array('User');
    
    public function register() {
        if ($this->request->is('post')) {
            $this->User->set($this->request->data);

            if ($this->User->save($this->request->data)) {
                $response = array(
                    'status' => 201,
                    'message' => 'Registration successful',
                );
            } else {
                $response = array(
                    'status' => 422,
                    'message' => 'Registration failed',
                );
            }
            $this->autoRender = false;
            $this->response->type('json');
            $this->response->body(json_encode($response));
        }
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
    }
    
    public function logout() {
        return $this->redirect($this->User->logout());
    }

}