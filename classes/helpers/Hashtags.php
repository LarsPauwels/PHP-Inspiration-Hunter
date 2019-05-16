<?php
	/**
	 * 
	 */
	class Hashtags {
		public static function getTags($result, $name) {
	    	for ($i=0; $i < count($result); $i++) {
	    		$specialChars = $result[$i][$name];
	    		preg_match_all('/#(\w+)/', $specialChars, $matches);

	    		if (empty($matches[0])) {
	    			$result[$i][$name] = htmlspecialchars($result[$i][$name]);
	    		}

			    foreach ($matches[1] as $match) {
			        $result[$i][$name] = str_replace("#".$match, "", $result[$i][$name]);
			        $result[$i][$name] .= ' <a href="index?q='.$match.'">#' . $match . '</a>';
			    }
	    	}
	    	return $result;
	    }
	}