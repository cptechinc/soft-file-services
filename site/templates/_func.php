<?php
	function hash_templatefile($filename) {
		$hash = hash_file(DplusWire::wire('config')->userAuthHashType, DplusWire::wire('config')->paths->templates.$filename);
		return DplusWire::wire('config')->urls->templates.$filename.'?v='.$hash;
	}
