<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * User Module API functions. Handles user signup, login and logout, as well as secure
 * password hashing.
 * 
 * @param type $data
 * @return $response as array
 * @author  Shanmuganathan
 */
class Controller_Api_Admin extends Controller {

    /**
     * Get Agent List
     * @return type as Array
     */
    public static function get_agent_list() {

        $agents = ORM::factory('User')
                ->select('cfm_roles_users.role_id', 'cfm_user_info.*')
                ->join('cfm_roles_users', 'LEFT OUTER')
                ->on('user.id', '=', 'cfm_roles_users.user_id')
                ->join('cfm_user_info', 'LEFT OUTER')
                ->on('user.id', '=', 'cfm_user_info.user_id')
                ->where('cfm_roles_users.role_id', '=', 1)
                ->order_by('user.id', 'ASC')
                ->find_all();

        $agent_list = array();
        foreach ($agents as $agent):
            $agent_info = array();
            $agent_info['id'] = $agent->id;
            $agent_info['first_name'] = $agent->first_name;
            $agent_info['last_name'] = $agent->last_name;
            $agent_info['company_name'] = $agent->company_name;
            $agent_info['email'] = $agent->email;
            $agent_info['is_active'] = (bool) $agent->is_active;
            $agent_info['is_remove'] = (bool) $agent->is_remove;
            $agent_info['clients'] = ORM::factory('ClientPersonalInfo')->where('user_id', '=', $agent->id)->count_all();
            $agent_list[] = $agent_info;
        endforeach;

        return $agent_list;
    }

}

?>