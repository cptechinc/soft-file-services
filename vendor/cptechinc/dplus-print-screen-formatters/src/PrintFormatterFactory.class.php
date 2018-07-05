<?php
	/**
	 * Factory to load all the Screen Formatters
	 */
	class PrintFormatterFactory {
		use ThrowErrorTrait;
		
		/**
		 * Session Identifier
		 * @var string
		 */
		protected $sessionID;
		
		/**
		 * Formatter Array with code as the key and the NAme as the value
		 * @var array
		 */
		protected $formatters = array(
			'return-goods-authorization' => 'ReturnGoodsAuthorizationFormatter'
		);
		
		/**
		 * Constructor
		 * @param string $sessionID Session Identifier
		 */
		public function __construct($sessionID) {
			$this->sessionID = $sessionID;
		}
		
		/**
		 * Returns Screen formatter object of the type provided
		 * @param  string $type Formatter Type
		 * @return TableScreenMaker       Screen object
		 */
		public function generate_formatter($type) {
			if (in_array($type, array_keys($this->formatters))) {
				return new $this->formatters[$type]($this->sessionID);
			} else {
				$this->error("Formatter $type does not exist");
				return false;
			}
		}
	} 
