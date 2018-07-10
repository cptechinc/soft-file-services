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
		
		/**
		 * Returns the title for the document screen
		 * @return string Document Title
		 */
		public function get_doctitle() {
			return $this->debug ? "$this->title DEBUG" : $this->title . ' #'.$this->sessionID;
		}

		public function generate_screen() {
			$bootstrap = new HTMLWriter();
			$content = $this->generate_documentheader();
			$this->generate_tableblueprint();

			$content .= $bootstrap->open('div','class=row');
			for ($i = 1; $i < 5; $i++) {
				$content .= $bootstrap->div('class=col-sm-4 form-group', $this->generate_headersection($i));
			}
			$content .= $bootstrap->close('div');
			$content .= $bootstrap->div('class=form-group', $this->generate_detailsection());
			$content .= $bootstrap->hr('');
			$content .= $this->generate_footersection();
			return $content;
		}

		protected function generate_documentheader() {
			$bootstrap = new HTMLWriter();
			$barcoder_png = new Picqer\Barcode\BarcodeGeneratorPNG();
			$barcode_base64 = base64_encode($barcoder_png->getBarcode($this->json['RGA Number'], $barcoder_png::TYPE_CODE_128));
			
			$content = $bootstrap->open('div', 'class=row');
				$content .= $bootstrap->open('div', 'class=col-xs-6 form-group');
					$content .= $bootstrap->h3('', $this->title);
					$content .= $bootstrap->h4('', 'RGA #'. $this->json['RGA Number']);
					$content .= $bootstrap->div('', $bootstrap->img("src=data:image/png;base64,$barcode_base64|class=img-responsive|alt=RGA # Barcode"));
				$content .= $bootstrap->close('div');
				$content .= $bootstrap->open('div', 'class=col-xs-6 form-group');
					$imgsrc = DplusWire::wire('pages')->get('/config/')->company_logo->url;
					$company = DplusWire::wire('pages')->get('/config/')->company_displayname;
					$content .= $bootstrap->img("class=img-repsonsive|src=$imgsrc|alt=$company logo");
					$content .= $bootstrap->h4('', $company);
					$content .= $bootstrap->p('', DplusWire::wire('pages')->get('/config/')->company_address);
				$content .= $bootstrap->close('div');
			$content .= $bootstrap->close('div');
			return $content;
		}

		protected function generate_headersection($number = 1) {
			$bootstrap = new HTMLWriter();
			$tb = new Table('class=table table-condensed table-striped');

			foreach ($this->tableblueprint['header']['sections']["$number"] as $column) {
				$tb->tr();
				$tb->td('', $bootstrap->b('', $column['label']));

				$celldata = $this->json['data']['header'][$column['id']];
				$tb->td('', $celldata);
			}
			return $tb->close();
		}
		
		protected function generate_detailsection() {
			$bootstrap = new HTMLWriter();
			$tb = new Table('class=table table-condensed table-striped');
			$tb->tablesection('thead');
			foreach ($this->tableblueprint['detail']['rows'] as $detailrow) {
				$tb->tr();
				for ($i = 1; $i < ($this->formatter['detail']['cols'] + 1); $i++) {
					$column = $detailrow['columns']["$i"];
					$tb->th('', $column['label']);
				}
			}
			$tb->closetablesection('thead');
			
			foreach ($this->tableblueprint['detail']['rows'] as $detailrow) {
				$tb->tr();
				for ($colnumber = 1; $colnumber < ($this->formatter['detail']['cols'] + 1); $colnumber++) {
					$column = $detailrow['columns'][$colnumber];
					$celldata = $this->json['data']['detail'][$column['id']];
					$colspan = $column['col-length'];
					$class = HTMLWriter::get_justifyclass($column['data-justify']);
					
					if ($column['id'] == 'Item ID') {
						$celldata .= "<br>".$this->json['data']['detail']['Item Description 1'];
					} else {
						$celldata = TableScreenMaker::generate_formattedcelldata($this->json['data']['detail'], $column);
					}
					$tb->td("colspan=$colspan|class=$class", $celldata);
				}
			}
			return $tb->close();
		}
		
		protected function generate_footersection() {
			$bootstrap = new HTMLWriter();
			$content = $bootstrap->div('class=form-group', DplusWire::wire('pages')->get("/config/documents/$this->type/")->terms);
			$content .= $bootstrap->br();
			$tb = new Table('class=table table-condensed table-striped');
			$tb->tr();
			$tb->td('', 'Date: ')->td('', $bootstrap->input('class=form-control input-sm underlined price'));
			$tb->tr();
			$tb->td('', 'Received by: ')->td('', $bootstrap->input('class=form-control input-sm underlined price'));
			$content .= $tb->close();
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
						'4' => array(),
						'5' => array(),
						'6' => array()
					)
				),
				'detail' => array(
					'cols' => 0,
					'rows' => array()
				)
			);

			for ($i = 1; $i < sizeof($table['header']['sections']); $i++) {
				foreach (array_keys($this->formatter['header']['columns']) as $column) {
					if ($this->formatter['header']['columns'][$column]['column'] == $i) {
						$col = array(
							'id' => $column,
							'label' => $this->formatter['header']['columns'][$column]['label'],
							'column' => $this->formatter['header']['columns'][$column]['column'],
							'type' => $this->formatter['header']['columns'][$column]['type'],
							'col-length' => $this->formatter['header']['columns'][$column]['col-length'],
							'before-decimal' => $this->formatter['header']['columns'][$column]['before-decimal'],
							'after-decimal' => $this->formatter['header']['columns'][$column]['after-decimal'],
							'date-format' => $this->formatter['header']['columns'][$column]['date-format'],
							'input' => $this->formatter['header']['columns'][$column]['input'],
							'data-justify' => $this->formatter['header']['columns'][$column]['data-justify'],
						 );
						$table['header']['sections'][$i][$this->formatter['header']['columns'][$column]['line']] = $col;
					}
				}
			}
			$section = 'detail';
			$columns = array_keys($this->formatter[$section]['columns']);
			$skipable_columns = array('Item Description 1', 'Item Description 2');
			
			for ($i = 1; $i < $this->formatter[$section]['rows'] + 1; $i++) {
        		$table[$section]['rows'][$i] = array('columns' => array());
        		foreach ($columns as $column) {
        			if ($this->formatter[$section]['columns'][$column]['line'] == $i && !in_array($column, $skipable_columns)) {
        				$col = array(
        					'id' => $column, 
        					'label' => $this->formatter[$section]['columns'][$column]['label'],
        					'column' => $this->formatter[$section]['columns'][$column]['column'],
							'type' => $this->formatter[$section]['columns'][$column]['type'],
        					'col-length' => $this->formatter[$section]['columns'][$column]['col-length'],
        					'before-decimal' => $this->formatter[$section]['columns'][$column]['before-decimal'],
        					'after-decimal' => $this->formatter[$section]['columns'][$column]['after-decimal'],
        					'date-format' => $this->formatter[$section]['columns'][$column]['date-format'],
							'input' => $this->formatter[$section]['columns'][$column]['input'],
							'data-justify' => $this->formatter[$section]['columns'][$column]['data-justify'],
        				 );
        				$table[$section]['rows'][$i]['columns'][$this->formatter[$section]['columns'][$column]['column']] = $col;
        			}
        		}
        	}
			$this->tableblueprint = $table;
		}
	}
