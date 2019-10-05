<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\r_account_credential;
use App\Cryptor;
use App\Decryptor;
use App\Encryptor;
use DB;
//$submit = DB::select(" EXEC ReturnIdExample ?,?", array( $paramOne ,$paramTwo ) );
class MobileLoginController extends Controller
{
    public function getLogin()
    {

        db::select("CALL insert_enckey();");
        $keypasswordres = db::select("CALL get_enckey();");
        foreach ($keypasswordres as $row) { $keypassword = $row->key_password; }
        db::select("CALL drop_enckey();");
        
        $cryptor = new Encryptor;
        $uname = $cryptor->encrypt("playhouse", $keypassword);
        $upass = $cryptor->encrypt("playhouse", $keypassword);

        $encusername = $uname;
        $encpassword = $upass;
        
        $cryptor = new Decryptor;
        $username = $cryptor->decrypt($encusername, $keypassword);
        $password = $cryptor->decrypt($encpassword, $keypassword);
        
    	$info = "";
    	
    	$result = \DB::TABLE('r_account_credentials')
    	->where('rac_username', $username)
    	->where('rac_password',  \db::raw("md5('$password')"))
    	//->orwhere('rac_email',$username)
    	->where('rac_password', \db::raw("md5('$password')"))
    	->count();

    	if ($result > 0) {
    		$info = \DB::TABLE('r_account_credentials')
    		->where('rac_username',$username)
    		->where('rac_password',  \db::raw("md5('$password')"))
    		->select('rac_username')
    		->get();
    	}
    	else {
    		$info = "";
    		if (\DB::TABLE('r_account_credentials')->where('rac_email',$username)->where('rac_password', \db::raw("md5('$password')"))->COUNT() > 0) {
    			$checksocial = \DB::TABLE('r_account_credentials')
    			->where('rac_email',$username)
    			->where('rac_password', \db::raw("md5('$password')"))
    			->select('rac_socialsignin')->get();
    			$info = $checksocial;	
    		}
    		else
    		{
    			$info = "false";
    		}
    	}
        
        echo $info;
    	
    }
}

 // db::table('r_account_credentials')
 //        ->where('rac_username','playhouse')
 //        ->update([
 //            'rac_password' => db::raw("md5('playhouse')")
 //        ]);

 //        