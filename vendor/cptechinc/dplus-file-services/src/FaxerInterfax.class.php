<?php
	class Dplusfaxer_Interfax extends DplusFaxer {
		/**
		 * Interfax API Login
		 * @var string
		 */
		protected $login;
		
		/**
		 * Interfax API Password
		 * @var string
		 */
		protected $password;
		
		/* =============================================================
			GETTERS
		============================================================ */
        /**
         * Returns if any of the Credential Properties is empty
         * @return bool string
         */
		public function has_missingcredentials() {
			return (empty($this->login) || empty($this->password));
		}
		
		/* =============================================================
			SETTERS
		============================================================ */
        /**
         * Sets the Login and Password Properties
         * @param string $login    Interfax API Login
         * @param string $password Interfax API Password
         */
		public function set_credentials($login, $password) {
			$this->login = $login;
			$this->password = $password;
		}
		
		/* =============================================================
 			CLASS FUNCTIONS
 		============================================================ */
        /**
         * Sends the request to send fax
         * @return void
         */
		protected function sendfax() {
			if ($this->has_missingcredentials()) {
				$this->error('Interfax Credentials have not been provided');
				return false;
			}
			
			$interfax = new Interfax\Client(['username' => $this->login, 'password' => $this->password]);
			try {
				$fax = $interfax->deliver([
				  // a valid fax number
				  'faxNumber' => '+1'.$this->faxdata['tfn'],
				  // a path to an InterFAX
				  // compatible file
				  //'file' => DplusFaxFileReader::get_filedirectory.$this->filename,
				  'file' => $this->faxdirectory.$this->faxdata['fll'],
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
