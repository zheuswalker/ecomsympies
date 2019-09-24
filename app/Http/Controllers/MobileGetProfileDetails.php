<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MobileGetProfileDetails extends Controller
{
    public function getProfileDetails()
    {
    	$feedcontent = \DB::SELECT("select rac_fullname,(select count(tafr_isfollowed) from t_account_friends WHERE tafr_friendlyuserid =(select rac_accountid from r_account_credentials where rac_username = '?') and tafr_isfollowed = 1 and tafd_isaccepted = 1) following, count(tafr_isfollowed) followers, rac_profilepicture,rac_password, rac_accountid,rac_shortbio,rac_accounttype, rac_email, rac_pnumb, rac_username from t_account_friends inner join r_account_credentials on r_account_credentials.rac_accountid = tafr_userprofileid where tafr_userprofileid =(select rac_accountid from r_account_credentials where rac_username = '?') and tafr_isfollowed = 1", ['playhouse','playhouse']);

        $output = json_encode(array('profiledetails' => $feedcontent ));
        echo $output;
    }
}
