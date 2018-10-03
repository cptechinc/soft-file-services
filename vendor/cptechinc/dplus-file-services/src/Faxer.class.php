<?php
    /**
     * Base Class for Sending and Dealing with Dplus Fax Files
     */
	class DplusFaxer {
		use ThrowErrorTrait;
		use MagicMethodTraits;
		
		/**
		 * Director where Fax Files are located
		 * @var string
		 */
		static $faxdirectory;
		
		/**
		 * Name of the Fax Request File
		 * @var string
		 */
		protected $filename;
		
		/**
		 * Example of the Fax Reuqest file after being Proceessed
		 * @var array
		 */
		protected $faxdata = array(
			'sub' => 'Quote Nbr: W0000004', // Subject
			'fll' => 'csf87649.pcl', // File Name
			'res' => 'fine', // NOT USED
			'fnm' => 'Bev Gruhlke', // From Name
			'fco' => 'C & P TECHNOLOGIES INC.', // From Company
			'fvn' => '952-888-1888', // From Phone
			'ffn' => '952-888-1813', // From Fax
			'stm' => 'now', // NOT USED
			'not' => 'both', // NOT USED
			'mad' => 'bev@cptechinc.com', // Email Address
			'tfn' => '9526532860', // Fax (The one to be faxed to)
			'tnm' => 'Bev', // NOT USED
			'tco' => '', // NOT USED
			'tvn' => '000-000-0000', // NOT USED
			'que' => 'fax1' // NOT USED
		);
        
        /**
         * Constructor
         * Prepares and Parses file to extract Fax File Data to prepare it for Sending
         * @param string $filename Name of File with Data
         */
        public function __construct($filename) {
            $this->filename = $filename;
            $file = self::$faxdirectory.$this->filename;
            $faxreader = new FaxFileReader();
            $this->set_faxdata($faxreader->process($file, $this->faxdata));
        }
		
		/**
		 * Sets the Fax Data array
		 * @param string $data Fax Data array
		 */
		public function set_faxdata($data) {
			if (gettype($data) != 'array') {
				$this->error('Fax data provided is not an array');
			} elseif (!keys_match($this->faxdata, $data)) {
				$this->error('Fax data array keys do not match to what is required');
			} else {
				$this->faxdata = $data;
			}
		}
		
		/* =============================================================
				CLASS FUNCTIONS
			============================================================ */
		/**
		* Sends Fax
		* @return void
		*/
		public function fax() {
			$this->sendfax();
		}
        
        /**
         * Sends Fax Request
         * @return void
         */
		protected function sendfax() {
			$interfax = new Interfax\Client(['username' => 'cptechno', 'password' => '8628eag1e']);
			try {
				$fax = $interfax->deliver([
				  // a valid fax number
				  'faxNumber' => '+1'.$this->faxdata['tfn'],
				  // a path to an InterFAX
				  // compatible file
				  //'file' => DplusFaxFileReader::get_filedirectory.$this->filename,
				  'file' => self::$faxdirectory.$this->faxdata['fll'],
				  'reference' => $this->faxdata['sub'],
				  'replyAddress' => $this->faxdata['mad']
				]);
			} catch (Interfax\Exception\RequestException $e) {
				echo $e->getMessage();
				// contains text detail that is available
				echo $e->getStatusCode();
				// the http status code that was received
				throw $e->getWrappedException();
				// The underlying Guzzle exception that was caught by the Interfax Client.
			}
		}
	}
