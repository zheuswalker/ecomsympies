<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MobileGetFeedController extends Controller
{
    public function getfeed()
    {
    	$feedcontent = \DB::SELECT("select rac_username,rac_fullname, rac_profilepicture, tafd_postid, tafd_postcontent, tafd_postimage_source, tafd_mediatype, DATE_FORMAT(tafd_postadded,'%M %d, %Y') tafd_postadded,tafd_imotion,(select rid_imotionname from r_imotions_details where rid_imotionimagepath = tafd_imotion) feeling, (select count(rpg_actormakeget) from r_post_getyou where rpg_postrelate = tafd_postid and rpg_isremoved = 0) as tafd_igetyoucount, (select count(rpg_postrelate) from r_post_getyou where rpg_postrelate = tafd_postid and rpg_actormakeget = (select rac_accountid from r_account_credentials where rac_username = 'playhouse' )) as isliked, (select count(rfc_commentid) from r_feeds_comments where rfc_feedparent = tafd_postid) rfc_commentcount,(select rac_username from r_account_credentials where rac_accountid = (select rfc_commentcreator from r_feeds_comments where rfc_feedparent = tafd_postid order by rfc_dateadded desc limit 1)) commentcreator, (select rfc_commentbody from r_feeds_comments where rfc_feedparent = tafd_postid order by rfc_dateadded desc limit 1) commentbody,(select DATE_FORMAT(rfc_dateadded,'%M %d, %Y') from r_feeds_comments where rfc_feedparent = tafd_postid order by rfc_dateadded desc limit 1) commentdate from t_account_feeds inner join r_account_credentials on r_account_credentials.rac_accountid = t_account_feeds.tafd_postcreator where rac_accountid in (select tafr_userprofileid from t_account_friends where tafr_friendlyuserid =  (select rac_accountid from r_account_credentials where rac_username = 'playhouse') ) or rac_accountid = (select rac_accountid from r_account_credentials where rac_username = 'playhouse') order by tafd_postadded asc");

    	$output = json_encode(array('feedcontent' => $feedcontent ));
		//$jsonData = json_encode($app);
		echo $output;
    }

    public function getfeedSpecuser()
    {
    	$feedcontent = \DB::SELECT("select rac_username, rac_profilepicture, tafd_postid,(select concat(substring( tafd_postcontent, 1 , 150 ),'  ...' )) tafd_postcontent, tafd_postimage_source,tafd_mediatype,  DATE_FORMAT(tafd_postadded,'%M %d, %Y') tafd_postadded,tafd_imotion,(select rid_imotionname from r_imotions_details where rid_imotionimagepath = tafd_imotion) feeling, (select count(rpg_actormakeget) from r_post_getyou where rpg_postrelate = tafd_postid and rpg_isremoved = 0) as tafd_igetyoucount, (select count(rpg_postrelate) from r_post_getyou where rpg_postrelate = tafd_postid and rpg_actormakeget = (select rac_accountid from r_account_credentials where rac_username = 'playhouse' )) as isliked, (select count(rfc_commentid) from r_feeds_comments where rfc_feedparent = tafd_postid) rfc_commentcount,(select rac_username from r_account_credentials where rac_accountid = (select rfc_commentcreator from r_feeds_comments where rfc_feedparent = tafd_postid limit 1)) commentcreator, (select rfc_commentbody from r_feeds_comments where rfc_feedparent = tafd_postid limit 1) commentbody,(select DATE_FORMAT(rfc_dateadded,'%M %d, %Y') from r_feeds_comments where rfc_feedparent = tafd_postid limit 1) commentdate from t_account_feeds inner join r_account_credentials on r_account_credentials.rac_accountid = t_account_feeds.tafd_postcreator where rac_username= 'playhouse' order by tafd_postadded desc");


    	$output = json_encode(array('feedcontent' => $feedcontent ));
		//$jsonData = json_encode($app);
		echo $output;
    }

    public function getHashTags()
    {
    	
    	$feedcontent = \DB::SELECT("select rac_username,DATE_FORMAT(tafd_postadded,'%M %d, %Y') tafd_postadded, tafd_imotion, tafd_postid, (select concat(substring( tafd_postcontent, 1 , 120 ),'...' )) as formattedsearch from t_account_feeds INNER join r_account_credentials on r_account_credentials.rac_accountid = t_account_feeds.tafd_postcreator where tafd_postcontent like ('%#WAZAP%') and locate('#',tafd_postcontent)!=0");


    	$output = json_encode(array('searchvalue' => $feedcontent ));
		//$jsonData = json_encode($app);
		echo $output;
    }

    public function getImotions()
    {
    	
    	$feedcontent = \DB::SELECT("select rid_imotionname, rid_imotionimagepath from r_imotions_details");
    	$output = json_encode(array('imotionarray' => $feedcontent ));
		//$jsonData = json_encode($app);
		echo $output;
    }

    public function getSameFeed()
    {
        $username = trim('playhouse');
        $imotion = trim('imotion_13_happy');

        $feedcontent = \DB::SELECT("select rac_username,rac_fullname, rac_profilepicture, tafd_postid, tafd_postcontent, tafd_postimage_source,tafd_mediatype, DATE_FORMAT(tafd_postadded,'%M %d, %Y') tafd_postadded,tafd_imotion,(select rid_imotionname from r_imotions_details where rid_imotionimagepath = tafd_imotion) feeling, (select count(rpg_actormakeget) from r_post_getyou where rpg_postrelate = tafd_postid and rpg_isremoved = 0) as tafd_igetyoucount, (select count(rpg_postrelate) from r_post_getyou where rpg_postrelate = tafd_postid and rpg_actormakeget = (select rac_accountid from r_account_credentials where rac_username = ? )) as isliked, (select count(rfc_commentid) from r_feeds_comments where rfc_feedparent = tafd_postid) rfc_commentcount,(select rac_username from r_account_credentials where rac_accountid = (select rfc_commentcreator from r_feeds_comments where rfc_feedparent = tafd_postid limit 1)) commentcreator, (select rfc_commentbody from r_feeds_comments where rfc_feedparent = tafd_postid limit 1) commuentbody,(select DATE_FORMAT(rfc_dateadded,'%M %d, %Y') from r_feeds_comments where rfc_feedparent = tafd_postid limit 1) commentdate from t_account_feeds inner join r_account_credentials on r_account_credentials.rac_accountid = t_account_feeds.tafd_postcreator where tafd_imotion = ? order by tafd_postadded desc",[$username, $imotion]);


        $output = json_encode(array('searchvalue' => $feedcontent ));
        //$jsonData = json_encode($app);
        echo $output;
    }

    public function mydays_feed()
    {
        $feedcontent = \DB::SELECT("select (select rmd_imageid from r_my_day where rmd_creator = rac_accountid order by rmd_postid desc limit 1) mydaythumb, rac_accountid, rac_username, rac_profilepicture, rac_fullname from t_account_friends inner join r_account_credentials on r_account_credentials.rac_accountid = t_account_friends.tafr_userprofileid where tafr_friendlyuserid = (select rac_accountid from r_account_credentials where rac_username = ?) and tafr_isfollowed = 1 and tafd_isaccepted = 1 order by case when rac_accountid = (select rac_accountid from r_account_credentials where rac_username = ?) then -1 else rac_accountid end", ['playhouse', 'playhouse']);

        $output = json_encode(array('mydaysvalue' => $feedcontent));
        echo $output;
    }


    public function mydays_viewpost()
    {
        $feedcontent = \DB::SELECT("select rmd_postid, rmd_imageid, DATE_FORMAT(rmd_postcreated,'%M %d, %Y') rmd_postcreated,rac_profilepicture, rac_username from r_my_day INNER join r_account_credentials on r_account_credentials.rac_accountid = r_my_day.rmd_creator where rac_username = ?",['playhouse']);

        $output = json_encode(array('mydaysvalue' => $feedcontent ));
        echo $output;
    }

}   
