<?php
	/**
	 * Abstract file to build Screen classes from and to provide properties and methods
	 */
	abstract class TableScreenMaker {
		use ThrowErrorTrait;

		/**
		 * Session ID
		 * Used for getting the Dplus Generated File
		 * @var string
		 */
		protected $sessionID;

		/**
		 * Run in Debug
		 * @var bool
		 */
		protected $debug = false;

		/**
		 * Table Type
		 * @var string normal | grid
		 */
		protected $grid = 'false';

		/**
		 * Type of Screen, corresponds with the function Ran to create screen
		 * @var string
		 */
		protected $type = '';

		/**
		 * Title of Screen
		 * @var string
		 */
		protected $title = '';

		/**
		 * File Name
		 * @var string
		 */
		protected $datafilename = '';

		/**
		 * Directory where files are
		 * @var string path/to/file
		 */
		protected $fullfilepath = false;

		/**
		 * Used for Test Files
		 * @var string
		 */
		protected $testprefix = '';

		/**
		 * JSON
		 * @var array
		 */
		protected $json = false; // WILL BE JSON DECODED ARRAY

		/**
		 * Array of the fields that will be used by the JSON array
		 * @var array
		 */
		protected $fields = false; // WILL BE JSON DECODED ARRAY

		/**
		 * Key Value array of Sections that exist I.E. header => Header, detail => Detail
		 * @var string
		 */
		protected $datasections = array();

		/**
		 * File Directory
		 * @var string /path/to/dir
		 */
		public static $filedir = false;
		/**
		 * File Directory for Test Files
		 * @var string /path/to/dir
		 */
		public static $testfiledir = false;

		/**
		 * File Directory for field Definitions
		 * @var string /path/to/dir
		 */
		public static $fieldfiledir = false;

		/**
		 * Columns Aliases that signifiy Tracking Number
		 * Used for generating Cell Data
		 * @var array
		 */
		protected static $trackingcolumns = array('Tracking Number');

		/**
		 * Columns Aliases that signifiy Phone Number
		 * Used for generating Cell Data
		 * @var array
		 */
		protected static $phonecolumns = array('phone', 'fax');

		/* =============================================================
			CONSTRUCTOR AND SETTER FUNCTIONS
		============================================================ */
		/**
		 * Constructor
		 * @param string $sessionID Session ID
		 * @param string $userID    User ID
		 */
		public function __construct($sessionID) {
			$this->sessionID = $sessionID;
			$this->load_filepath();
		}

		/**
		 * Turn debug on or Off
		 * @param bool $debug
		 */
		public function set_debug($debug) {
			$this->debug = $debug;
			$this->load_filepath();
		}
		
		/* =============================================================
			GETTER FUNCTIONS
		============================================================ */
		/**
		 * Looks and returns property value, also looks through
		 * @param  string $property Property name to get value from
		 * @return mixed           Value of Property
		 */
		public function __get($property) {
			if (property_exists($this, $property) !== true) {
				$this->error("This property ($property) does not exist");
				return false;
			}
			$method = "get_{$property}";
			if (method_exists($this, $method)) {
				return $this->$method();
			} else {
				return $this->$property;
			}
		}
		/**
		 * Returns the Fields Definition and loads them if not already defined
		 * @return array fields
		 */
		public function get_fields() {
			if (!$this->fields) {
				$this->load_fields();
			}
			return $this->fields;
		}

		/* =============================================================
			CLASS FUNCTIONS
		============================================================ */
		/**
		 * Sets the file path
		 * File path depends on if debug is true
		 */
		public function load_filepath() {
			$this->fullfilepath = ($this->debug) ? self::$testfiledir.$this->datafilename.".json" : self::$filedir.$this->sessionID."-".$this->datafilename.".json";
		}

		/**
		 * Converts json into array, then if errors, then we make an array for Errors
		 * @return array
		 */
		public function process_json() {
			$this->load_filepath();
			$json = json_decode(file_get_contents($this->fullfilepath), true);
			$this->json = (!empty($json)) ? $json : array('error' => true, 'errormsg' => "The $this->title JSON contains errors. JSON ERROR: ".json_last_error());
		}

		/**
		 * Returns blueprint and loads it if need be
		 * @return array blueprint array
		 */
		public function get_tableblueprint() {
			if (!$this->tableblueprint) {
				$this->generate_tableblueprint();
			}
			return $this->tableblueprint;
		}

		/**
		 * Returns the screen made
		 * @return string html of screen
		 */
		public function generate_screen() {
			return '';
		}

		/**
		 * Processes JSON then generates the screen
		 * USED BY Preview Screen formatter
		 * @param  bool $generatejavascript whether or not to use javascript
		 * @return string                    HTML for screen
		 */
		public function process_andgeneratescreen($generatejavascript = false) {
			$bootstrap = new Contento();
			if (file_exists($this->fullfilepath)) {
				// JSON file will be false if an error occurred during file_get_contents or json_decode
				$this->process_json();

				if ($this->json['error']) {
					return $bootstrap->createalert('warning', $this->json['errormsg']);
				} else {
					return $generatejavascript ? $this->generate_screen() . $this->generate_javascript() : $this->generate_screen();
				}
			} else {
				return $bootstrap->createalert('warning', 'Information Not Available');
			}
		}

		/**
		 * Returns the javascript for this screen
		 * @return string Javascript
		 */
		public function generate_javascript() {
			return '';
		}

		/**
		 * Returns the show notes input
		 * @return string  HTML select
		 */
		public function generate_shownotesselect() {
			$bootstrap = new Contento();
			$array = array();
			foreach (DplusWire::wire('config')->yesnoarray as $key => $value) {
				$array[$value] = $key;
			}
			return $bootstrap->select('class=form-control input-sm|id=shownotes', $array);
		}

		/* =============================================================
			STATIC FUNCTIONS
		============================================================ */
		/**
		 * Generates the celldata based of the column, column type and the json array it's in, looks at if the data is numeric
		 * @param string $type the type of data D = Date, N = Numeric, string
		 * @param string $parent the array in which the data is contained
		 * @param string $column the key in which we use to look up the value
		 */
		public static function generate_formattedcelldata($type, $parent, $column) {
			$bootstrap = new Contento();
			$celldata = '';
			$qtyregex = "/(quantity)/i";

			if ($type == 'D') {
				$celldata = (strlen($parent[$column['id']]) > 0) ? date($column['date-format'], strtotime($parent[$column['id']])) : $parent[$column['id']];
			} elseif ($type == 'N') {
				if (is_string($parent[$column['id']])) {
					$celldata = number_format(floatval($parent[$column['id']]), $column['after-decimal']);
				} else {
					$celldata = number_format($parent[$column['id']], $column['after-decimal']);
				}
			} else {
				$celldata = $parent[$column['id']];
			}

			return $celldata;
		}

		/**
		 * Returns the data formatted into appropriate formats
		 * Ex. Tracking Columns will have a tracking link
		 * @param  array $parent contains value
		 * @param  string $column Name of Column
		 * @return string         Value or HTML content
		 */
		public static function generate_celldata($parent, $column) {
			if(in_array($column, self::$phonecolumns)) {
				return self::generate_phoneurl($parent[$column]);
			} else {
				return $parent[$column];
			}
		}


		/**
		 * Returns phone string for URL
		 * @param  string $phone Phone Number
		 * @return string        reformatted phone value
		 */
		public static function generate_phoneurl($phone) {
			return str_replace('-', '', $phone);
		}

		/* =============================================================
			CLASS FUNCTIONS
		============================================================ */
		/**
		 * Defines Default File Directory
		 * @param string $dir [path/to/dir
		 */
		public static function set_filedirectory($dir) {
			self::$filedir = $dir;
		}

		/**
		 * Defines test File Directory
		 * @param string $dir [path/to/dir
		 */
		public static function set_testfiledirectory($dir) {
			self::$testfiledir = $dir;
		}

		/**
		 * Defines fields files Directory
		 * @param string $dir [path/to/dir
		 */
		public static function set_fieldfiledirectory($dir) {
			self::$fieldfiledir = $dir;
		}
	}
