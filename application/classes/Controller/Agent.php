<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * Agent Module Conroller. Handles Client's Profile Management, Add Client's Personal Info,
 * Add Client's Financial Info.
 * 
 * @author  Shanmuganathan
 */
class Controller_Agent extends Controller {

    public function action_index() {
        // Index Function
        
        //$amount = Controller_Helper_Agent::get_h35();
       // session_start();
     //   $_SESSION['id'] = "1";
        $this->response->body(Controller_Helper_Agent::get_b9());
       // session_destroy();
        
        
    }
    
    /**
     * Add New Client Info
     */
    public function action_add_client() {    
        // API headers
        Controller_Helper_Header::api_headers($this->response);
        if (HTTP_Request::POST == $this->request->method()) {
            $data = json_decode(file_get_contents('php://input'), TRUE);
            $response = Controller_Api_Agent::add_client_info($data);
            $this->response->headers('Content-Type', 'application/json');

            echo json_encode($response);
        }
        $this->auto_render = FALSE;
    }
    
    /**
     * Get Client List Info
     */
    public function action_get_client_list() {       
         // API headers
        Controller_Helper_Header::api_headers($this->response);
        if (HTTP_Request::POST == $this->request->method()) {
            $data = json_decode(file_get_contents('php://input'), TRUE);
            $response = Controller_Api_Agent::get_client_list($data);
            $this->response->headers('Content-Type', 'application/json');

            echo json_encode($response);
        }
        $this->auto_render = FALSE;
        
    }
    
    /**
     * Create Agent Prequalification form
     */
    public function action_create_prequalification_form() {
         // API headers
        Controller_Helper_Header::api_headers($this->response);
        if (HTTP_Request::POST == $this->request->method()) {
            $data = json_decode(file_get_contents('php://input'), TRUE);
            $response = Controller_Api_Agent::create_prequalification_info($data);
            $this->response->headers('Content-Type', 'application/json');

            echo json_encode($response);
        }
        $this->auto_render = FALSE;
    }
    
    /**
     * Check Pre-Qualifier form submission
     */
    public function action_is_prequalifier() {
        // API headers
        Controller_Helper_Header::api_headers($this->response);
        if (HTTP_Request::POST == $this->request->method()) {
            $data = json_decode(file_get_contents('php://input'), TRUE);
            $response = Controller_Api_Agent::check_is_prequalifier($data);
            $this->response->headers('Content-Type', 'application/json');

            echo json_encode($response);
        }
        $this->auto_render = FALSE;
    }
    
    public function action_get_snapshot_data() {
        // API headers
        Controller_Helper_Header::api_headers($this->response);
        if (HTTP_Request::POST == $this->request->method()) {
            $data = json_decode(file_get_contents('php://input'), TRUE);
            $response = Controller_Api_Agent::get_client_financial_payment_info($data);
            $this->response->headers('Content-Type', 'application/json');

            echo json_encode($response);
        }
        $this->auto_render = FALSE;
    }

}

?>