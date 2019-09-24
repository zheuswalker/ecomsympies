<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
    	
        '/mobilelogin',
		'/mobilefindcircles',
		'/mobilefindfollowers',
		'/mobilefindfollowersmycircle',
		'/mobilefindfollowing',
		'/mobilefindgetyou',
		'/mobilegetfriendrequest',
		'/mobilegetcommentator',
		'/mobilegetcommentbody',
		'/mobilegettopcomments',
		'/mobilegetfeed',
		'/mobilegetmessageslist',
		'/mobilegetmessages',
		'/mobilegetnotifications',
		'/mobilegetotherprofile',
		'/mobilelivenotification',
		'/mobilegetgetprofiledetails',
		'/mobilegetpostwithcomments',
		'/mobilegetflashsales',
		'/mobilegetitemcategories',
		'/mobilegetitemsonmarket',
		'/mobilegetitemsonmarketcart',
		'/mobilegetitemsonmarketchocolate',
		'/mobilegetitemsonmarketflower',
		'/mobilegetitemsonmarketstufftoys',
		'/mobilegetproductdetails',
		'/mobilegettopgiftedperson',
		'/mobilegettopitems',
		'/mobilegettopitemsuserprovide',
		'/mobilegetuserdetailsinmarket',
		'/mobilegetreporttypes'

    ];
}
