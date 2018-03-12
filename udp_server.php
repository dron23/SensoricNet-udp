<?php


$conf['version'] = "v0.1"; // verze
$conf['bind_address'] = '0.0.0.0';
$conf['bind_port'] = 9999;
$conf['base_dir'] = dirname(__FILE__);
$conf['log_filename'] = $conf['base_dir']."/log/nbiot_udp.log";

$conf['log_severities'] = array (
		'emergency' => 0,
		'alert'     => 1,
		'critical'  => 2,
		'error'     => 3,
		'warning'   => 4,
		'notice'    => 5,
		'info'      => 6,
		'debug'     => 7
);
$conf['log_severity'] = 'debug';


/**
 * logovani podle nastavene severity na obrazovku a do souboru
 *
 * @param string $severity
 * @param string $text
 */
function logit($severity, $text) {
	global $conf, $log;
	
	if ($conf['log_severities'][$conf['log_severity']] >= $conf['log_severities'][$severity]) {
		$text_array = explode("\n", $text);
		foreach ($text_array as $line) {
			fputs($log, date("Ymd H:i:s ") . strtoupper($severity) . ": " . $line . "\n");
		}
	}
}


/************************************************************
 * main
 ************************************************************/

// Reduce errors
error_reporting ( ~ E_WARNING );

// logovaci soubor
$log = fopen($conf['log_filename'], "a");
if (!$log) {
	die("Cannot open log file ".$conf['log_filename']);
}

logit ('info', "SensoricNet UDP reciever version ".$conf['version']);

// Create a UDP socket
if (! ($sock = socket_create ( AF_INET, SOCK_DGRAM, 0 ))) {
	$errorcode = socket_last_error ();
	$errormsg = socket_strerror ( $errorcode );
	
	logit ('emergency', "Couldn't create socket: [$errorcode] $errormsg");
	die ();
}


// Bind the source address
if (! socket_bind ( $sock, $conf['bind_address'], $conf['bind_port'] )) {
	$errorcode = socket_last_error ();
	$errormsg = socket_strerror ( $errorcode );
	
	logit ('emergency', "Couldn't bind socket: [$errorcode] $errormsg");
	die ();
}

logit ('info', "Listening on ".$conf['bind_address'].":".$conf['bind_port']);


// Do some communication, this loop can handle multiple clients
while (1) {
	
	// Receive some data
	$r = socket_recvfrom ($sock, $buf, 512, 0, $remote_ip, $remote_port);
	logit ('info', "UDP packet recieved. remote_ip: $remote_ip remote_port: $remote_port");
	logit ('debug', "UDP packet data dump: ".print_r($buf, true));

// do the magic here...

// decode cayenne lpp, test validity of packet
// create ttn json structure and call SensoricNet api
// profit

}

socket_close ( $sock );
