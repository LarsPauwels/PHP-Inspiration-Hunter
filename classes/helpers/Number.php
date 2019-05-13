<?php
	class Number {

		public static function transform($number) {
			if ($number < 10000) {
				$number = number_format($number);
			} else if ($number >= 10000000000) {
				$number = number_format($number/1000000000) . "B";
			} else if ($number >= 10000000) {
				$number = number_format($number/1000000) . "M";
			} else if ($number >= 10000) {
				$number = number_format($number/1000) . "K";
			}

			return $number;
		}
	}