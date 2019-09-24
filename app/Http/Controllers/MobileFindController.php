<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MobileFindController extends Controller
{
    public function find_mycircles()
    {	
    	
    	$feedcontent = \DB::SELECT("select rac_accountid, rac_username, rac_profilepicture, rac_fullname from  r_account_credentials where  rac_accountid in (select rmmc_circlepoint from r_messages_mycircle where rmmc_circlecenter = (select rac_accountid from r_account_credentials where rac_username = 'rodel'))");

    	$output = json_encode(array('searchvalue' => $feedcontent );
		
		echo $output;
    }

    public function findfollowers()
    {	
    	
    	$feedcontent = \DB::SELECT("select rac_accountid, rac_username, rac_profilepicture, rac_fullname from t_account_friends inner join r_account_credentials on r_account_credentials.rac_accountid = t_account_friends.tafr_friendlyuserid where tafr_userprofileid = (select rac_accountid from r_account_credentials where rac_username = 'rodel') and tafr_isfollowed = 1 and tafd_isaccepted = 1 ");

    	$output = json_encode(array('searchvalue' => $feedcontent );
		//$jsonData = json_encode($app);
		echo $output;
    }

    public function findfollowers_mycirles()
    {	
    	
    	$feedcontent = \DB::SELECT("select rac_accountid, rac_username, rac_profilepicture, rac_fullname from t_account_friends inner join r_account_credentials on r_account_credentials.rac_accountid = t_account_friends.tafr_friendlyuserid where tafr_userprofileid = (select rac_accountid from r_account_credentials where rac_username = 'playhouse') and tafr_isfollowed = 1 and tafd_isaccepted = 1 and tafr_friendlyuserid not in (select rmmc_circlepoint from r_messages_mycircle where rmmc_circlecenter = (select rac_accountid from r_account_credentials where rac_username = 'playhouse'))");

    	$output = json_encode(array('searchvalue' => $feedcontent ));
		//$jsonData = json_encode($app);
		echo $output;
    }

    public function findfollowing() 
    {
        $feedcontent = \DB::SELECT("select rac_accountid, rac_username, rac_profilepicture, rac_fullname from t_account_friends inner join r_account_credentials on r_account_credentials.rac_accountid = t_account_friends.tafr_userprofileid where tafr_friendlyuserid = (select rac_accountid from r_account_credentials where rac_username = 'playhouse') and tafr_isfollowed = 1 and tafd_isaccepted = 1");

        $output = json_encode(array('searchvalue' => $feedcontent ));
        //$jsonData = json_encode($app);
        echo $output;
    }

    public function findgetyouer() 
    {

        $feedcontent = \DB::SELECT("select rac_username,rac_fullname,rac_profilepicture,rac_accounttype , rac_shortbio, (select tafr_isfollowed from t_account_friends where tafr_friendlyuserid = (select rac_accountid from r_account_credentials where rac_username = 'rodel') and tafr_userprofileid in (select rac_accountid from r_account_credentials where rac_username = rac.rac_username)) isfollowed from r_account_credentials as rac inner join r_post_getyou on r_post_getyou.rpg_actormakeget = rac.rac_accountid where rpg_postrelate = 4");
        
        $output = json_encode(array('searchvalue' => $feedcontent ));
        //$jsonData = json_encode($app);
        echo $output;
    }
    
    public function getFriendRequest() 
    {

        $feedcontent = \DB::SELECT("select rac_username, rac_useraddress,rac_profilepicture from t_account_friends inner join r_account_credentials on r_account_credentials.rac_accountid = t_account_friends.tafr_friendlyuserid where tafr_userprofileid = (select rac_accountid from r_account_credentials where rac_username = 'chaella') and tafd_isaccepted = 0");
        
        $output = json_encode(array('friendrequest' => $feedcontent ));
        //$jsonData = json_encode($app);
        echo $output;
    }
     
}
