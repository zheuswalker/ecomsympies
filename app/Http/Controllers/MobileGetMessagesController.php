<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cryptor;
use App\Decryptor;
use App\Encryptor;


class MobileGetMessagesController extends Controller
{
    public function getMessageList()
    {
        db::select("CALL insert_enckey();");
        $keypasswordres = db::select("CALL get_enckey();");
        foreach ($keypasswordres as $row) { $keypassword = $row->key_password; }
        db::select("CALL drop_enckey();");

        $encusername = trim($_POST['username']);
        $cryptor = new Decryptor;
        $username = $cryptor->decrypt($encusername, $keypassword);

    	$feedcontent = COLLECT(\DB::SELECT("select tcr_chatroomid,(select tcrm_messagecontent from t_chat_rooms_messages where tcrm_messageid = (select max(tcrm_messageid) from t_chat_rooms_messages where tcrm_chatroomid = tcr_chatroomid)) lastmessage,(select rac_username from r_account_credentials where rac_accountid = (select tcrm_messenger from t_chat_rooms_messages where tcrm_messageid = (select max(tcrm_messageid) from t_chat_rooms_messages where tcrm_chatroomid = tcr_chatroomid))) lastsender, DATE_FORMAT((select tcrm_messagetimestamp from t_chat_rooms_messages where tcrm_messageid = (select max(tcrm_messageid) from t_chat_rooms_messages where tcrm_chatroomid = tcr_chatroomid)),'%M %d, %Y')  messagedate,(select rac_username from r_account_credentials where rac_accountid = tcr_creator) roomcreator,(select rac_profilepicture from r_account_credentials where rac_accountid = tcr_creator) creatorprofpic , (select rac_username from r_account_credentials where rac_accountid = tcr_pairtowho) pairedtowho, (select rac_profilepicture from r_account_credentials where rac_accountid = tcr_pairtowho) pairedprofpic  from t_chat_rooms where tcr_creator = (select rac_accountid from r_account_credentials where rac_username = ?)  or tcr_pairtowho = (select rac_accountid from r_account_credentials where rac_username = ?)",[$username,$username]));

    	$output = json_encode(array('messagelist' => $feedcontent ));
		if($output == "") {
            echo "";
        }else {
            echo $output;    
        }
    }

    public function getMessages()
    {
        db::select("CALL insert_enckey();");
        $keypasswordres = db::select("CALL get_enckey();");
        foreach ($keypasswordres as $row) { $keypassword = $row->key_password; }
        db::select("CALL drop_enckey();");
        
        $encrecievername = trim($_POST['recievername']);
        $encsendername = trim($_POST['sendername']);

        $cryptor = new Decryptor;
        $recievername = $cryptor->decrypt($encrecievername, $keypassword);
        $sendername = $cryptor->decrypt($encsendername, $keypassword);

    	$feedcontent = COLLECT(\DB::SELECT("select tcrm_messagecontent messagecontent, rac_profilepicture senderprofilepic, rac_username sendername, (select rac_username from r_account_credentials where rac_accountid = tcrm_reciver) recievername, (select rac_profilepicture from r_account_credentials where rac_accountid = tcrm_reciver) recieverprofilepic, DATE_FORMAT(tcrm_messagetimestamp,'%M %d, %Y') recievedate from t_chat_rooms_messages inner join r_account_credentials on r_account_credentials.rac_accountid = t_chat_rooms_messages.tcrm_messenger where tcrm_chatroomid=(select tcr_chatroomid from t_chat_rooms where tcr_creator = (select rac_accountid from r_account_credentials where rac_username = ?) and tcr_pairtowho in (select rac_accountid from r_account_credentials where rac_username = ?) or tcr_creator = (select rac_accountid from r_account_credentials where rac_username = ?) and tcr_pairtowho in (select rac_accountid from r_account_credentials where rac_username = '$username')) order by tcrm_messagetimestamp",[$recievername,$recievername,$sendername]));

    	$output = json_encode(array('messagecontent' => $feedcontent	));
		if($output == "") {
            echo "";
        }else {
            echo $output;    
        }
    }

}
