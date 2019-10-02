<?php

namespace App\Http\Controllers;

use App\Models\CompanyList;
use App\Models\PrimaryInfo;
use Illuminate\Http\Request;

class CommonController extends Controller
{
    
    static public function slugify($text){
	// replace non letter or digits by -
	$text = preg_replace('~[^\pL\d]+~u', '-', $text);
	// transliterate
	//$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
	// remove unwanted characters
	$text = preg_replace('~[^-\w]+~', '', $text);
	// trim
	$text = trim($text, '-');
	// remove duplicate -
	$text = preg_replace('~-+~', '-', $text);
	// lowercase
	$text = strtolower($text);
	if (empty($text)) {
	return 'n-a';
	}
	return $text;
	}
    /* Convert in word taka */
    static public function taka($number){
        $decimal = round($number - ($no = floor($number)), 2) * 100;
                $hundred = null;
                $digits_length = strlen($no);
                $i = 0;
                $str = array();
                $words = array(0 => '', 1 => 'One', 2 => 'Two',
                        3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
                        7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
                        10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
                        13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
                        16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
                        19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
                        40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
                        70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
                $digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
                while( $i < $digits_length ) {
                        $divider = ($i == 2) ? 10 : 100;
                        $number = floor($no % $divider);
                        $no = floor($no / $divider);
                        $i += $divider == 10 ? 1 : 2;
                        if ($number) {
                                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                                $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
                            } else $str[] = null;
        }
        $Taka = implode('', array_reverse($str));
        $paise = ($decimal) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Poysha' : '';
        return ($Taka ? $Taka . ' Taka Only ' : '');
    }


    static public function company(){
        return CompanyList::findOrFail(\Auth::user()->fk_company_id);
    }
    static public function info(){
        return PrimaryInfo::first();
    }
    static public function dateFormate($date){
        return date('Y-m-d', strtotime($date));
    }
    static public function dateOutput($date){
        return date('d-M-Y', strtotime($date));
    }
}
