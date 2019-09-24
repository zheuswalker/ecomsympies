<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MobileGetCommentController extends Controller
{
    public function getCommentator()
    {
    	$feedcontent = \DB::SELECT("select rfc_commentcreator, rfc_feedparent, rfc_dateadded,rfc_deleted, r_account_credentials.rac_username from r_feeds_comments INNER join r_account_credentials on r_account_credentials.rac_accountid = r_feeds_comments.rfc_commentcreator where rfc_feedparent = '1' and rfc_deleted !=1  order by rfc_dateadded desc");

    	$output = json_encode(array('comments' => $feedcontent ));
		//$jsonData = json_encode($app);
		echo $output;
    }

    public function getCommentBody()
    {
    	$feedcontent = \DB::SELECT("select rfc_commentbody, rfc_dateadded, rac_username, rac_profilepicture from r_feeds_comments inner join r_account_credentials on r_account_credentials.rac_accountid = rfc_commentcreator where rfc_feedparent = (select tafd_postid from t_account_feeds where tafd_postid = 1)");

    	$output = json_encode(array('comments' => $feedcontent ));
		//$jsonData = json_encode($app);
		echo $output;
    }	

    public function getTopComments()
    {
        $feedComments = \DB::SELECT("select rfc_commentid,rfc_commentbody, rfc_commentcreator, DATE_FORMAT(rfc_dateadded,'%M %d, %Y') rfc_dateadded, rac_username, rac_profilepicture from r_feeds_comments inner join r_account_credentials on r_account_credentials.rac_accountid = rfc_commentcreator where rfc_feedparent = (select tafd_postid from t_account_feeds where tafd_postid = ?) order by rfc_dateadded desc",[1]);

        $comments = json_encode(array('feedComments' => $feedComments ));
        //$jsonData = json_encode($app);
        echo $comments;
    }

}
