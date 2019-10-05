<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cryptor;
use App\Decryptor;
use App\Encryptor;

class MobileGetCommentController extends Controller
{
    public function getCommentator()
    {
        db::select("CALL insert_enckey();");
        $keypasswordres = db::select("CALL get_enckey();");
        foreach ($keypasswordres as $row) { $keypassword = $row->key_password; }
        db::select("CALL drop_enckey();");
        
        $encpostid = trim($_POST['postid']);
        $cryptor = new Decryptor;

        $postid = $cryptor->decrypt($encpostid, $keypassword);

    	$feedcontent = \DB::SELECT("select rfc_commentcreator, rfc_feedparent, rfc_dateadded,rfc_deleted, r_account_credentials.rac_username from r_feeds_comments INNER join r_account_credentials on r_account_credentials.rac_accountid = r_feeds_comments.rfc_commentcreator where rfc_feedparent = '$postid' and rfc_deleted !=1  order by rfc_dateadded desc");

    	$output = json_encode(array('comments' => $feedcontent ));
		
		if($output == "") {
            echo "";
        }else {
            echo $output;    
        }
    }

    public function getCommentBody()
    {
        db::select("CALL insert_enckey();");
        $keypasswordres = db::select("CALL get_enckey();");
        foreach ($keypasswordres as $row) { $keypassword = $row->key_password; }
        db::select("CALL drop_enckey();");
        
        $encpostid = trim($_POST['postid']);
        $cryptor = new Decryptor;

        $postid = $cryptor->decrypt($encpostid, $keypassword);
    	$feedcontent = \DB::SELECT("select rfc_commentbody, rfc_dateadded, rac_username, rac_profilepicture from r_feeds_comments inner join r_account_credentials on r_account_credentials.rac_accountid = rfc_commentcreator where rfc_feedparent = (select tafd_postid from t_account_feeds where tafd_postid = ?)", [$postid]);

    	$output = json_encode(array('comments' => $feedcontent ));
		if($output == "") {
            echo "";
        }else {
            echo $output;    
        }
    }	

    public function getTopComments()
    {
        db::select("CALL insert_enckey();");
        $keypasswordres = db::select("CALL get_enckey();");
        foreach ($keypasswordres as $row) { $keypassword = $row->key_password; }
        db::select("CALL drop_enckey();");
        
        $encpostid = trim($_POST['postid']);
        $cryptor = new Decryptor;

        $postid = $cryptor->decrypt($encpostid, $keypassword);
        $feedComments = \DB::SELECT("select rfc_commentid,rfc_commentbody, rfc_commentcreator, DATE_FORMAT(rfc_dateadded,'%M %d, %Y') rfc_dateadded, rac_username, rac_profilepicture from r_feeds_comments inner join r_account_credentials on r_account_credentials.rac_accountid = rfc_commentcreator where rfc_feedparent = (select tafd_postid from t_account_feeds where tafd_postid = ?) order by rfc_dateadded desc",[$postid]);

        $comments = json_encode(array('feedComments' => $feedComments ));
       if($output == "") {
            echo "";
        } else {
            echo $output;    
        }
    }

}
