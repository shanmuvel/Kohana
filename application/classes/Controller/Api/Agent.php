<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * Agent Module API functions. Handles  Handles Client's Profile Management, Add Client's Personal Info,
 * Add Client's Financial Info.
 * @param type $data
 * @return $response as array
 * 
 * @author  Shanmuganathan
 */
class Controller_Api_Agent extends Controller {

    /**
     * Add New Client Info
     * @return type as Array
     */
    public static function add_client_info($data) {
        
        try {
            $date = new DateTime();
            $client = ORM::factory('ClientPersonalInfo');
            $client->user_id = $data['user_id'];
            $client->first_name = $data['firstname'];
            $client->last_name = $data['lastname'];
            $client->email_address = $data['email'];
            $client->home_phone = $data['phoneno'];
            $client->created_at = $date->format('Y-m-d H:i:s');
            $client->updated_at = $date->format('Y-m-d H:i:s');
            $client->save();
            
            // Save Financial Info
            self::save_financial_info($data, $client->id);
            
            $response = array('success' => true, 'message' => "Client Info Successfully Saved"); 
            
        } catch (ErrorException $ex) {
            $response = array('success' => false, 'message' => "Failed! Internal Problem!!");
        }
        
        return $response;
    }
    
    /**
     * Save Client's Financial Info
     * 
     * @param type $data
     * @param type $client_id
     */
    public static function save_financial_info($data, $client_id) {

        $date = new DateTime();
        foreach ($data as $info):
            if (is_array($info)):
                $client_financial_info = ORM::factory('ClientFinancialInfo');
                $client_financial_info->client_id = $client_id;
                $client_financial_info->finance_type = $info['finance_type'];
                $client_financial_info->dept_description = $info['dept_description'];
                $client_financial_info->dept_amount = $info['dept_amount'];
                $client_financial_info->interest_rate = $info['interest_rate'];
                $client_financial_info->amount_period = $info['amount_period'];
                $client_financial_info->monthly_payment = $info['monthly_payment'];
                $client_financial_info->created_at = $date->format('Y-m-d H:i:s');
                $client_financial_info->updated_at = $date->format('Y-m-d H:i:s');
                $client_financial_info->save();
            endif;
        endforeach;
    }
    
    /**
     * Get Client List Info
     * 
     * @param type $data
     * @return type $resposne as Array
     */
    public static function get_client_list($data) {

        $clients = ORM::factory('ClientPersonalInfo')
                ->where('user_id', '=', $data['user_id'])
                ->order_by('id', 'ASC')
                ->find_all();

        $client_list = array();
        foreach ($clients as $client):
            $client_info = array();
            $client_info['id'] = $client->id;
            $client_info['first_name'] = $client->first_name;
            $client_info['last_name'] = $client->last_name;
            $client_info['email'] = $client->email_address;
            $client_info['phoneno'] = $client->home_phone;
            $client_list[] = $client_info;
        endforeach;

        return $client_list;
    }

}

?>