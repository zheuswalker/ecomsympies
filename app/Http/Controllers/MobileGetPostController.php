<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cryptor;
use App\Decryptor;
use App\Encryptor;


class MobileGetPostController extends Controller
{
    public function getPostComments() 
    {
        db::select("CALL insert_enckey();");
        $keypasswordres = db::select("CALL get_enckey();");
        foreach ($keypasswordres as $row) { $keypassword = $row->key_password; }
        db::select("CALL drop_enckey();");

        $encaccountusername = trim($_POST['accountusername']);
        $encpostidsonfeed = trim($_POST['postidsonfeed']);
    	$cryptor = new Decryptor;
        
        $postidsonfeed = $cryptor->decrypt($encpostidsonfeed, $keypassword);

        $feedcontent = \DB::SELECT("select rfc_commentid,rfc_commentbody, rfc_commentcreator, DATE_FORMAT(rfc_dateadded,'%M %d, %Y') rfc_dateadded, rac_username, rac_profilepicture from r_feeds_comments inner join r_account_credentials on r_account_credentials.rac_accountid = rfc_commentcreator where rfc_feedparent = (select tafd_postid from t_account_feeds where tafd_postid = ?) order by rfc_dateadded asc",[$postidsonfeed]);

    	$output = json_encode(array('feedComments' => $feedcontent));
		if($output == "") {
            echo "";
        }else {
            echo $output;    
        } 
    }

    public function getPostwithComments() 
    {
        db::select("CALL insert_enckey();");
        $keypasswordres = db::select("CALL get_enckey();");
        foreach ($keypasswordres as $row) { $keypassword = $row->key_password; }
        db::select("CALL drop_enckey();");
        $encpostidsonfeed = trim($_POST['postidsonfeed']);
        $encaccountusername = trim($_POST['accountusername']);

        $cryptor = new Decryptor;
        $postidsonfeed = $cryptor->decrypt($encpostidsonfeed, $keypassword);
        $accountusername = $cryptor->decrypt($encaccountusername, $keypassword);

    	$feedcontent = \DB::SELECT("select rac_username, rac_profilepicture, tafd_postid, tafd_postcontent, tafd_postimage_source, DATE_FORMAT(tafd_postadded,'%M %d, %Y') tafd_postadded,tafd_imotion, (select count(rpg_actormakeget) from r_post_getyou where rpg_postrelate = tafd_postid and rpg_isremoved = 0) as tafd_igetyoucount, (select count(rpg_postrelate) from r_post_getyou where rpg_postrelate = tafd_postid and rpg_actormakeget = (select rac_accountid from r_account_credentials where rac_username = ? )) as isliked, (select count(rfc_commentid) from r_feeds_comments where rfc_feedparent = tafd_postid) rfc_commentcount,(select rac_username from r_account_credentials where rac_accountid = (select rfc_commentcreator from r_feeds_comments where rfc_feedparent = tafd_postid limit 1)) commentcreator, (select rfc_commentbody from r_feeds_comments where rfc_feedparent = tafd_postid limit 1) commentbody,(select DATE_FORMAT(rfc_dateadded,'%M %d, %Y') from r_feeds_comments where rfc_feedparent = tafd_postid limit 1) commendate from t_account_feeds inner join r_account_credentials on r_account_credentials.rac_accountid = t_account_feeds.tafd_postcreator where tafd_postid = ? order by tafd_postadded", [$accountusername, $postidsonfeed]);

    	$output = json_encode(array('feedComments' => $feedcontent));
		if($output == "") {
            echo "";
        }else {
            echo $output;    
        }
    }
}
