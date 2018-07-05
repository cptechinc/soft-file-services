<?php 
	/**
	 * Class to Set up and define what Quotes, CartQuote, and Sales Orders Need to do and provide them
	 * with shared functions and properties that they can extend
	 */
	abstract class Order {
		use ThrowErrorTrait;
		use MagicMethodTraits;
		use CreateFromObjectArrayTraits;
		use CreateClassArrayTraits;
		
		protected $sessionid;
		protected $recno;
		protected $date;
		protected $time;
		protected $custid;
		protected $shiptoid;
		protected $quotdate;
		protected $billname;
		protected $billaddress;
		protected $billaddress2;
		protected $billaddress3;
		protected $billcountry;
		protected $billcity;
		protected $billstate;
		protected $billzip;
		protected $shipname;
		protected $shipaddress;
		protected $shipaddress2;
		protected $shipaddress3;
		protected $shipcountry;
		protected $shipcity;
		protected $shipstate;
		protected $shipzip;
		protected $contact; 
		protected $sp1;
		protected $sp1name;
		protected $sp2;
		protected $sp2name;
		protected $sp2disp;
		protected $sp3;
		protected $sp3name;
		protected $sp3disp;
		protected $hasnotes;
		protected $shipviacd;
		protected $shipviadesc;
		protected $custpo;
		protected $custref;
		protected $status;
		protected $phone;
		protected $faxnbr;
		protected $email;
		protected $subtotal;
		protected $salestax;
		protected $freight;
		protected $misccost;
		protected $ordertotal;
		protected $whse;
		protected $taxcode;
		protected $taxcodedesc;
		protected $termcode;
		protected $termcodedesc; 
		protected $pricecode;
		protected $pricecodedesc;
		protected $error;
		protected $errormsg;
		protected $dummy;
		
		/* =============================================================
			GETTER FUNCTIONS
		============================================================ */
		/**
		 * Returns if Order has notes attached
		 * @return bool Y = true | N = false
		 */
		public function has_notes() {
			return $this->hasnotes == 'Y' ? true : false;
		}
		
		/**
		 * Returns if Order has error
		 * @return bool Y = true | N = false
		 */
		public function has_error() {
			return $this->error == 'Y' ? true : false;
		}
		
		/**
		 * Returns if Order has shiptoid defined
		 * @return bool 
		 */
		public function has_shipto() {
			return (!empty($this->shiptoid));
		}
		
		/* =============================================================
			SETTER FUNCTIONS
			MagicMethodTraits has set()
		============================================================ */
	}
