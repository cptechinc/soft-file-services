<?php
    /* =============================================================
        TABLE FORMATTER FUNCTIONS
    ============================================================ */
    /**
     * Returns Formatter for print
     * @param  string $formatter Formatter type
     * @param  bool   $debug     Run in debug? If so, return SQL Query
     * @return string            JSON encoded string of the formatter
     */
    function get_printformatter($formatter, $debug = false) {
        $q = (new QueryBuilder())->table('formatter_print');
        $q->field('data');
        $q->where('type', $formatter);
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
	 * @param  bool   $debug     Run in debug? If so, return SQL Query
	 * @return bool              Does Formatter Exist
	 */
	function does_printformatterexist($userID, $formatter, $debug = false) {
		$q = (new QueryBuilder())->table('formatter_printr');
		$q->field($q->expr('IF(COUNT(*) > 0, 1, 0)'));
		$q->where('type', $formatter);
		$sql = DplusWire::wire('database')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}
