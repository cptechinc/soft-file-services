<?php 
	/**
	 * Class for Dealing with Sales Orders History from saleshist
	 */
	class SalesOrderHistory extends SalesOrder {
		
		/**
		 * Mainly called by the _toArray() function which makes an array
		 * based of the properties of the class, but this function filters the array
		 * to remove keys that are not in the database
		 * This is used by database classes for update
		 * @param  array $array array of the class properties
		 * @return array        with certain keys removed
		 */
		public static function remove_nondbkeys($array) {
			unset($array['type']); 
			unset($array['careof']); 
			unset($array['shipdate']); 
			unset($array['revdate']); 
			unset($array['expdate']); 
			unset($array['editord']); 
			unset($array['sconame']); 
			unset($array['phintl']); 
			unset($array['extension']); 
			unset($array['releasenbr']); 
			unset($array['pricedisp']); 
			unset($array['taxcodedisp']); 
			unset($array['termtype']); 
			unset($array['rqstdate']); 
			unset($array['shipcom']); 
			unset($array['fob']); 
			unset($array['deliverydesc']); 
			unset($array['cardnumber']); 
			unset($array['cardexpire']); 
			unset($array['cardcode']); 
			unset($array['cardapproval']); 
			unset($array['totalcost']); 
			unset($array['totaldiscount']); 
			unset($array['paymenttype']); 
			unset($array['srcdatefrom']); 
			unset($array['srcdatethru']); 
			unset($array['prntfmt']); 
			unset($array['prntfmtdisp']); 
			unset($array['dateoforder']); 
			unset($array['sessionid']); 
			unset($array['recno']); 
			unset($array['quotdate']); 
			unset($array['billname']); 
			unset($array['billaddress']); 
			unset($array['billaddress2']); 
			unset($array['billaddress3']); 
			unset($array['billcountry']); 
			unset($array['billcity']); 
			unset($array['billstate']); 
			unset($array['billzip']); 
			unset($array['shipname']); 
			unset($array['shipaddress']); 
			unset($array['shipaddress2']); 
			unset($array['shipaddress3']); 
			unset($array['shipcountry']); 
			unset($array['shipcity']); 
			unset($array['shipstate']); 
			unset($array['shipzip']); 
			unset($array['contact']);  
			unset($array['sp1name']); 
			unset($array['sp2']); 
			unset($array['sp2name']); 
			unset($array['sp2disp']); 
			unset($array['sp3']); 
			unset($array['sp3name']); 
			unset($array['sp3disp']); 
			unset($array['shipviacd']); 
			unset($array['shipviadesc']); 
			unset($array['custpo']); 
			unset($array['custref']); 
			unset($array['status']); 
			unset($array['phone']); 
			unset($array['faxnbr']); 
			unset($array['email']); 
			unset($array['whse']); 
			unset($array['taxcode']); 
			unset($array['taxcodedesc']); 
			unset($array['termcode']); 
			unset($array['termcodedesc']); 
			unset($array['pricecode']); 
			unset($array['pricecodedesc']); 
			unset($array['error']); 
			unset($array['errormsg']); 
			return $array;
		}
		
		/* =============================================================
			CRUD FUNCTIONS
		============================================================ */
		public static function is_saleshistory($ordn, $debug = false) {
			return is_ordersaleshistory($ordn, $debug);
		}
		
		public static function find_custid($ordn = '', $debug = false) {
			return get_custidfromsaleshistory($ordn, $debug);
		}
	}
