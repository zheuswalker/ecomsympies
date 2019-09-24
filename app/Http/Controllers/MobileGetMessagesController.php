<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class MobileGetMessagesController extends Controller
{
    public function getMessageList()
    {
        
    	$feedcontent = COLLECT(\DB::SELECT("select tcr_chatroomid,(select tcrm_messagecontent from t_chat_rooms_messages where tcrm_messageid = (select max(tcrm_messageid) from t_chat_rooms_messages where tcrm_chatroomid = tcr_chatroomid)) lastmessage,(select rac_username from r_account_credentials where rac_accountid = (select tcrm_messenger from t_chat_rooms_messages where tcrm_messageid = (select max(tcrm_messageid) from t_chat_rooms_messages where tcrm_chatroomid = tcr_chatroomid))) lastsender, DATE_FORMAT((select tcrm_messagetimestamp from t_chat_rooms_messages where tcrm_messageid = (select max(tcrm_messageid) from t_chat_rooms_messages where tcrm_chatroomid = tcr_chatroomid)),'%M %d, %Y')  messagedate,(select rac_username from r_account_credentials where rac_accountid = tcr_creator) roomcreator,(select rac_profilepicture from r_account_credentials where rac_accountid = tcr_creator) creatorprofpic , (select rac_username from r_account_credentials where rac_accountid = tcr_pairtowho) pairedtowho, (select rac_profilepicture from r_account_credentials where rac_accountid = tcr_pairtowho) pairedprofpic  from t_chat_rooms where tcr_creator = (select rac_accountid from r_account_credentials where rac_username = 'playhouse')  or tcr_pairtowho = (select rac_accountid from r_account_credentials where rac_username = 'playhouse')"));

    	$output = json_encode(array('messagelist' => $feedcontent ));
		//$jsonData = json_encode($app);
		echo $output;
    }

    public function getMessages()
    {
    	$feedcontent = COLLECT(\DB::SELECT("select tcrm_messagecontent messagecontent, rac_profilepicture senderprofilepic, rac_username sendername, (select rac_username from r_account_credentials where rac_accountid = tcrm_reciver) recievername, (select rac_profilepicture from r_account_credentials where rac_accountid = tcrm_reciver) recieverprofilepic, DATE_FORMAT(tcrm_messagetimestamp,'%M %d, %Y') recievedate from t_chat_rooms_messages inner join r_account_credentials on r_account_credentials.rac_accountid = t_chat_rooms_messages.tcrm_messenger where tcrm_chatroomid=(select tcr_chatroomid from t_chat_rooms where tcr_creator = (select rac_accountid from r_account_credentials where rac_username = 'playhouse') and tcr_pairtowho in (select rac_accountid from r_account_credentials where rac_username = 'chaella') or tcr_creator = (select rac_accountid from r_account_credentials where rac_username = 'chaella') and tcr_pairtowho in (select rac_accountid from r_account_credentials where rac_username = 'playhouse')) order by tcrm_messagetimestamp"));

    	$output = json_encode(array('messagecontent' => $feedcontent	));
		echo $output;
    }

}
