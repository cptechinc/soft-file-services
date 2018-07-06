<?php 
	class ReturnGoodsAuthorizationFormatter extends TableScreenFormatter {
		protected $tabletype = 'grid'; // grid or normal
		protected $type = 'return-goods-authorization'; // ii-sales-history
		protected $title = 'Return Goods Authorization';
		protected $datafilename = 'return-goods-authorization'; // iisaleshist.json
		protected $testprefix = 'rga-return-goods-authorization'; // iish
		protected $datasections = array(
			"header" => "Header"
		);
		
		public function generate_screen() {
			return $this->generate_customerheader();
		}
		
		protected function generate_customerheader() {
			$bootstrap = new HTMLWriter();
			$content = $bootstrap->open('div', 'class=row');
				$content .= $bootstrap->open('div', 'class=col-xs-6');
					$content .= $bootstrap->h3('', $this->title);
				$content .= $bootstrap->close('div');
				$content .= $bootstrap->open('div', 'class=col-xs-6');
					$imgsrc = DplusWire::wire('pages')->get('/config/')->company_logo->url;
					$company = DplusWire::wire('pages')->get('/config/')->company_displayname;
					$content .= $bootstrap->img("class=img-repsonsive|src=$imgsrc|alt=$company logo");
					$content .= $bootstrap->h4('', $company);
				$content .= $bootstrap->close('div');
			$content .= $bootstrap->close('div');
			return $content;
		}
		/**
		 * Generates the table blueprint
		 * This page divides the Item Page Screen into 4 sections / columns
		 * @return void
		 */
		protected function generate_tableblueprint() {
			$table = array(
				'header' => array(
					'sections' => array(
						'1' => array(),
						'2' => array(),
						'3' => array(),
						'4' => array()
					)
				)
			);
			
			for ($i = 1; $i < 5; $i++) {
				foreach(array_keys($this->formatter['header']['columns']) as $column) {
					if ($this->formatter['header']['columns'][$column]['column'] == $i) {
						$col = array(
							'id' => $column,
							'label' => $this->formatter['header']['columns'][$column]['label'],
							'column' => $this->formatter['header']['columns'][$column]['column'],
							'col-length' => $this->formatter['header']['columns'][$column]['col-length'],
							'before-decimal' => $this->formatter['header']['columns'][$column]['before-decimal'],
							'after-decimal' => $this->formatter['header']['columns'][$column]['after-decimal'],
							'date-format' => $this->formatter['header']['columns'][$column]['date-format']
						 );
						$table['header']['sections'][$i][$this->formatter['header']['columns'][$column]['line']] = $col;
					}
				}
			}
			$this->tableblueprint = $table;
		}
	}
	
	
