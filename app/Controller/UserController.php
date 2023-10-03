<?php 
header('Content_type: application/json');
App::uses('AppController', 'Controller');

class UserController extends AppController {
    public $uses = array('User','UserData');

    public function get() {
        $this->autoRender = false;
        $userId = $this->request->params['user'];
        if ($this->request->is('get')) {
            $getUserData = $this->User->find('first', array(
                'fields' => array(
                    'User.name',
                    'User.user_id',
                    'User.created_at',
                    'User.last_login',
                    'UserData.photo',
                    'UserData.gender',
                    'UserData.birthdate',
                    'UserData.description',
                ),
                'conditions' => array(
                    'User.user_id' => $userId,
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
            $getUserData = array_merge($getUserData['User'], $getUserData['UserData']);
    
            $this->Session->write('userData', $getUserData);
            $this->redirect(array('controller' => 'pages', 'action' => 'userProfile',
            '?' => array(
                'user_id' => $getUserData['user_id'],
            )));
        } else {
            http_response_code(405);
            $response = array(
                'status' => 405,
                'message' => 'Method not Allowed',
            );
            $this->response->type('json');
            $this->response->body(json_encode($response));
        }

        // echo json_encode(array($getUserData));
    }

    public function update() {
        $this->autoRender = false;
        if ($this->request->is('post')) {
            $name = $this->request->data['name'];
            $birthdate = $this->request->data['birthdate'];
            $dateTime = DateTime::createFromFormat('m/d/Y', $birthdate);
            $birthdate = $dateTime->format('Y-m-d');
            $gender = $this->request->data['gender'] ?? null;
            $gender = ($gender === 'male') ? 'M' : (($gender === 'female') ? 'F' : null);           
            $description = $this->request->data['description'];
            $file = $this->request->form['photo'];
            
            // Check if file exists
            if (!file_exists($file['tmp_name'])) {
                http_response_code(404);
                $response = array(
                    'status' => 404,
                    'message' => 'File not found',
                );
                return json_encode($response);
            }
            
            // Check if the file is an image and matches the allowed extensions
            $allowedExt = array('jpeg', 'jpg', 'png', 'gif');
            $getFileExt = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            
            if(!in_array($getFileExt, $allowedExt)) {
                http_response_code(422);
                $response = array(
                    'status' => 422,
                    'message' => 'File not uploaded: Invalid file format',
                );
                return json_encode($response);
            }

            // Attempt to upload file to webroot/img/avatars/
            $upload = self::uploadFile($file);
            if(!$upload['success']) {
                http_response_code(422);
                $response = array(
                    'status' => 422,
                    'message' => 'File not uploaded: Failed to upload file',
                );
                return json_encode($response);
            }
            $filename = $upload['filename'];

            $this->User->id = $this->Session->read('User.id');

            $updateUser = $this->User->updateAll(
                array(
                    'User.name' => "'". $name. "'",
                    'User.updated_at' => "'". $this->User->getDate(). "'",
                ),
                array('User.id' => $this->Session->read('User.id'))
            );

            $this->UserData->id = $this->Session->read('User.id');
            
            $updateUserData = $this->UserData->updateAll(array(
                'UserData.photo' => "'" . $filename . "'",
                'UserData.gender' => "'" . $gender . "'",
                'UserData.birthdate' => "'" . $birthdate . "'",
                'UserData.description' => "'" . $description . "'",
                ),
                array(
                    'UserData.user_id' => $this->Session->read('User.user_id')
            ));

            if(!$updateUser || !$updateUserData) {
                http_response_code(422);
                $response = array(
                    'status' => 422,
                    'message' => 'Failed to update user profile',
                );
                return json_encode($response); 
            }

            http_response_code(200);
                $response = array(
                    'status' => 200,
                    'message' => 'User Profile updated!',
                );
                return json_encode($response); 
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
    
    private function uploadFile($file) {
        $getDate = date('Ymd');
        $randomBytes = random_bytes(4);
        $randName = strtoupper(bin2hex($randomBytes));
        $getFileExt = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $uploadPath = WWW_ROOT . 'img' . DS . 'avatars' . DS;
        $fileName = "IMG_" . $getDate . "_" . $randName. "." . $getFileExt;

        if(move_uploaded_file($file['tmp_name'], $uploadPath . $fileName)) {
            return ['success' => true, 'filename' => $fileName];
        } 

        return false;

    }
}
?>