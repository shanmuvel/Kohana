<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * Admin Module Conroller. Handles Agent Profile Management, Add new Agent,
 *  Remove and Active/Deactive
 * 
 * @author  Shanmuganathan
 */
class Controller_Admin extends Controller {

    public function action_index() {
        // Index Function
    }

    /**
     * Get Agent List
     */
    public function action_get_agent_list() {
        // API headers
        Controller_Helper_Header::api_headers($this->response);
        if (HTTP_Request::GET == $this->request->method()) {
            //$data = json_decode(file_get_contents('php://input'), TRUE);
            $response = Controller_Api_Admin::get_agent_list();
            $this->response->headers('Content-Type', 'application/json');

            echo json_encode($response);
        }
        $this->auto_render = FALSE;
    }

}

?>
