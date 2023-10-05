<?php
header('Content_type: application/json');
App::uses('AppController', 'Controller');

class AuthController extends AppController {
    public $components = array('Session');
    public $uses = array('User','UserData');
    
    public function register() {
        $this->autoRender = false;

        if ($this->request->is('post')) {
            $data = $this->request->input('json_decode', true);
            $this->User->set($data);

            if ($this->User->save($data)) {
                // Retrieve the saved user data
                $getUser = $this->User->read();
                $this->User->id = $getUser['User']['id'];
                $this->User->saveField('last_login', $this->User->getDate());
                
                $this->UserData->saveField('user_id', $getUser['User']['user_id']);
                self::setSession($getUser);

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

            $findUser['User']['last_login'] = $this->User->getDate();
            $this->User->id = $findUser['User']['id'];
            $this->User->save($findUser);

            self::setSession($findUser);

            http_response_code(200);
            $response = array(
                'status' => 200,
                'message' => 'Login success!',
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
        $storeUserData = $this->User->find('first', array(
            'fields' => array(
                'User.user_id',
                'User.name',
                'User.email',
                'UserData.photo',
            ),
            'conditions' => array(
                'User.user_id' => $data['User']['user_id'],
            ),
            'joins' => array(
                array(
                    'table' => 'tbl_users_data',
                    'alias' => 'UserData',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'UserData.user_id = User.user_id',
                    )
                )
            )
        ));
        $storeUserData = array_merge($storeUserData['User'], $storeUserData['UserData']);

        return $this->Session->write('User', $storeUserData);
    }

}