<?php
	/**
	 * Class to Set up and define what Quote, Cart, and Sales Order Details Need to do and provide them
	 * with shared functions and properties that they can extend
	 */
	abstract class OrderDetail {
		use ThrowErrorTrait;
		use MagicMethodTraits;
		use CreateFromObjectArrayTraits;
		use CreateClassArrayTraits;

		protected $sessionid;
		protected $recno;
		protected $date;
		protected $time;
		protected $status;
		protected $linenbr;
		protected $sublinenbr;
		protected $itemid;
		protected $custid;
		protected $custitemid;
		protected $desc1;
		protected $desc2;
		protected $vendorid;
		protected $vendoritemid;
		protected $totalprice;
		protected $ordrtotalcost;
		protected $hasnotes;
		protected $whse;
		protected $errormsg;
		protected $nsitemgroup;
		protected $shipfromid;
		protected $itemtype;
		protected $minprice;
		protected $spcord;
		protected $kititemflag;
		protected $uom;
		protected $lostreason;
		protected $lostdate;
		protected $listprice;
		protected $discpct;
		protected $taxcode;
		protected $stancost;
		protected $rshipdate;
		protected $dummy;

		/* =============================================================
			GETTER FUNCTIONS
			Some functions provided by MagicMethodTraits
		============================================================ */

		/**
		 * Checks if Detail is a kit by checking if the flag is 'Y'
		 * @return bool Whether or not kit item is Y
		 */
		public function is_kititem() {
			return $this->kititemflag == 'Y' ? true : false;
		}

		/**
		 * Checks if Detail has notes by looking at the notes flag
		 * @return bool Whether or not $this->hasnotes is Y
		 */
		public function has_notes() {
			return $this->hasnotes == 'Y' ? true : false;
		}

		/**
		 * Return the number of cases
		 * @return int The number of cases
		 */
		public function get_caseqty() {
			$item = XRefItem::load($this->itemid);
			return ($item->has_caseqty()) ? floor($this->qty) : 0;
		}

		/**
		 * Return the Number of Bottles
		 * @param  bool   $subtractcases Exclude cases?
		 * @return int                   Bottle Count
		 */
		public function get_bottleqty($subtractcases = true) {
			$item = XRefItem::load($this->itemid);

			if ($item->has_caseqty()) {
				$cases = $this->get_caseqty();
				$fraction = $subtractcases ? $this->qty - $cases : $this->qty;
				return round($fraction * $item->qty_percase);
			} else {
				return $this->qty;
			}
		}

		/**
		 * Returns the number of bottles that the cases contain
		 * @return int Number of bottles in the cases
		 */
		public function get_casebottleqty() {
			$item = XRefItem::load($this->itemid);
			$cases = $this->get_caseqty();
			return intval($cases * $item->qty_percase);
		}

		/* =============================================================
			Some functions provided by MagicMethodTraits
		============================================================ */
	}
