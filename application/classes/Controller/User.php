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
        // API headers
        Controller_Helper_Header::api_headers($this->response);
        if (HTTP_Request::POST == $this->request->method()) {
            $data = json_decode(file_get_contents('php://input'), TRUE);
            $response = Controller_Api_User::get_user_info($data);
            $this->response->headers('Content-Type', 'application/json');

            echo json_encode($response);
        }
        $this->auto_render = FALSE;
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
    
    /**
     * User Code Verification
     */
    public function action_user_code_verification() {
        // API headers
        Controller_Helper_Header::api_headers($this->response);
        if (HTTP_Request::POST == $this->request->method()) {
            $data = json_decode(file_get_contents('php://input'), TRUE);
            $response = Controller_Api_User::user_code_verification($data);
            $this->response->headers('Content-Type', 'application/json');

            echo json_encode($response);
        }
        $this->auto_render = FALSE;
    }
    
    /**
     *  User Profile Creation
     */
    public function action_create_profile() {
        // API headers
        Controller_Helper_Header::api_headers($this->response);
        if (HTTP_Request::POST == $this->request->method()) {
            $data = json_decode(file_get_contents('php://input'), TRUE);
            $response = Controller_Api_User::create_user_profile($data);
            $this->response->headers('Content-Type', 'application/json');

            echo json_encode($response);
        }
        $this->auto_render = FALSE;
    }
    
    /**
     * User Profile Activation
     */
    public function action_profile_activation() {
        // API headers
        Controller_Helper_Header::api_headers($this->response);
        if (HTTP_Request::POST == $this->request->method()) {
            $data = json_decode(file_get_contents('php://input'), TRUE);
            $response = Controller_Api_User::user_profile_activation($data);
            $this->response->headers('Content-Type', 'application/json');

            echo json_encode($response);
        }
        $this->auto_render = FALSE;
    }

}

?>