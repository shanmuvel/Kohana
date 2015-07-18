<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Welcome extends Controller {

    public $template = 'site';

    public function action_index() {

        // Load the user information
        $user = Auth::instance()->get_user();

        $this->template->content = View::factory('welcome/info')
                ->bind('user', $user);

        // if a user is not logged in, redirect to login page
        if (!$user) {
            $this->redirect('welcome/login');
        }
    }

    public function action_create() {
        if (HTTP_Request::POST == $this->request->method()) {
            try {
                $date = new DateTime();

                $user = ORM::factory('User');
                $user->email = $this->request->post('email');
                $user->password = $this->request->post('password');
                $user->is_active = 1;
                $user->created_at = $date->format('Y-m-d H:i:s');
                $user->updated_at = $date->format('Y-m-d H:i:s');
                $user->save();

                // Grant user login role
                $user->add('roles', ORM::factory('Role', array('name' => 'agent')));

                // Reset values so form is not sticky
                $_POST = array();

                // Set success message
                $message = "You have added user '{$user->email}' to the database";
            } catch (ORM_Validation_Exception $e) {

                // Set failure message
                $message = 'There were errors, please see form below.';

                // Set errors using custom messages
                $errors = $e->errors('models');
            }
        }
        $this->template->content = View::factory('user/create')
                ->bind('errors', $errors)
                ->bind('message', $message);
    }

    public function action_login() {
        $this->template->content = View::factory('user/login')
                ->bind('message', $message);

        if (HTTP_Request::POST == $this->request->method()) {
            // Attempt to login user
            $remember = array_key_exists('remember', $this->request->post()) ? (bool) $this->request->post('remember') : FALSE;
            $user = Auth::instance()->login($this->request->post('username'), $this->request->post('password'), $remember);

            // If successful, redirect user
            if ($user) {
                $this->redirect('welcome/index');
            } else {
                $message = 'Login failed';
            }
        }
    }

    public function action_logout() {
        // Log user out
        Auth::instance()->logout();

        // Redirect to login page
        $this->redirect('welcome/login');
    }

}

// End Welcome
