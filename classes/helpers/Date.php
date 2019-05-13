<?php
	/**
	 * 
	 */
	class Date {
		
		public static function getTimePast($timestamp) {
	    	$timestamp = strtotime($timestamp);
	    	$strTime = array("second", "minute", "hour", "day", "month", "year");
	    	$length = array("60","60","24","30","12","10");
	    	$currentTime = time();

	    	if($currentTime >= $timestamp) {
	    		$diff = $currentTime - $timestamp;
	    		for($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++) {
	    			$diff = $diff / $length[$i];
	    		}

	    		$diff = round($diff);
	    		if ($diff == 1) {
	    			return $diff . " " . $strTime[$i] . " ago ";
	    		}
	    		return $diff . " " . $strTime[$i] . "s ago ";
	    	}
	    }
	}