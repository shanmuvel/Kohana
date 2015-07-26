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
        //$amount = $this->_pmt(0.002895623, 300, 441426);
        
        //$amount = -LN(1-B24*J24/G24)/LN(1+J24);
        
        //$amount = -log(1-441426*0.002895623/3233.15)/log(1+0.002895623);
        
        $amount = Controller_Helper_Agent::get_h35();
        
        $this->response->body($amount);
        
    }
    
    public function _pmt($i, $n, $p) {
//       $interest = $interest / 1200;
//       $amount = $interest * -$loan * pow((1 + $interest), $months) / (1 - pow((1 + $interest), $months));
//       return number_format($amount, 2);
        
      
  $amount = $i * $p * pow((1 + $i), $n) / (1 - pow((1 + $i), $n));
  return number_format($amount, 2);
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

}

?>