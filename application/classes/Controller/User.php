<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * User Module Conroller. Handles user signup, login and logout, as well as secure
 * password hashing.
 * 
 * @author  Shanmuganathan
 */
class Controller_User extends Controller {

    public function action_index() {
        //function generateRandomString($length = 10) {
    }

    /**
     * User Login
     */
    public function action_login() {
        // API headers
        Controller_Helper_Header::api_headers($this->response);

        if (HTTP_Request::POST == $this->request->method()) {
            $data = json_decode(file_get_contents('php://input'), TRUE);
            $response = Controller_Api_User::login($data);
            $this->response->headers('Content-Type', 'application/json');

            echo json_encode($response);
        }
        $this->auto_render = FALSE;
    }
    
    /**
     * User Signup
     */
    public function action_signup() {
        // API headers
        Controller_Helper_Header::api_headers($this->response);
        if (HTTP_Request::POST == $this->request->method()) {
            $data = json_decode(file_get_contents('php://input'), TRUE);
            $response = Controller_Api_User::signup($data);
            $this->response->headers('Content-Type', 'application/json');

            echo json_encode($response);
        }
        $this->auto_render = FALSE;
    }

}

?>