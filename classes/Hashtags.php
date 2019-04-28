<?php
	/**
	 * 
	 */
	class Hashtags {
		public function getTags($result, $name) {
	    	for ($i=0; $i < count($result); $i++) {
	    		$specialChars = htmlspecialchars($result[$i][$name]);
	    		preg_match_all('/#(\w+)/', $specialChars, $matches);

			    foreach ($matches[1] as $match) {
			        $result[$i][$name] = str_replace("#".$match, "", $result[$i][$name]);
			        $result[$i][$name] .= ' <a href="index?q='.$match.'">#' . $match . '</a>';
			    }
	    	}
	    	return $result;
	    }
	}