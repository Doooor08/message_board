<?php 
header('Content_type: application/json');
App::uses('AppController', 'Controller');

class UserController extends AppController {
    public $uses = array('User','UserData');
    
    public function index() {
        $this->autoRender = false;
        if ($this->request->is('get')) {
            $getAll = self::getAllUsers();
    
            $modifiedResults = array();
    
            foreach ($getAll as $result) {
                $modifiedResult = array(
                    'user_id' => $result['User']['user_id'],
                    'name' => $result['User']['name'],
                    'photo' => $result['UserData']['photo'],
                );
                $modifiedResults[] = $modifiedResult;
            }
    
            http_response_code(200);
            $response = array(
                'status' => 200,
                'data' => $modifiedResults,
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

    public function get() {
        $this->autoRender = false;
        $userId = $this->request->params['user'];
        if ($this->request->is('get')) {
            $getUserData = self::getUserData($userId);
            $getUserData = array_merge($getUserData['User'], $getUserData['UserData']);

            // Format gender and birthdate
            if (isset($getUserData['gender'])) {
                $getUserData['gender'] = self::formatGender($getUserData['gender']);
            }
            
            if(isset($getUserData['birthdate'])) {
                $getUserData['birthdate'] = self::formatBirthDate($getUserData['birthdate']);
            }

            self::setUserDataSession($getUserData);
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
            $updateUser = $this->User->updateAll(
                array(
                    'User.name' => "'". $name. "'",
                    'User.updated_at' => "'". $this->User->getDate(). "'",
                ),
                array('User.user_id' => $this->Session->read('User.user_id'))
            );
            // $this->UserData->id = $this->Session->id;
            // $this->UserData->set(array(
            //     'user_id' => $this->Session->read('User.user_id'),
            //     'photo' => $filename,
            //     'gender' => $gender,
            //     'birthdate' => $birthdate,
            //     'description' => $description
            // ));
            // $updateUserData = $this->UserData->save();

            $getRecord = $this->UserData->find('first', array(
                'conditions' => array(
                    'UserData.user_id' => $this->Session->read('User.user_id')
                )
            ));
            // $getRecord['UserData']['user_id'] = $this->Session->read('User.user_id');
            $getRecord['UserData']['photo'] = $filename;
            $getRecord['UserData']['gender'] = $gender;
            $getRecord['UserData']['birthdate'] = $birthdate;
            $getRecord['UserData']['description'] = $description;
            // Save to tbl_users_data
            $updateUserData =  $this->UserData->save($getRecord);

            if(!$updateUser || !$updateUserData) {
                http_response_code(422);
                $response = array(
                    'status' => 422,
                    'message' => 'Failed to update user profile',
                );
                return json_encode($response); 
            }

            $getUserData = self::getUserData($this->Session->read('User.user_id'));
            $getUserData = array_merge($getUserData['User'], $getUserData['UserData']);
            $getUserData['gender'] = self::formatGender($getUserData['gender']);
            $getUserData['birthdate'] = self::formatBirthDate($getUserData['birthdate']);
            
            self::setUserDataSession($getUserData);

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

    
    private function getUserData($id) {
        return $this->User->find('first', array(
            'fields' => array(
                'User.user_id',
                'User.name',
                'User.email',
                'User.created_at',
                'User.last_login',
                'UserData.photo',
                'UserData.gender',
                'UserData.birthdate',
                'UserData.description',
            ),
            'conditions' => array(
                'User.user_id' => $id,
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
    }

    private function getAllUsers() {
        return $this->User->find('all', array(
            'fields' => array(
                'User.user_id',
                'User.name',
                'UserData.photo',
            ),
            'joins' => array(
                array(
                    'table' => 'tbl_users_data',
                    'alias' => 'UserData',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'User.user_id = UserData.user_id',
                    ),
                ),
            ),
            'conditions' => array(
                'NOT' => array('User.user_id' => $this->Session->read('User.user_id')),
            ),
        ));
    }
    
    private function setUserDataSession($data) {
        return $this->Session->write('userData', $data);
    }

    private function formatBirthDate($birthdate) {
        $dateTime = DateTime::createFromFormat('Y-m-d', $birthdate);
        return $dateTime->format('m/d/Y');
    }

    private function formatGender($gender) {
        return ($gender === 'M') ? 'Male' : (($gender === 'F') ? 'Female' : null);
    }
}
?>