<?php
/**
 * GLOBAL FUNCTIONS
 */
	class Functions
	{
		public function __construct()
			{
				return( '{' . __METHOD__ . '}' );
			}
			public function p($array){
				echo("<pre>".print_r($array,true)."</pre>");
			}
	}
?>