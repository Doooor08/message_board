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
        
        // Your code to process the file and other data goes here
            $name = $this->request->data['name'];
            $file = $this->request->form['photo'];
            $uploadPath = WWW_ROOT . 'img' . DS . 'avatars' . DS;

            // Check if the file is an image (you can add more validation)
            if (is_uploaded_file($file['tmp_name']) && exif_imagetype($file['tmp_name'])) {
                $fileName = uniqid() . $file['name'];

                // Move and save the file
                if (move_uploaded_file($file['tmp_name'], $uploadPath . $fileName)) {
                    // File upload was successful
                    $response = array(
                        'message' => 'File uploaded successfully',
                        'file_name' => $fileName,
                    );
                } else {
                    // Error while moving the file
                    $response = array(
                        'message' => 'Error uploading file',
                    );
                }
            } else {
                // Invalid file format
                $response = array(
                    'message' => 'Invalid file format or file not uploaded',
                );
            }




            // $response = array(
            //                 'message' => 'Function called',
            //                 'data' => json_encode($name),
            //                 'file' => json_encode($file)
            //             );

            // // Check if a file was uploaded
            // if (!empty($data['photo']['name'])) {
            //     $file = $data['photo']; // Get the uploaded file data
            //     $user_id = $this->Session->read('User.user_id');
    
            //     // Define the upload directory (you can adjust it to your needs)
            //     $uploadDir = WWW_ROOT . 'avatars' . DS;
            //     $uploadPath = $uploadDir . $user_id . DS;
    
            //     // Ensure the directory exists, or create it
            //     if (!file_exists($uploadPath)) {
            //         mkdir($uploadPath, 0777, true);
            //     }
    
            //     // Generate a unique file name
            //     $fileName = uniqid() . '_' . $file['name'];
    
            //     // Move the uploaded file to the desired location
            //     if (move_uploaded_file($file['tmp_name'], $uploadPath . $fileName)) {
            //         // File uploaded successfully
            //         // You can save the file path to the database or perform other actions
    
            //         // Update the 'photo' field in your User model with the file path
            //         $this->User->id = $user_id;
            //         $this->User->saveField('photo', $uploadPath . $fileName);
    
            //         // Respond with a success message or redirect
            //         $response = array(
            //             'status' => 200,
            //             'message' => 'File uploaded successfully',
            //         );
            //     } else {
            //         // File upload failed
            //         $response = array(
            //             'status' => 500,
            //             'message' => 'File upload failed',
            //         );
            //     }
            // } else {
            //     // No file was uploaded, handle accordingly
            //     $response = array(
            //         'status' => 400,
            //         'message' => 'No file uploaded',
            //     );
            // }
        } else {
            // Handle invalid request method
            $response = array(
                'status' => 405,
                'message' => 'Method not Allowed',
            );
        }
    
        // Respond with JSON
        $this->response->type('json');
        $this->response->body(json_encode($response));
    }
    
}
?>