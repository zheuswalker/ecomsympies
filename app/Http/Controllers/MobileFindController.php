<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cryptor;
use App\Decryptor;
use App\Encryptor;

class MobileFindController extends Controller
{
    public function find_mycircles()
    {	
        db::select("CALL insert_enckey();");
        $keypasswordres = db::select("CALL get_enckey();");
        foreach ($keypasswordres as $row) { $keypassword = $row->key_password; }
        db::select("CALL drop_enckey();");
        
        $encusername = trim($_POST['username']);
        
        $cryptor = new Decryptor;
        $username = $cryptor->decrypt($encusername, $keypassword);
        
        

    	$feedcontent = \DB::SELECT("select rac_accountid, rac_username, rac_profilepicture, rac_fullname from  r_account_credentials where  rac_accountid in (select rmmc_circlepoint from r_messages_mycircle where rmmc_circlecenter = (select rac_accountid from r_account_credentials where rac_username = '$username'))");

    	$output = json_encode(array('searchvalue' => $feedcontent );
		
		if($output == "") {
            echo "";
        }else {
            echo $output;    
        }
    }

    public function findfollowers()
    {	
    	db::select("CALL insert_enckey();");
        $keypasswordres = db::select("CALL get_enckey();");
        foreach ($keypasswordres as $row) { $keypassword = $row->key_password; }
        db::select("CALL drop_enckey();");
        
        $encusername = trim($_POST['username']);
        
        $cryptor = new Decryptor;
        $username = $cryptor->decrypt($encusername, $keypassword);
    	$feedcontent = \DB::SELECT("select rac_accountid, rac_username, rac_profilepicture, rac_fullname from t_account_friends inner join r_account_credentials on r_account_credentials.rac_accountid = t_account_friends.tafr_friendlyuserid where tafr_userprofileid = (select rac_accountid from r_account_credentials where rac_username = '$username') and tafr_isfollowed = 1 and tafd_isaccepted = 1 ");

    	$output = json_encode(array('searchvalue' => $feedcontent );
		
		if($output == "") {
            echo "";
        }else {
            echo $output;    
        }
    }

    public function findfollowers_mycirles()
    {	
    	db::select("CALL insert_enckey();");
        $keypasswordres = db::select("CALL get_enckey();");
        foreach ($keypasswordres as $row) { $keypassword = $row->key_password; }
        db::select("CALL drop_enckey();");
        
        $encusername = trim($_POST['username']);
        
        $cryptor = new Decryptor;
        $username = $cryptor->decrypt($encusername, $keypassword);
    	
        $feedcontent = \DB::SELECT("select rac_accountid, rac_username, rac_profilepicture, rac_fullname from t_account_friends inner join r_account_credentials on r_account_credentials.rac_accountid = t_account_friends.tafr_friendlyuserid where tafr_userprofileid = (select rac_accountid from r_account_credentials where rac_username = 'playhouse') and tafr_isfollowed = 1 and tafd_isaccepted = 1 and tafr_friendlyuserid not in (select rmmc_circlepoint from r_messages_mycircle where rmmc_circlecenter = (select rac_accountid from r_account_credentials where rac_username = '$username'))");

    	$output = json_encode(array('searchvalue' => $feedcontent ));

		if($output == "") {
            echo "";
        }else {
            echo $output;    
        }
    }

    public function findfollowing() 
    {
        db::select("CALL insert_enckey();");
        $keypasswordres = db::select("CALL get_enckey();");
        foreach ($keypasswordres as $row) { $keypassword = $row->key_password; }
        db::select("CALL drop_enckey();");
        
        $encusername = trim($_POST['username']);
        
        $cryptor = new Decryptor;
        $username = $cryptor->decrypt($encusername, $keypassword);

        $feedcontent = \DB::SELECT("select rac_accountid, rac_username, rac_profilepicture, rac_fullname from t_account_friends inner join r_account_credentials on r_account_credentials.rac_accountid = t_account_friends.tafr_userprofileid where tafr_friendlyuserid = (select rac_accountid from r_account_credentials where rac_username = '$username') and tafr_isfollowed = 1 and tafd_isaccepted = 1");

        $output = json_encode(array('searchvalue' => $feedcontent ));

        if($output == "") {
            echo "";
        }else {
            echo $output;    
        }
    }

    public function findgetyouer() 
    {
        db::select("CALL insert_enckey();");
        $keypasswordres = db::select("CALL get_enckey();");
        foreach ($keypasswordres as $row) { $keypassword = $row->key_password; }
        db::select("CALL drop_enckey();");
        
        $encusername = trim($_POST['username']);
        $encpostid = $_POST['postid'];

        $cryptor = new Decryptor;
        $username = $cryptor->decrypt($encusername, $keypassword);
        $postid = $cryptor->decrypt($encpostid, $keypassword);


        $feedcontent = \DB::SELECT("select rac_username,rac_fullname,rac_profilepicture,rac_accounttype , rac_shortbio, (select tafr_isfollowed from t_account_friends where tafr_friendlyuserid = (select rac_accountid from r_account_credentials where rac_username = '$username') and tafr_userprofileid in (select rac_accountid from r_account_credentials where rac_username = rac.rac_username)) isfollowed from r_account_credentials as rac inner join r_post_getyou on r_post_getyou.rpg_actormakeget = rac.rac_accountid where rpg_postrelate = '$postid'");
        
        $output = json_encode(array('searchvalue' => $feedcontent ));

       if($output == "") {
            echo "";
        }else {
            echo $output;    
        }
    }
    
    public function getFriendRequest() 
    {
        db::select("CALL insert_enckey();");
        $keypasswordres = db::select("CALL get_enckey();");
        foreach ($keypasswordres as $row) { $keypassword = $row->key_password; }
        db::select("CALL drop_enckey();");
        
        $encusername = trim($_POST['username']);
        $username = $cryptor->decrypt($encusername, $keypassword);

        $feedcontent = \DB::SELECT("select rac_username, rac_useraddress,rac_profilepicture from t_account_friends inner join r_account_credentials on r_account_credentials.rac_accountid = t_account_friends.tafr_friendlyuserid where tafr_userprofileid = (select rac_accountid from r_account_credentials where rac_username = '$username') and tafd_isaccepted = 0");
        
        $output = json_encode(array('friendrequest' => $feedcontent ));
        if($output == "") {
            echo "";
        }else {
            echo $output;    
        }
    }
     
}
