<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cryptor;
use App\Decryptor;
use App\Encryptor;


class MobileGetNotificationsController extends Controller
{
    public function getNotifications()
    {
    	db::select("CALL insert_enckey();");
        $keypasswordres = db::select("CALL get_enckey();");
        foreach ($keypasswordres as $row) { $keypassword = $row->key_password; }
        db::select("CALL drop_enckey();");
        $encusername = trim($_POST['username']);

        $cryptor = new Decryptor;
        $username = $cryptor->decrypt($encusername, $keypassword);
        
    	$feedcontent = \DB::SELECT("select (select t_account_feeds.tafd_imotion from t_account_feeds where t_account_feeds.tafd_postid = r_account_notification.ran_postid) imotion,ran_postid,ran_notificationbody,DATE_FORMAT(ran_activitydate,'%M %d, %Y') ran_activitydate , rac_profilepicture, ran_notificationid from r_account_notification inner join t_account_feeds on t_account_feeds.tafd_postid = r_account_notification.ran_postid inner join r_account_credentials on r_account_credentials.rac_accountid= ran_notifyby where ran_notifywho = (select rac_accountid from r_account_credentials where rac_username = ? ) order by ran_activitydate desc ", [$username]);

    	$output = json_encode(array('notifications' => $feedcontent	));
		if($output == "") {
            echo "";
        }else {
            echo $output;    
        }
    }

    public function getOtherProfile()
    {	
        db::select("CALL insert_enckey();");
        $keypasswordres = db::select("CALL get_enckey();");
        foreach ($keypasswordres as $row) { $keypassword = $row->key_password; }
        db::select("CALL drop_enckey();");

        $encactor = trim($_POST['actor']);
        $encpeople = trim($_POST['people']);

        $cryptor = new Decryptor;
        $actor = $cryptor->decrypt($encactor, $keypassword);
    	$people = $cryptor->decrypt($encpeople, $keypassword);

    	$feedcontent = \DB::SELECT("select rac_fullname,(select tafr_makefriendtranscationid from t_account_friends where tafr_friendlyuserid = (select rac_accountid from r_account_credentials where rac_username = ? ) and tafr_userprofileid = (select rac_accountid from r_account_credentials where rac_username = ?)) keysent ,(select tafr_isfollowed from t_account_friends where tafr_userprofileid = (select rac_accountid from r_account_credentials where rac_username = ?) and tafr_friendlyuserid = (select rac_accountid from r_account_credentials where rac_username = 'playhouse')) isfollowed,(select tafr_isfollowed from t_account_friends where tafr_userprofileid = (select rac_accountid from r_account_credentials where rac_username = ?) and tafr_friendlyuserid = (select rac_accountid from r_account_credentials where rac_username = ?)) followingyou,(select count(tafr_isfollowed) from t_account_friends WHERE tafr_friendlyuserid =(select rac_accountid from r_account_credentials where rac_username = ?) and tafr_isfollowed = 1) following, count(tafr_isfollowed) followers, rac_profilepicture,rac_accounttype, rac_shortbio from t_account_friends inner join r_account_credentials on r_account_credentials.rac_accountid = tafr_userprofileid where tafr_userprofileid =(select rac_accountid from r_account_credentials where rac_username = ?) and tafr_isfollowed = 1",
    		[$actor, $people, $people, $actor, $actor, $people, $actor, $people]);	

    	$output = json_encode(array('otherprofiledetails' => $feedcontent));
		if($output == "") {
            echo "";
        }else {
            echo $output;    
        }
    }

    public function LiveNotification()
    {
        db::select("CALL insert_enckey();");
        $keypasswordres = db::select("CALL get_enckey();");
        foreach ($keypasswordres as $row) { $keypassword = $row->key_password; }
        db::select("CALL drop_enckey();");
        $encran_notifywho = trim($_POST['ran_notifywho']);
        $cryptor = new Decryptor;
        $ran_notifywho = $cryptor->decrypt($encran_notifywho, $keypassword);

        $feedcontent = \DB::SELECT("select ran_postid,ran_notificationbody,DATE_FORMAT(ran_activitydate,'%M %d, %Y') ran_activitydate , ran_notificationid from r_account_notification inner join t_account_feeds on t_account_feeds.tafd_postid = r_account_notification.ran_postid inner join r_account_credentials on r_account_credentials.rac_accountid= ran_notifyby where ran_notifywho = (select rac_accountid from r_account_credentials where rac_username = ? ) order by ran_notificationid desc limit 1", [$ran_notifywho]);

        $output = json_encode(array('notifications' => $feedcontent ));
        if($output == "") {
            echo "";
        }else {
            echo $output;    
        }
    }

    
}
