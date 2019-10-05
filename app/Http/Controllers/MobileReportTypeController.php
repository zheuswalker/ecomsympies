<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cryptor;
use App\Decryptor;
use App\Encryptor;


class MobileReportTypeController extends Controller
{
    public function getReportTypes()
    {
    	$feedComments = \DB::SELECT("select rrt_reporttypeid, rrt_reportvalue, rrt_reporticon from r_report_types");

    	$comments = json_encode(array('reportTypes' => $feedComments));
    	if($comments == "") {
            echo "";
        }else {
            echo $comments;    
        }
    }
}
