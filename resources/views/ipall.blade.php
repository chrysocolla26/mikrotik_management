<?php
use PEAR2\Net\RouterOS;

#include 'PEAR2_Net_RouterOS-1.0.0b6';
#require_once 'PEAR2_Net_RouterOS-1.0.0b6/src/PEAR2/Autoload.php';

header('Content-Type: text/plain');

try {
   	$client = new RouterOS\Client('10.21.0.152', 'admin', 'mikman123!');
	// Ambil List IP
	$getIPs = $client->sendSync(new RouterOS\Request('/ip address print'));
	foreach ($getIPs as $getIP){
	    if($getIP->getType() === RouterOS\Response::TYPE_DATA) {
      		echo 'IP: ', $getIP->getProperty('src-address'),
	      ' Interface: ', $getIP->getProperty('dst-address'),
	      "<br/>";
	    }
	}
} catch (Exception $e) {
  die ($e);
}
