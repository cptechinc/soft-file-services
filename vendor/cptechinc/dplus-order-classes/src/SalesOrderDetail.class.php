<?php
	/**
	 * Class for dealing with Sales Order Details from ordrdet
	 */
	class SalesOrderDetail extends OrderDetail {
		protected $type;
		protected $orderno;
		protected $price;
		protected $qty;
		protected $qtyshipped;
		protected $qtybackord;
		protected $hasdocuments;
		protected $qtyavail;
		protected $cost;
		protected $promocode;
		protected $taxcodeperc;
		protected $uomconv;
		protected $mfgid;
		protected $mfgitemid;
		protected $leaddays;
		protected $costuom;
		protected $quotind;
		protected $quotqty;
		protected $quotprice;
		protected $quotcost;
		protected $quotmkupmarg;
		protected $quotdiscpct;
		protected $ponbr;
		protected $poref;
		protected $notes; // this needs to be removed from the MySQL tables
		protected $canbackorder;

		/* =============================================================
			GETTER FUNCTIONS
		============================================================ */
		public function has_error() {
			return !empty($this->errormsg);
		}

		public function has_documents() {
			return $this->hasdocuments == 'Y' ? true : false;
		}

		/**
		 * Returns if SalesOrderDetail is editable
		 * @return bool
		 * @uses SalesOrder
		 */
		public function can_edit() {
			$order = SalesOrder::load($this->sessionid, $this->orderno);
			return $order->can_edit();
		}

		/**
		 * Checks if canbackorder is 'Y' from ordrdet and returns true
		 * @return bool
		 */
		public function can_backorder() {
			return $this->canbackorder == 'Y' ? true : false;
		}

		/**
		 * Returns canbackorder from ordrdet
		 * @return string
		 */
		public function display_canbackorder() {
			return $this->canbackorder;
		}

		/**
		 * Return the number of cases
		 * @return int The number of cases
		 */
		public function get_caseqtyshipped() {
			$item = XRefItem::load($this->itemid);
			return ($item->has_caseqty()) ? floor($this->qtyshipped) : 0;
		}

		/**
		 * Return the Number of Bottles
		 * @param  bool   $subtractcases Exclude cases?
		 * @return int                   Bottle Count
		 */
		public function get_bottleqtyshipped($subtractcases = true) {
			$item = XRefItem::load($this->itemid);

			if ($item->has_caseqty()) {
				$cases = $this->get_caseqtyshipped();
				$fraction = $subtractcases ? $this->qtyshipped - $cases : $this->qtyshipped;
				return round($fraction * $item->qty_percase);
			} else {
				return $this->qtyshipped;
			}
		}

		/**
		 * Returns the number of bottles that the cases contain
		 * @return int Number of bottles in the cases
		 */
		public function get_casebottleqtyshipped() {
			$item = XRefItem::load($this->itemid);
			$cases = $this->get_caseqty();
			return intval($cases * $item->qty_percase);
		}

		/* =============================================================
			GENERATE ARRAY FUNCTIONS
			The following are defined CreateClassArrayTraits
			public static function generate_classarray()
			public function _toArray()
		============================================================ */
		/**
		 * Mainly called by the _toArray() function which makes an array
		 * based of the properties of the class, but this function filters the array
		 * to remove keys that are not in the database
		 * This is used by database classes for update
		 * @param  array $array array of the class properties
		 * @return array        with certain keys removed
		 */
		public static function remove_nondbkeys($array) {
			return $array;
		}

		/* =============================================================
			CRUD FUNCTIONS
		============================================================ */
		/**
		 * Returns SalesOrderDetail from ordrdet
		 * @param  string $sessionID Session ID
		 * @param  string $ordn      Sales Order #
		 * @param  int    $linenbr   Line #
		 * @param  bool   $debug     Wheter or not to return SalesOrderDetail or
		 * @return SalesOrderDetail [description]
		 * @uses Read (CRUD)
		 * @source _dbfunc.php
		 */
		public static function load($sessionID, $ordn, $linenbr, $debug = false) {
			return get_orderdetail($sessionID, $ordn, $linenbr, $debug);
		}

		/**
		 * Updates SalesOrderDetail in orderdet
		 * @param  bool   $debug Whether or not SQL is Executed
		 * @return string        SQL QUERY
		 * @uses Update (CRUD)
		 * @source _dbfunc.php
		 */
		public function update($debug = false) {
			return update_orderdetail($this->sessionid, $this, $debug);
		}

		/**
		 * Checks if changes have been made by comparing it to original SalesOrderDetail
		 * @return bool If changes have been made
		 * @uses SalesOrderDetail::load()
		 */
		public function has_changes() {
			$properties = array_keys(get_object_vars($this));
			$detail = self::load($this->sessionid, $this->orderno, $this->linenbr);
			foreach ($properties as $property) {
				if ($this->$property != $detail->$property) {
					return true;
				}
			}
			return false;
		}
	}
