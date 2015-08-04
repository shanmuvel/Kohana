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
            
            $response = array('success' => true, 'message' => "Client Info Successfully Saved", 'id' => $client->id); 
            
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
                $client_financial_info->dept_description = $info['debt_description'];
                $client_financial_info->dept_amount = $info['debt_amount'];
                $client_financial_info->interest_rate = $info['interest_rate'];
                $client_financial_info->amount_period = $info['amort_period'];
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
    
    /**
     * Create Agent's Pre-Qualification form
     * @param type $data
     * @return type $response as Array
     */
    public static function create_prequalification_info($data) {
        try {
            $date = new DateTime();
            $pre_qualification_info = ORM::factory('PreQualificationInfo');
            $pre_qualification = $pre_qualification_info->where('user_id', '=', $data['user_id'])->count_all();
            if ($pre_qualification > 0):
                // Update 
                $pre_qualification_info = $pre_qualification_info->where('user_id', '=', $data['user_id'])->find();
            endif;
            $pre_qualification_info->user_id = $data['user_id'];
            $pre_qualification_info->mortgage_balance = $data['mortgage_balance'];
            $pre_qualification_info->short_term_debts = $data['short_term_debts'];
            $pre_qualification_info->market_value = $data['market_value'];
            if ($pre_qualification <= 0):
                $pre_qualification_info->created_at = $date->format('Y-m-d H:i:s');
            endif;
            $pre_qualification_info->updated_at = $date->format('Y-m-d H:i:s');
            $pre_qualification_info->save();

            $response = array('success' => true, 'message' => "Pre-qualification form successfully submitted");
        } catch (ErrorException $ex) {
            $response = array('success' => false, 'message' => "Failed! Internal Problem!!");
        }

        return $response;
    }
    
    /**
     * Check if is it prequalifier
     * @param type $data
     * @return $response as array
     */
    public static function check_is_prequalifier($data) {
        $prequalifier = ORM::factory('PreQualificationInfo')->where('user_id', '=', $data['user_id'])->find();
        if ($prequalifier != NULL):
            $response = array('success' => true, 'data' => $prequalifier->as_array());
        else:
            $response = array('success' => false);
        endif;

        return $response;
    }

    /**
     * Get client financial payment info
     * @param type $data
     */
    public static function get_client_financial_payment_info($data) {
        
        session_start();
        $_SESSION['id'] = $data['client_id'];
        
        // Client Info
        $client_info = ORM::factory('ClientPersonalInfo', $data['client_id'])->as_array();
        
        // Monthly Payments
        $mp1 = Controller_Helper_Agent::get_g27();
        $mp3 = Controller_Helper_Agent::get_g26();
        $mp2 = $mp3-$mp1;
        
        // Years To Freedom
        $yf1 = Controller_Helper_Agent::get_g41();
        $yf3 = Controller_Helper_Agent::get_h41();
        $yf2 = $yf3-$yf1;
        
        // Total Interest Cost
        $tic1 = Controller_Helper_Agent::get_g35();
        $tic3 = Controller_Helper_Agent::get_h35();
        $tic2 = $tic3-$tic1;
        
        // Increased Monthly CashFlow
        $imc = Controller_Helper_Agent::get_g28();
        
        //Lost Wealth by Giving into old schedule
        $lws = $mp3*$yf2*12;
        
        //Letter Calculations
        $duration = Controller_Helper_Agent::get_h41();
        $pi = Controller_Helper_Agent::get_h36();
        $goi = Controller_Helper_Agent::get_l22();
        $df = Controller_Helper_Agent::get_i9();
        $sd = Controller_Helper_Agent::get_i41();
        $sip = Controller_Helper_Agent::get_i35();
        $pc = Controller_Helper_Agent::get_h40();
        
        
        
        $response = array(
            "client_info" => $client_info,
            
            "monthly_payments" => array(
                "mp1" => is_nan($mp1) ? "NaN" : round($mp1),
                "mp2" => is_nan($mp2) ? "NaN" : round($mp2),
                "mp3" => is_nan($mp3) ? "NaN" : round($mp3)
            ),
            "years_to_freedom" => array(
                "yf1" => is_nan($yf1) ? "NaN" : number_format($yf1, 1),
                "yf2" => is_nan($yf2) ? "NaN" : number_format($yf2, 1),
                "yf3" => is_nan($yf3) ? "NaN" : number_format($yf3, 1)
            ),
            "total_interest_cost" => array(
                "tic1" => is_nan($tic1) ? "NaN" : round($tic1),
                "tic2" => is_nan($tic2) ? "NaN" : round($tic2),
                "tic3" => is_nan($tic3) ? "NaN" : round($tic3)
            ),
            "imc" => is_nan($imc) ? "NaN" : round($imc),
            "lws" => is_nan($lws) ? "NaN" : round($lws),
            "lc" => array(
                "duration" => is_nan($duration) ? "NaN" : number_format($duration, 1),
                "pi" => is_nan($pi) ? "NaN" : round($pi),
                "goi" => is_nan($goi) ? "NaN" : round($goi),
                "df" =>  $df,
                "sd" => is_nan($sd) ? "NaN" : number_format($sd, 1),
                "sip" => is_nan($sip) ? "NaN" : round($sip),
                "pc" => is_nan($pc) ? "NaN" : round($pc),
                "ror" => is_nan($lws) ? "NaN" : round($lws)
            )
        );
        
        return $response;
        session_destroy();
    }
    
    
    /**
     * Get User Profile Info
     * @param type $data
     * @return type as Array
     */
    public static function get_profile_info($data) {
        try {
            $user_info = ORM::factory('UserInfo')
                    ->select('cfm_users.email', 'cfm_users.is_active', 'cfm_users.last_login', DB::expr('cfm_users.created_at AS profile_created_at'), DB::expr('cfm_users.updated_at AS profile_activated_at'), 'cfm_pre_qualification.*', DB::expr('count(cfm_client_personal_info.user_id) AS clients_count'))
                    ->join('cfm_users', 'RIGHT OUTER')
                    ->on('user_id', '=', 'cfm_users.id')
                    ->join('cfm_pre_qualification', 'RiGHT OUTER')
                    ->on('cfm_pre_qualification.user_id', '=', 'cfm_users.id')
                    ->join('cfm_client_personal_info', 'RiGHT OUTER')
                    ->on('cfm_client_personal_info.user_id', '=', 'cfm_users.id')
                    ->where('cfm_users.id', '=', $data)
                    ->find()
                    ->as_array();
            $user_info['last_login'] = Date::fuzzy_span($user_info['last_login']);

            return array('success' => true, "user_info" => $user_info);
        } catch (ErrorException $ex) {
            return array('success' => false, "message" => "Internal sever problem");
        }
    }

}

?>