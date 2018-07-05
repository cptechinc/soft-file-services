<?php
	/**
	 * Class for dealing with Quotes from quotehed
	 */
	class Quote extends Order {
		protected $quotnbr;
		protected $careof;
		protected $revdate;
		protected $expdate;
		protected $sp1pct;
		protected $sp2pct;
		protected $sp3pct;
		protected $fob;
		protected $deliverydesc;
		protected $cost_total;
		protected $margin_amt;
		protected $margin_pct;

		//FOR SQL
		protected $quotedate;
		protected $reviewdate;
		protected $expiredate;

		/* =============================================================
			GETTER FUNCTIONS
		============================================================ */
		/**
		 * Returns if Quote has Documents
		 * @return bool
		 */
		public function has_documents() {
			//return $this->hasdocuments == 'Y' ? true : false;
			return false;
		}

		public function has_notes() {
			return $this->hasnotes == 'Y' ? true : count_qnotes($this->sessionid, $this->quotnbr, '0', Qnote::get_qnotetype('quote'));
		}

		/**
		 * Returns if Quote is Editable
		 * @return bool Based on Config
		 */
		public function can_edit() {
			$quoteconfig = DplusWire::wire('pages')->get('/config/')->child('name=quotes');
			return $quoteconfig->allow_edit;
		}

		// public function is_phoneintl() {
		// 	return $this->phintl == 'Y' ? true : false;
		// }

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
		 * Returns Quote using the Session ID and Quote
		 * @param  string $sessionID Session ID
		 * @param  string $qnbr      Quote #
		 * @return Quote             Or SQL Query
		 */
		public static function load($sessionID, $qnbr) {
			return get_quotehead($sessionID, $qnbr, true, false);
		}

		/**
		 * Updates the Quote in the Database
		 * @param  bool $debug Whether or Query is Executed
		 * @return string         SQL Query
		 */
		public function update($debug = false) {
			return edit_quotehead($this->sessionid, $this->quotnbr, $this, $debug);
		}

		/**
		 * Checks if changes have been made by
		 * comparing it to the original Quote
		 * @return bool
		 */
		public function has_changes() {
			$properties = array_keys(get_object_vars($this));
			$quote = Quote::load($this->sessionid, $this->quotnbr);

			foreach ($properties as $property) {
				if ($this->$property != $quote->$property) {
					return true;
				}
			}
			return false;
		}
	}
