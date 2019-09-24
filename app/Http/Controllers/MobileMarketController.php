<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MobileMarketController extends Controller
{
    public function getFlashSales()
    {
    	$feedcontent = \DB::SELECT("select rmf_itemtosale, rmf_saleimagesource from r_market_flashsales");

    	$output = json_encode(array('marketsales' => $feedcontent ));
		//$jsonData = json_encode($app);
		echo $output;

    }

    public function getItemCategories()
    {
    	$feedcontent = \DB::SELECT("SELECT parent.PRODT_TITLE category
			,SUM(((SELECT IFNULL(SUM(INV.INV_QTY),0) FROM r_inventory_infos INV WHERE (INV.INV_TYPE='CAPITAL' OR INV.INV_TYPE='ADD') AND INV.PROD_ID=PROD.PROD_ID)
			+(SELECT -IFNULL(SUM(INV.INV_QTY),0) FROM r_inventory_infos INV WHERE INV.INV_TYPE='DISPOSE' AND INV.PROD_ID=PROD.PROD_ID)
			+(SELECT -IFNULL(SUM(INV.INV_QTY),0) FROM r_inventory_infos INV WHERE INV.INV_TYPE='ORDER' AND INV.PROD_ID=PROD.PROD_ID)
			+(SELECT IFNULL(SUM(PRODV.PRODV_INIT_QTY),0) FROM t_product_variances PRODV WHERE PRODV.PROD_ID = PROD.PROD_ID)
			+(SELECT IFNULL(SUM(PROD_INIT_QTY),0) FROM r_product_infos t_infos WHERE PROD_ID = PROD.PROD_ID))) quantity
			,parent.PRODT_ICON categoryimage
			FROM r_product_types parent
			INNER JOIN r_product_types child ON parent.PRODT_ID = child.PRODT_PARENT
			INNER JOIN r_product_infos PROD ON child.PRODT_ID = PROD.PRODT_ID
			GROUP BY parent.PRODT_TITLE,parent.PRODT_ICON");

    	$output = json_encode(array('feedcontent' => $feedcontent ));
		//$jsonData = json_encode($app);
		echo $output;
    }

    public function getItemsonMarket()
    {
    	$feedcontent = \DB::SELECT("select rmd_itemname, r_marketitem_types.rmt_itemtypename, rmd_itemid, rmd_itemdesc, rmd_itemimage, r_affiliates_details.rad_affiliatename, rmd_baseprice+rmd_topup  as 'final price' from r_marketitems_details inner join r_affiliates_details on r_marketitems_details.rmd_affiliateid = r_affiliates_details.rad_affiliateid inner join r_marketitem_types on r_marketitem_types.rmt_itemtypeid = r_marketitems_details.rmd_itemtype where rmd_isbought = 0 and rmd_itemtype = 1");

    	$output = json_encode(array('feedcontent' => $feedcontent ));
		//$jsonData = json_encode($app);
		echo $output;
    }

    public function getItemsonMarketCart()
    {
    	$feedcontent = \DB::SELECT("select rmd_itemname, r_marketitem_types.rmt_itemtypename, rmd_itemid, rmd_itemdesc, rmd_itemimage, r_affiliates_details.rad_affiliatename, rmd_baseprice+rmd_topup  as 'final price' from r_marketitems_details inner join r_affiliates_details on r_marketitems_details.rmd_affiliateid = r_affiliates_details.rad_affiliateid inner join r_marketitem_types on r_marketitem_types.rmt_itemtypeid = r_marketitems_details.rmd_itemtype where rmd_isbought = 0 and rmd_itemtype = 1");

    	$output = json_encode(array('feedcontent' => $feedcontent ));
		//$jsonData = json_encode($app);
		echo $output;
    }

    public function getItemsonMarketChocolate()
    {
    	$feedcontent = \DB::SELECT("SELECT PROD_IMG rmd_itemimage,PROD_DESC rmd_itemdesc, PROD_MY_PRICE  final_price, PROD_NAME rmd_itemname FROM `r_product_infos` where PRODT_ID in (SELECT PRODT_ID FROM `sympies`.`r_product_types` WHERE PRODT_TITLE LIKE '%Chocolates%')");

    	$output = json_encode(array('feedcontent' => $feedcontent ));
		//$jsonData = json_encode($app);
		echo $output;
    }

    public function getItemsonMarketFlower()
    {
    	$feedcontent = \DB::SELECT("SELECT PROD_IMG rmd_itemimage,PROD_DESC rmd_itemdesc, PROD_MY_PRICE  final_price, PROD_NAME rmd_itemname FROM `r_product_infos` where PRODT_ID in (SELECT PRODT_ID FROM `r_product_types` WHERE PRODT_TITLE LIKE '%Flowers%' )");

    	$output = json_encode(array('feedcontent' => $feedcontent ));
		//$jsonData = json_encode($app);
		echo $output;
    }

    public function getItemsonMarketStuffToys()
    {
    	$feedcontent = \DB::SELECT("select rmd_itemname, r_marketitem_types.rmt_itemtypename, rmd_itemid, rmd_itemdesc, rmd_itemimage, r_affiliates_details.rad_affiliatename, rmd_baseprice+rmd_topup  as 'final price' from r_marketitems_details inner join r_affiliates_details on r_marketitems_details.rmd_affiliateid = r_affiliates_details.rad_affiliateid inner join r_marketitem_types on r_marketitem_types.rmt_itemtypeid = r_marketitems_details.rmd_itemtype where rmd_isbought = 0 and rmd_itemtype = 1");

    	$output = json_encode(array('feedcontent' => $feedcontent ));
		//$jsonData = json_encode($app);
		echo $output;
    }

    public function getProductDetails()
    {
        //$prod_name = $_GET['PROD_NAME'];
        $feedcontent = \DB::SELECT("SELECT PROD_NOTE rmd_itemdesc, PROD_MY_PRICE itemprice FROM r_product_infos where PROD_NAME = ?", ['Pure White']);

        $output = json_encode(array('proddetails' => $feedcontent ));
        echo $output;
    }

    public function getTopGiftedPerson()
    {
        $gitftedperson = \DB::SELECT("select count(tct_recieverid) id , tct_recieverid, r_account_credentials.rac_username username, r_account_credentials.rac_profilepicture userpic from t_cart_transact INNER JOIN r_account_credentials ON r_account_credentials.rac_accountid = t_cart_transact.tct_recieverid where t_cart_transact.tct_userid = (select rac_accountid from r_account_credentials where rac_username = ?) GROUP by tct_recieverid limit 3", ['playhouse']);

        $output = json_encode(array('gitftedperson' => $giftedperson));
        echo $output;
    }

    public function gettopitemsonmarket()
    {
        $topitems = \DB::SELECT("select PROD_NAME itemname, PROD_MY_PRICE itemprice ,PROD_IMG  itemimage from r_product_infos limit 3");
        $output = json_encode(array('topitems' => $topitems));
        echo $output;

    }

    public function getTopItemsUserProvide()
    {
        $feedcontent = \DB::SELECT("select r_marketitems_details.rmd_itemname,r_marketitems_details.rmd_itemimage, count(t_cart_transact.tct_iteminclude) from t_cart_transact inner join r_marketitems_details on t_cart_transact.tct_iteminclude = r_marketitems_details.rmd_itemid WHERE t_cart_transact.tct_userid = (select r_account_credentials.rac_accountid from r_account_credentials where r_account_credentials.rac_username = ?) GROUP by r_marketitems_details.rmd_itemname limit 1",['playhouse']);
        $output = json_encode(array('userdetails' => $feedcontent));
        echo $output;
    }

    public function getUserDetailsinMarket()
    {
        $feedcontent = \DB::SELECT("select count(t_account_friends.tafr_friendlyuserid) as totfriend,r_account_credentials.rac_email, r_account_credentials.rac_profilepicture from r_account_credentials INNER join t_account_friends on t_account_friends.tafr_friendlyuserid = r_account_credentials.rac_accountid where r_account_credentials.rac_username = ?",['playhouse']);

        $output = json_encode(array('userdetails' => $feedcontent ));
        echo $output;
    }
}
