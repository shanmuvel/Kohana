
<?php defined('SYSPATH') or die('No direct script access.');

 class Model_User extends Model_Auth_User {

    protected $_table_name = 'cfm_users';
    protected $_has_many = array(
        'user_tokens' => array('model' => 'User_Token'),
        'roles' => array('model' => 'Role', 'through' => 'cfm_roles_users'),
    );

    /**
     * This function used to remove username field from the validation array.
     * Note: In future if you want to add username field in user table you can add itself.
     * @return array Rules
     */
    public function rules() {
        return array(
            'email' => array(
                array('not_empty'),
                array('email'),
                array(array($this, 'unique'), array('email', ':value')),
            ),
        );
    }

}