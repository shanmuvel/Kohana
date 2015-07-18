<?php defined('SYSPATH') or die('No direct script access.');

class cfm_client_financial_info extends Migration
{
  public function up()
  {
     $this->create_table
     (
       'cfm_client_financial_info',
       array
       (
         'client_id'           => array('integer', 'null' => false),
         'finance_type'        => array('string[30]'),
         'dept_description'    => array('string[50]'),
         'dept_amount'         => array('decimal[15,2]'),
         'interest_rate'       => array('float'),
         'amount_period'       => array('string[10]'),
         'monthly_payment'     => array('decimal[15,2]'),  
         'created_at'          => array('datetime', 'null' => false),  
         'updated_at'          => array('datetime', 'null' => false),
       )
     );
     
     $this->add_foreign_key('cfm_client_financial_info', 'client_id', 'cfm_client_personal_info', 'id');
  }

  public function down()
  {
  }
}