<?php namespace SecureCredentials\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class SecureGUID extends Eloquent {
    // protected $fillable = ['first_name', 'last_name', 'email'];
    // public $timestamps = false;

    // protected $table = 'sc_secure_users';

    /*
     * 
     */
    function getGUID() {
	    if (function_exists('com_create_guid')){
	        return com_create_guid();
	    }else{
	        mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
	        $charid = strtoupper(md5(uniqid(rand(), true)));
	        $hyphen = chr(45);// "-"
	        $uuid = substr($charid, 0, 8).$hyphen
	            .substr($charid, 8, 4).$hyphen
	            .substr($charid,12, 4).$hyphen
	            .substr($charid,16, 4).$hyphen
	            .substr($charid,20,12);
	        return $uuid;
	    }
	}
}