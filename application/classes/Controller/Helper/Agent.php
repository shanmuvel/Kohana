<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * Helper Class for User Module. It handles the some common helper functions
 * @author  Shanmuganathan
 */

class Controller_Helper_Agent extends Controller {
    
    public static function get_g27() {     
        $rate = self::get_j24();
        $np = self::get_number_of_payments();
        $loan = self::get_b24();        
        $g27 = self::pmt($rate, $np, $loan);
        return $g27;
    }
    
    public static function get_g26() {
        $g11 = self::get_g11();
        $g21 = self::get_g21();
        $g26 = $g11+$g21;
        return $g26;
    }
    
    public static function get_g41() {
        $h24 = self::get_h24();
        $g41 = $h24/12;
        return $g41;
    }
    
    public static function get_h41() {
        $h9 = self::get_h9();
        $h10 = self::get_h10();
        $h13 = self::get_h13();
        $h41 = max($h9+$h10, $h13)/12;
        return $h41;
    }
    
    public static function get_g35() {
        $k24 = self::get_k24();
        $b24 = self::get_b24();
        $g35 = $k24-$b24;
        return round($g35);
    }
    
    public static function get_h35() {
        $l11 = self::get_l11();
        $l21 = self::get_l21();
        $h35 = $l11+$l21;
        return round($h35);
    } 

    public static function get_number_of_payments() {
        $d24 = self::get_d24();
        return $d24*12;
    }
    
    public static function get_b24() {
        $b22 = self::get_b22();
        $g11 = self::get_g11();
        $b24 = $b22+$g11*3+6000+3000;
        return $b24;
    }
    
    public static function get_b22() {
        $b11 = self::get_b11();
        $b21 = self::get_b21();
        $b22 = $b11+$b21;
        return $b22;
    }
    
    public static function get_b11() {
        $b9 = self::get_b9();
        $b10 = self::get_b10();
        $b11 = $b9+$b10;
        return $b11;
    }
    
    public static function get_b9() {
        $config = Kohana::$config->load('myconf');
        $client_info = self::get_financial_data($config->client_finance_type["type1"]);
        return $b9 = $client_info->dept_amount;
    }
    
    public static function get_b10() {
        $config = Kohana::$config->load('myconf');
        $client_info = self::get_financial_data($config->client_finance_type["type2"]);
        return $b10 = $client_info->dept_amount;
    }
    
    public static function get_b21() {
        return $b21 = self::get_b13();
    }
    
    public static function get_b29() {
        return $b29 = 50/100; // 50% Applied to Nest Engg
    }

    public static function get_b13() {
        $config = Kohana::$config->load('myconf');
        $client_info = self::get_financial_data($config->client_finance_type["type3"]);
        return $b13 = $client_info->dept_amount;
    }
    
    public static function get_g9() {
        $config = Kohana::$config->load('myconf');
        $client_info = self::get_financial_data($config->client_finance_type["type1"]);
        return $g9 = $client_info->monthly_payment;
    }
    
    public static function get_g10() {
        $config = Kohana::$config->load('myconf');
        $client_info = self::get_financial_data($config->client_finance_type["type2"]);
        return $g10 = $client_info->monthly_payment;
    }
    
    public static function get_g11() {
        $g9 = self::get_g9();
        $g10 = self::get_g10();
        $g11 = $g9+$g10;
        return $g11;
    }
    
    public static function get_g13() {
        $config = Kohana::$config->load('myconf');
        $client_info = self::get_financial_data($config->client_finance_type["type3"]);
        return $g13 = $client_info->monthly_payment;
    }

    public static function get_g21() {
        return $g21 = self::get_g13();
    }
    
    public static function get_g24() {
        $g27 = self::get_g27();
        $g29 = self::get_g29();
        $g24 = $g27+$g29;
        return $g24;
    }
    
    public static function get_g28() {
        $g26 = self::get_g26();
        $g27 = self::get_g27();
        $g28 = $g26-$g27; 
        return $g28;
    }

    public static function get_g29() {
        $b29 = self::get_b29();
        $g28 = self::get_g28();
        $g29 = $g28;
        if($b29 < 1):
            $g29 = $g28*$b29;
        endif;
        return $g29;
    }
    
    public static function get_h9() {
        $b9 = self::get_b9();
        $g9 = self::get_g9();
        $j9 = self::get_j9();
        $h9 = -log(1-$b9*$j9/$g9)/log(1+$j9);
        return $h9;
    }
    
    public static function get_h10() {
        $b10 = self::get_b10();
        $j10 = self::get_j10();
        $g10 = self::get_g10();
        
        if($b10>0):
            $h10 = -log(1-$b10*$j10/$g10)/log(1+$j10);
        else:
            $h10 = 0;
        endif;
        
        return $h10;
    }
    
    public static function get_h13() {
       $b13 = self::get_b13();
       $j13 = self::get_j13();
       $g13 = self::get_g13();
       
        if($b13>0):
            $h13 = -log(1-$b13*$j13/$g13)/log(1+$j13);
        else:
            $h13 = 0;
        endif;
        
        return $h13;
    }

    public static function get_h24() {
        $b24 = self::get_b24();
        $j24 = self::get_j24();
        $g24 = self::get_g24();
        $h24 = -log(1-$b24*$j24/$g24)/log(1+$j24);
        return $h24;
    }
    
    public static function get_j9() {
        $c9 = self::get_c9();
        $f9 = self::get_f9();
        $e9 = self::get_e9();
        $j9 = pow(1+($c9/$f9), ($f9/$e9))-1;
        return $j9;
    }
    
    public static function get_j10() {
        $b10 = self::get_b10();
        $c10 = self::get_c10();
        $f10 = self::get_f10();
        $e10 = self::get_e10();
        
        if($b10>0):
            $j10 = pow((1+($c10/$f10)), ($f10/$e10)-1);
        else:
            $j10 = 0;
        endif;
        
        return $j10;            
    }
    
    public static function get_j13() {
        $c13 = self::get_c13();
        $f13 = self::get_f13();
        $e13 = self::get_e13();
        $j13 = pow((1+($c13/$f13)), ($f13/$e13))-1;
        return $j13;
    }

    public static function get_j24() {      
        $c24 = self::get_c24();
        $f24 = self::get_f24();
        $e24 = self::get_e24();
        $j24 = pow((1+($c24/$f24)), ($f24/$e24))-1;
        return number_format($j24, 10);
    }
    
    public static function get_k24() {
        $g24 = self::get_g24();
        $h24 = self::get_h24();
        $k24 = $g24*$h24;
        return $k24;
    }
    
    public static function get_l9() {
        $g9 = self::get_g9();
        $h9 = self::get_h9();
        $b9 = self::get_b9();
        $l9 = $g9*$h9-$b9;
        return $l9;
    }
    
    public static function get_l10() {
        $g10 = self::get_g10();
        $h10 = self::get_h10();
        $b10 = self::get_b10();
        $l10 = $g10*$h10-$b10;
        return $l10;
    }

    public static function get_l11() {
        $l9 = self::get_l9();
        $l10 = self::get_l10();
        $l11 = $l9+$l10;
        return $l11;
    }
    
    public static function get_l13() {
        $g13 = self::get_g13();
        $h13 = self::get_h13();
        $b13 = self::get_b13();
        $l13 = $g13*$h13-$b13;
        return $l13;
    }

    public static function get_l21() {
        $l13 = self::get_l13();
        return $l21 = $l13;
    }

    public static function get_c9() {
        $config = Kohana::$config->load('myconf');
        $client_info = self::get_financial_data($config->client_finance_type["type1"]);
        return $c9 = $client_info->interest_rate/100; // Rate of interest 3.50%
    }
    
    public static function get_c10() {
        $config = Kohana::$config->load('myconf');
        $client_info = self::get_financial_data($config->client_finance_type["type2"]);
        return $c10 = $client_info->interest_rate/100; // Rate of interest 10.00%
    }
    
    public static function get_c13() {
        $config = Kohana::$config->load('myconf');
        $client_info = self::get_financial_data($config->client_finance_type["type3"]);
        return $c13 = $client_info->interest_rate/100; // Rate of interest 17.00%
    }

    public static function get_c24() {
        return $c24 = 3.50/100; // 3.50%(Prime Rate)
    }
    
    public static function get_d24() {
        return $d24 = 25.0; // Default value
    }

    public static function get_f10() {
        return $f10 = 2; // Default value;
    }
    
    public static function get_f13() {
        return $f13 = 12; // Default value
    }

    public static function get_f24() {
        return $f24 = 2; // Default value
    }
    
    public static function get_e9() {
        return $e9 = 12; // Default value
    }
    
    public static function get_e10() {
        return $e10 = 12; // Default value
    }
    
    public static function get_e13() {
        return $e13 = 12; // Default value
    }

    public static function get_f9() {
        return $f9 = 2; // Default value
    }

    public static function get_e24() {
        return $e24 = 12; // Default value
    }

    public static function pmt($i, $n, $p) {
        $amount = -($i * $p * pow((1 + $i), $n) / (1 - pow((1 + $i), $n)));
        return $amount;
    }
    
    public static function get_financial_data($type) {
        $client_id = $_SESSION['id'];
        $financial_data = ORM::factory('ClientFinancialInfo')
                ->where('client_id', '=', $client_id)
                ->and_where('finance_type', '=', $type)
                ->find();

        return $financial_data;
    }

}
