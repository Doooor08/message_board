<?php
header('Content_type: application/json');
App::uses('AppController', 'Controller');

class AuthController extends AppController {
    public $components = array('Session');
    public $uses = array('User');
    
    public function register() {
        $this->autoRender = false;

        if ($this->request->is('post')) {
            $data = $this->request->input('json_decode', true);
            $this->User->set($data);

            if ($this->User->save($data)) {
                self::setSession($data);
                
                $userData = array(
                    'user_id' => $this->User->field('user_id', array('pk_id' => $this->User->id)),
                    'last_login' => $this->User->getDate(),
                );

                $this->loadModel('UserData');
                $this->UserData->create();
                $this->UserData->save($userData);

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
        $this->response->type('json');
        $this->response->body(json_encode($response));
    }

    public function login() {
        $this->autoRender = false;

        if ($this->request->is('post')) {
            $data = $this->request->input('json_decode', true);
            $email = $data['email'];
            $password = $data['password'];

            $this->User->set($data);
            $findUser = $this->User->find('first', array('conditions' => array('email' => $email),));
            
            if(!$findUser) {
                http_response_code(404);
                $response = array(
                    'status' => 404,
                    'message' => 'Email did not exist',
                );
                return json_encode($response);
            }

            $user = $this->User->verifyPassword($password, $findUser['User']['password']);
            if(!$user) {
                http_response_code(404);
                $response = array(
                    'status' => 422,
                    'message' => 'Password does not match',
                );
                return json_encode($response);
            }
    
            $this->loadModel('UserData');
            $lastLogin = $this->UserData->find('first', array('conditions' => array('user_id' => $findUser['User']['user_id'])));
            if(!$lastLogin) {
                $response = array(
                    'message' => 'Not found',
                );
            }
            // $lastLogin['UserData']['last_login'] = $this->User->getDate();
            $this->UserData->id = $findUser['User']['id'];
            $this->UserData->save(array(
                'id' => $this->UserData->id,
                'last_login' => $this->User->getDate(),
            ));

            // self::setSession($findUser);
            http_response_code(200);
            $response = array(
                'status' => 200,
                'message' => 'Login test passed!',
                'data' => array(
                    'user_id' => $findUser['User']['user_id'],
                    'last_login' => $lastLogin['UserData']['last_login'],
                )
            );
        }
        else {
            http_response_code(405);
            $response = array(
                'status' => 405,
                'message' => 'Method not Allowed',
            );
        }
        $this->response->type('json');
        $this->response->body(json_encode($response));
    }
    
    public function logout() {
        $this->Session->destroy();
        return $this->redirect('/login');
    }

    private function setSession($data) {
        $lastLogin = $this->User->update();
        return $this->Session->write('User', $data);
    }

}