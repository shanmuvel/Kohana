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

            // Check if user is active state
            if ($user->is_active == TRUE && $user->is_remove == FALSE):
                $response = array("success" => true);
            elseif ($user->is_active == FALSE && $user->is_remove == FALSE):
                $response = array("success" => false, "message" => "Sorry your account is not yet activated.");
            else:
                $response = array("success" => false, "message" => "Sorry your account was supended. Please contact our administrator.");
            endif;

        else:
            $response = array("success" => false, "message" => "Username or password is incorrect");
        endif;

        return $response;
    }
    
    /**
     * User Signup API function
     * @param type $data
     * @return type Description
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
            self::save_user_registration_code($signup->id, $email);
            $response = array('success' => true, 'message' => "The agent '$email' was successfully registered");
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
        self::send_signup_email($email, $registration_code, $config_path->code_verification_url);
    }
    
    /**
     * Send Signup Email to resgistered user with registration code
     * @param type $email
     */
    public static function send_signup_email($email, $registration_code, $url) {
        $message = View::factory('template/mail/signup')
                ->bind('email', $email)
                ->bind('registration_code', $registration_code)
                ->bind('url', $url);
        $mail = array(
            'subject' => 'Welcome to KRCFM',
            'body' => $message,
            'from' => array('admin@myschedule.org' => 'KRCFM'),
            'to' => "shanmu.grs24@gmail.com"
        );
        
        Email::send('default', $mail['subject'], $mail['body'], $mail['from'], $mail['to'], 'text/html');
    }

}

?>