<?php
	# CURRENT URL FINDER FUNCTION SET STARTS
	function URL_ORIGIN( $s, $use_forwarded_host = false ) // $s = $_SERVER
	{
	    $ssl      = ( ! empty( $s['HTTPS'] ) && $s['HTTPS'] == 'on' );
	    $sp       = strtolower( $s['SERVER_PROTOCOL'] );
	    $protocol = substr( $sp, 0, strpos( $sp, '/' ) ) . ( ( $ssl ) ? 's' : '' );
	    $port     = $s['SERVER_PORT'];
	    $port     = ( ( ! $ssl && $port=='80' ) || ( $ssl && $port=='443' ) ) ? '' : ':'.$port;
	    $host     = ( $use_forwarded_host && isset( $s['HTTP_X_FORWARDED_HOST'] ) ) ? $s['HTTP_X_FORWARDED_HOST'] : ( isset( $s['HTTP_HOST'] ) ? $s['HTTP_HOST'] : null );
	    $host     = isset( $host ) ? $host : $s['SERVER_NAME'] . $port;
	    return $protocol . '://' . $host;
	}

	function CURRENT_URL( $s, $use_forwarded_host = false ) // $s = $_SERVER
	{
	    return URL_ORIGIN( $s, $use_forwarded_host ) . $s['REQUEST_URI'];
	}
	# CURRENT URL FINDER FUNCTION SET ENDS

	# USER IP
	function UserIP() {
	    $IPAddress = '';
	    if (isset($_SERVER['HTTP_CLIENT_IP']))
	        $IPAddress = $_SERVER['HTTP_CLIENT_IP'];
	    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
	        $IPAddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	    else if(isset($_SERVER['HTTP_X_FORWARDED']))
	        $IPAddress = $_SERVER['HTTP_X_FORWARDED'];
	    else if(isset($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']))
	        $IPAddress = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
	    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
	        $IPAddress = $_SERVER['HTTP_FORWARDED_FOR'];
	    else if(isset($_SERVER['HTTP_FORWARDED']))
	        $IPAddress = $_SERVER['HTTP_FORWARDED'];
	    else if(isset($_SERVER['REMOTE_ADDR']))
	        $IPAddress = $_SERVER['REMOTE_ADDR'];
	    else
	        $IPAddress = 'UNKNOWN';
	    return $IPAddress;
	}

	# BANGLADESH DATE TIME 
	function BDDT(){
		$date = new DateTime("now", new DateTimeZone('Asia/Dhaka') );
		return $date->format('Y-m-d H:i:s');
	}
	function BDDATEDBFORMAT(){
		$date = new DateTime("now", new DateTimeZone('Asia/Dhaka') );
		return $date->format('Y-m-d');
	}
	# DATE WITH DATE FORMAT
	function BDDATE($BDDT){
		$BDDATE = date('d/m/Y',strtotime($BDDT));
		return $BDDATE;
	}
	function BDDATETOWORK($BDDT){
		$BDDATE = date('Y-m-d',strtotime($BDDT));
		return $BDDATE;
	}
	function BDDATEPLAIN($BDDT){
		$BDDATE = date('dmY',strtotime($BDDT));
		return $BDDATE;
	}
	# DATE FOR INVOICENUMBER
	function BDDATEFORINVOICENUMBER($BDDT){
		$BDDATE = date('dm',strtotime($BDDT));
		return $BDDATE;
	}
	# BANGLADESHI TIME FORMAT 12 HOURS
	function BDTIME($BDDT){
		$BDTIME = date('h:i A',strtotime($BDDT));
		return $BDTIME;
	}
?>