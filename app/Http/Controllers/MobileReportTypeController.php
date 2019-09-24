<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MobileReportTypeController extends Controller
{
    public function getReportTypes()
    {
    	$feedComments = \DB::SELECT("select rrt_reporttypeid, rrt_reportvalue, rrt_reporticon from r_report_types");

    	$comments = json_encode(array('reportTypes' => $feedComments));
    	echo $comments;
    }
}
