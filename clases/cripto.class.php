<?php

	class Cripto {

		static function getHash($string) {
			$type = "sha256"; //  $type == "sha256" ||	$type == "sha384" || $type == "sha512"
			return hash($type, $string);

		}

	}

	
?>