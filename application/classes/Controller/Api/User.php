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
class Controller_Api_User extends Controller {

    /**
     * User Login API function
     * 
     * @param type $data
     * @return type $response as array
     */
    public static function login($data) {
        // $remember = array_key_exists('remember', $data) ? (bool) $data['remember'] : FALSE;
        // User Authentication
        $login = Auth::instance()->login($data['username'], $data['password'], FALSE);

        if ($login):
            // Get logged in user details
            $user = Auth::instance()->get_user();
            $user_role = ORM::factory('RoleUser')->where("user_id", '=', $user->id)->find();

            // Check if user is active state
            if ($user->is_active == TRUE && $user->is_remove == FALSE):
                $response = array("success" => true, "user_id" => $user->id, "user_role" => $user_role->role_id);
            elseif ($user->is_active == FALSE && $user->is_remove == FALSE):
                $response = array("success" => false, "message" => "Sorry your account is not activated.");
            else:
                $response = array("success" => false, "message" => "Sorry your account has been suspended. Please contact our support team");
            endif;

        else:
            $response = array("success" => false, "message" => "Username or password is incorrect");
        endif;

        return $response;
    }
    
    
    /**
     * User Signup API function
     * @param type $data
     * @return type $response as array
     */
    public static function signup($data) {
        $date = new DateTime();
        $email = $data['email'];
        $user = ORM::factory('User')->where("email", "=", $email)->count_all();
        if ($user > 0):
            $response = array('success' => false, 'message' => "The agent '$email' was already registered");
        else:
            $signup = ORM::factory('User');
            $signup->email = $email;
            $signup->is_active = 0;
            $signup->is_remove = 0;
            $signup->created_at = $date->format('Y-m-d H:i:s');
            $signup->updated_at = $date->format('Y-m-d H:i:s');
            $signup->save();
            
            // Grant user login role
            $signup->add('roles', ORM::factory('Role', array('name' => 'agent')));
                
            self::save_user_registration_code($signup->id, $email);
            $response = array('success' => true, 'message' => "The agent '$email' has been successfully registered");
        endif;
        
        return $response;
    }
    
    
    /**
     * Save User Registration Code
     * @param type $user_id
     */
    public static function save_user_registration_code($user_id, $email) {
        $config_path = Kohana::$config->load('myconf');
        $registration_code = Controller_Helper_User::generate_alpha_numeric_code($config_path->user_registration_code_length);
        $user_registration_code = ORM::factory('UserRegistrationCode');
        $user_registration_code->user_id = $user_id;
        $user_registration_code->registration_code = $registration_code;
        $user_registration_code->save();
        
        // Send registration code to user through the email
        self::send_signup_email($email, $registration_code, $config_path->code_verification_url, $user_id);
    }
    
    
    /**
     * Send Signup Email to resgistered user with registration code
     * @param type $email
     */
    public static function send_signup_email($email, $registration_code, $url, $user_id) {
        $message = View::factory('template/mail/signup')
                ->bind('email', $email)
                ->bind('registration_code', $registration_code)
                ->bind('user_id', $user_id)
                ->bind('url', $url);
        $mail = array(
            'subject' => 'Welcome to KRCFM',
            'body' => $message,
            'from' => array('admin@myschedule.org' => 'KRCFM'),
            'to' => $email
        );
        
        Email::send('default', $mail['subject'], $mail['body'], $mail['from'], $mail['to'], 'text/html');
    }
    
    
    /**
     * User Code Verification API function
     * @param type $data
     * @return type $response as array
     */
    public static function user_code_verification($data) {
        try {
            $user_registration_code = ORM::factory('UserRegistrationCode')
                    ->where("user_id", "=", $data['user_id'])
                    ->and_where("registration_code", "=", $data["code"])
                    ->find();

            if ($user_registration_code != NULL):
                $user_registration_code->delete();
                $response = array('success' => true, 'message' => "Success");
            else:
                $response = array('success' => false, 'message' => "Invalid Code");
            endif;
        } catch (ErrorException $ex) {
            $response = array('success' => false, 'message' => "Invalid Code");
        }
        return $response;
    }
    
    /**
     * User Profile creation API function
     * @param type $data
     * @return type $response as array
     */
    public static function create_user_profile($data) {

        try {
            // Update User Details
            $user = ORM::factory('User', $data['user_id']);
            $user->password = $data['password'];
            $user->save();

            $user_info = ORM::factory('UserInfo')->where('user_id', '=', $data['user_id'])->count_all();
            if ($user_info > 0):
                self::update_profile_info($data);
                $response = array('success' => true, 'message' => "Profile was successfully updated");
            else:
                self::create_profile_info($data, $user->email);
                $response = array('success' => true, 'message' => "Success!! Profile was successfully created and activation link has been sent your mail.");
            endif;
        } catch (ErrorException $ex) {
            $response = array('success' => false, 'message' => "Sorry, Invalid Request or internal problem");
        }

        return $response;
    }

    /**
     * Create New Profile Info
     * @param type $user_id
     */
    public static function create_profile_info($data, $email) {
        $config_path = Kohana::$config->load('myconf');
        $date = new DateTime();
        $user_info = ORM::factory('UserInfo');
        $user_info->user_id = $data['user_id'];
        $user_info->first_name = $data['firstname'];
        $user_info->last_name = $data['lastname'];
        $user_info->company_name = $data['company'];
        $user_info->telephone_number = $data['phoneno'];
        $user_info->created_at = $date->format('Y-m-d H:i:s');
        $user_info->updated_at = $date->format('Y-m-d H:i:s');
        $user_info->save();
        
        // Send profile activation email to user
        self::send_profile_activation_email($config_path->profile_activation_url, $data['user_id'], $data['firstname'], $email);
    }
    
     /**
     * Send Profile activation email to registered user
     * @param type $email
     */
    public static function send_profile_activation_email($url, $user_id, $name, $email) {
        $message = View::factory('template/mail/profile_activation')
                ->bind('name', $name)
                ->bind('user_id', $user_id)
                ->bind('url', $url);
        $mail = array(
            'subject' => 'KRCFM-Profile Activation',
            'body' => $message,
            'from' => array('admin@myschedule.org' => 'KRCFM'),
            'to' => $email
        );

        Email::send('default', $mail['subject'], $mail['body'], $mail['from'], $mail['to'], 'text/html');
    }
    
     /**
     * Create New Profile Info
     * @param type $user_id
     */
    public static function update_profile_info($data) {
        $date = new DateTime();
        $user_info = ORM::factory('UserInfo')->where('user_id', '=', $data['user_id'])->find();
        $user_info->first_name = $data['firstname'];
        $user_info->last_name = $data['lastname'];
        $user_info->company_name = $data['company'];
        $user_info->telephone_number = $data['phoneno'];
        $user_info->updated_at = $date->format('Y-m-d H:i:s');
        $user_info->save();
    }
    
    /**
     * Get User Info
     * @param type $data
     * @return type as Array
     */
    public static function get_user_info($data) {
        $user_info = ORM::factory('UserInfo')
                ->select('cfm_users.email')
                ->join('cfm_users', 'RIGHT OUTER')
                ->on('user_id', '=', 'cfm_users.id')
                ->where('cfm_users.id', '=', $data)
                ->find()
                ->as_array();

        return $user_info;
    }
    
    /**
     * User Profile Activation
     * @param type $data
     * @return type as Array
     */
    public static function user_profile_activation($data) {
        try {
            $user = ORM::factory('User', $data['user_id']);
            $user->is_active = 1;
            $user->save();
            $response = array('success' => true, 'message' => "Your Profile has been successfully activated");
        } catch (ErrorException $ex) {
            $response = array('success' => false, 'message' => "Sorry, Invalid Request or internal problem");
        }
        return $response;
    }
}

?>