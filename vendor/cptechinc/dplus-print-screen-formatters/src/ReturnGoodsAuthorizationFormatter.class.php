<?php
	class ReturnGoodsAuthorizationFormatter extends TableScreenFormatter {
		protected $tabletype = 'grid'; // grid or normal
		protected $type = 'return-goods-authorization'; // ii-sales-history
		protected $title = 'Return Goods Authorization';
		protected $datafilename = 'rga'; // rga.json
		protected $testprefix = 'rga-return-goods-authorization'; // iish
		protected $datasections = array(
			"header" => "Header",
			"detail" => "Detail"
		);

		/**
		 * Returns the title for the document screen
		 * @return string Document Title
		 */
		public function get_doctitle() {
			return $this->debug ? "$this->title DEBUG" : $this->title . ' #'.$this->sessionID;
		}

		/**
		 * Returns the HTML content needed to generate the Print Screen
		 * @return string HTML
		 */
		public function generate_screen() {
			$bootstrap = new Dplus\Content\HTMLWriter();
			$content = $this->generate_documentheader();
			$this->generate_tableblueprint();

			$content .= $bootstrap->open('div','class=row');
			for ($i = 1; $i < 5; $i++) {
				$content .= $bootstrap->div('class=col-xs-4', $this->generate_headersection($i));
			}
			$content .= $bootstrap->close('div');
			$content .= $this->generate_termsection();
			$content .= $bootstrap->div('class=form-group', $this->generate_detailsection());
			$content .= $bootstrap->h4('class=text-center', "** A copy of this Authorization must accompany this shipment **");
			$content .= $bootstrap->hr('');
			$content .= $bootstrap->footer('class=print', $this->generate_receivesection());
			return $content;
		}

		/**
		 * Returns the Header Portion of the RGA Document
		 * Includes RGA Number, Company Logo, Company Address
		 * @return string HTML Content
		 */
		protected function generate_documentheader() {
			$bootstrap = new Dplus\Content\HTMLWriter();
			$barcoder_png = new Picqer\Barcode\BarcodeGeneratorPNG();
			$barcode_base64 = base64_encode($barcoder_png->getBarcode($this->json['RGA Number'], $barcoder_png::TYPE_CODE_128));
			$companydata = $this->json['data']['header'];
			
			$content = $bootstrap->open('div', 'class=row');
				$content .= $bootstrap->open('div', 'class=col-xs-6');
					$content .= $bootstrap->h3('', $this->title);
					$content .= $bootstrap->h4('', 'RGA #'. $this->json['RGA Number']);
					$content .= $bootstrap->div('', $bootstrap->img("src=data:image/png;base64,$barcode_base64|class=img-responsive|alt=RGA # Barcode"));
					$content .= $bootstrap->br();
					//$content .= $bootstrap->p('class=strong', "A copy of this Authorization must accompany this shipment");
				$content .= $bootstrap->close('div');
				$content .= $bootstrap->open('div', 'class=col-xs-6 text-right');
					//$imgsrc = DplusWire::wire('pages')->get('/config/')->company_logo->url;
					//$company = DplusWire::wire('pages')->get('/config/')->company_displayname;
					//$content .= $bootstrap->img("class=img-repsonsive|src=$imgsrc|alt=$company logo");
					$content .= $bootstrap->h4('', $companydata['Return Warehouse Name']);
					$address = $companydata['Return Whse Address 1']."<br>".$companydata['Return Whse Address 2']."<br>".$companydata['Return Whse Address 3'];
					$address .= "<br>".$bootstrap->b('', 'Phone: ').$companydata['Return Whse Phone Number']." &nbsp; &nbsp".$bootstrap->b('', 'Fax: ').$companydata['Return Whse Fax Number'];
					$content .= $bootstrap->p('', $address);
				$content .= $bootstrap->close('div');
			$content .= $bootstrap->close('div');
			return $content;
		}

		/**
		 * Returns the Header information of an RGA
		 * @param  int    $number Which Section Number 1 - 6
		 * @return string         HTML Table for that section
		 */
		protected function generate_headersection($number = 1) {
			$bootstrap = new Dplus\Content\HTMLWriter();
			$tb = new Dplus\Content\Table('class=table table-condensed table-striped');

			foreach ($this->tableblueprint['header']['sections']["$number"] as $column) {
				$tb->tr();
				$tb->td('', $bootstrap->b('', $column['label']));

				$celldata = $this->json['data']['header'][$column['id']];
				$tb->td('', $celldata);
			}
			return $tb->close();
		}

		/**
		 * Returns HTML Table for the detail lines on the RGA
		 * @return string  HTML Table
		 */
		protected function generate_detailsection() {
			$bootstrap = new Dplus\Content\HTMLWriter();
			$tb = new Dplus\Content\Table('class=table table-condensed table-striped|id=rga-table');
			$tb->tablesection('thead');
			foreach ($this->tableblueprint['detail']['rows'] as $detailrow) {
				$tb->tr();
				for ($i = 1; $i < ($this->formatter['detail']['colcount'] + 1); $i++) {
					$column = $detailrow['columns']["$i"];
					$class = Dplus\Content\HTMLWriter::get_justifyclass($column['label-justify']);
					$tb->th("class=$class", $column['label']);
				}
			}
			$tb->closetablesection('thead');
			$tb->tablesection('tbody');
			
			$this->formatter['detail']['colcount'] = $this->formatter['detail']['colcount'] > 6 ? $this->formatter['detail']['colcount'] : 6;
			
			for ($i = 1; $i < sizeof($this->json['data']['detail']) + 1; $i++) {
				foreach ($this->tableblueprint['detail']['rows'] as $detailrow) {
					$tb->tr();
					for ($colnumber = 1; $colnumber < ($this->formatter['detail']['colcount'] + 1); $colnumber++) {
						if (isset($detailrow['columns'][$colnumber])) {
							$column = $detailrow['columns'][$colnumber];
							$celldata = $this->json['data']['detail'][$i][$column['id']];
							$colspan = $column['col-length'];
							$class = Dplus\Content\HTMLWriter::get_justifyclass($column['data-justify']);

							if ($column['id'] == 'Item ID') {
								$celldata .= "<br>".$bootstrap->span('class=description-small', ($this->json['data']['detail'][$i]['Item Description 1']));
							} else {
								$celldata = TableScreenMaker::generate_formattedcelldata($this->json['data']['detail'][$i], $column);
							}
							$tb->td("colspan=$colspan|class=$class", $celldata);
						} else {
							if ($columncount < $this->tableblueprint['detail']['cols']) {
								$colspan = 1;
								$tb->td();
							}
						}
					}
				}
			}
			$tb->closetablesection('tbody');
			return $tb->close();
		}

		/**
		 * Returns the HTML for the terms section of the document
		 * @return string HTML Content
		 */
		protected function generate_termsection() {
			$bootstrap = new Dplus\Content\HTMLWriter();
			$terms = $bootstrap->div('class=form-group', DplusWire::wire('pages')->get("/config/documents/$this->type/")->terms);
			$content = str_replace(array('{shipvia}', '{shipviaacct}'), array($this->json['data']['header']['Return Ship Via Desc'], $this->json['data']['header']['Return Ship Account Nbr']), $terms);
			$content .= $bootstrap->br();
			return $content;
		}
		
		/**
		 * Returns Lines for Date and Received by
		 * @return string HTML Content
		 */
		protected function generate_receivesection() {
			$bootstrap = new Dplus\Content\HTMLWriter();
			$barcoder_png = new Picqer\Barcode\BarcodeGeneratorPNG();
			$barcode_base64 = base64_encode($barcoder_png->getBarcode($this->json['RGA Number'], $barcoder_png::TYPE_CODE_128));
			$tb = new Dplus\Content\Table('class=table table-condensed table-striped');
			$tb->tr();
			$tb->td('', $bootstrap->label('', 'Received by: ').$bootstrap->input('class=form-control form-control-sm underlined price'));
			$tb->td('', $bootstrap->label('', 'Date: ').$bootstrap->input('class=form-control input-sm underlined price'));
			$tb->td('', $bootstrap->label('', 'RGA #'.$this->json['RGA Number']).$bootstrap->img("src=data:image/png;base64,$barcode_base64|class=img-responsive|alt=RGA # Barcode"));
			$tb->td('', $bootstrap->label('', 'Customer: ').$bootstrap->p('class=form-control-static', $this->json['data']['header']['Customer Name']));
			return $tb->close();
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
					'colcount' => 0,
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
							'label-justify' => $this->formatter['header']['columns'][$column]['label-justify']
						 );
						$table['header']['sections'][$i][$this->formatter['header']['columns'][$column]['line']] = $col;
						$table['header']['colcount'] = $col['column'] > $table['header']['colcount'] ? $col['column'] : $table['header']['colcount'];
					}
				}
			}
			$section = 'detail';
			$columns = array_keys($this->formatter[$section]['columns']);
			$skipable_columns = array('Item Description 1', 'Item Description 2');

			for ($i = 1; $i < $this->formatter[$section]['rowcount'] + 1; $i++) {
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
							'label-justify' => $this->formatter[$section]['columns'][$column]['label-justify']
        				 );
        				$table[$section]['rows'][$i]['columns'][$this->formatter[$section]['columns'][$column]['column']] = $col;
						$table[$section]['colcount'] = $col['column'] > $table[$section]['colcount'] ? $col['column'] : $table[$section]['colcount'];
        			}
        		}
        	}
			$this->tableblueprint = $table;
		}
	}
