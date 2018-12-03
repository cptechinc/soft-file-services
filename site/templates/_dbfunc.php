<?php
	use Dplus\ProcessWire\DplusWire;
	use Dplus\Base\QueryBuilder;
	
	/* =============================================================
		PRINT FORMATTER FUNCTIONS
	============================================================ */
	/**
	 * Returns Formatter for print
	 * @param  string $formatter Formatter type
	 * @param  string $userID    User ID
	 * @param  bool   $debug     Run in debug? If so, return SQL Query
	 * @return string            JSON encoded string of the formatter
	 */
	function get_screenformatter($formatter, $userID = 'default', $debug = false) {
		$q = (new QueryBuilder())->table('formatter_print');
		$q->field('data');
		$q->where('type', $formatter);
		$q->where('user', $userID);
		$q->limit(1);
		$sql = DplusWire::wire('database')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}
	
	/**
	 * Returns if formatter exists
	 * @param  string $formatter Formatter Type
	 * @param  string $userID    User ID
	 * @param  bool   $debug     Run in debug? If so, return SQL Query
	 * @return bool              Does Formatter Exist
	 */
	function does_screenformatterexist($formatter, $userID = 'default', $debug = false) {
		$q = (new QueryBuilder())->table('formatter_print');
		$q->field($q->expr('IF(COUNT(*) > 0, 1, 0)'));
		$q->where('type', $formatter);
		$q->where('user', $userID);
		$sql = DplusWire::wire('database')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}
	
	/**
	 * Updates the formatter for that user
	 * @param  string $formatter Formatter Type
	 * @param  string $userID    User ID
	 * @param  string $data      JSON encoded string
	 * @param  bool   $debug     Run in debug? If so, return SQL Query
	 * @return array             Response array
	 */
	function update_screenformatter($formatter, $userID = 'default', $data, $debug = false) {
		$q = (new QueryBuilder())->table('formatter_print');
		$q->mode('update');
		$q->set('data', $data);
		$q->where('user', $userID);
		$q->where('type', $formatter);
		$sql = DplusWire::wire('database')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return array('sql' => $q->generate_sqlquery($q->params), 'success' => $sql->rowCount() ? true : false, 'updated' => $sql->rowCount() ? true : false, 'querytype' => 'update');
		}
	}
	
	/**
	 * Creates the formatter for that user
	 * @param  string $formatter Formatter Type
	 * @param  string $userID    User ID
	 * @param  string $data      JSON encoded string
	 * @param  bool   $debug     Run in debug? If so, return SQL Query
	 * @return array             Response array
	 */
	function create_screenformatter($formatter, $userID = 'default', $data, $debug = false) {
		$q = (new QueryBuilder())->table('formatter_print');
		$q->mode('insert');
		$q->set('data', $data);
		$q->set('user', $userID);
		$q->set('type', $formatter);
		$sql = DplusWire::wire('database')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return array('sql' => $q->generate_sqlquery($q->params), 'success' => DplusWire::wire('database')->lastInsertId() > 0 ? true : false, 'id' => DplusWire::wire('database')->lastInsertId(), 'querytype' => 'create');
		}
	}
