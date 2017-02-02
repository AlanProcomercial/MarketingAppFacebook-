<?php

	/** Función para obtener la ip del visitante**/

	function getIp(){

		$client = @$_SERVER['HTTP_CLIENT_IP'];
		$foward = @$_SERVER['HTTP_X_FORWARED_FOR'];
		$remote = @$_SERVER['REMOTE_ADDR'];

		if (filter_var($client, FILTER_VALIDATE_IP)) {
			
			$ip = $client;

		}elseif(filter_var($foward, FILTER_VALIDATE_IP)){

			$ip = $foward;

		}else{

			$ip = $remote;
		}

		return $ip;
	}

	/** Fin funcion **/
?>