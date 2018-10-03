<?php
	function hash_templatefile($filename) {
		$hash = hash_file(DplusWire::wire('config')->userAuthHashType, DplusWire::wire('config')->paths->templates.$filename);
		return DplusWire::wire('config')->urls->templates.$filename.'?v='.$hash;
	}
	
	function keys_match(array $array1, array $array2) {
        foreach ($array1 as $key => $val) {
            if (!array_key_exists($key, $array2)) {
                return false;
            }
        }
        return true;
    }
