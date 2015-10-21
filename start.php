<?php
require_once('bootstrap.php');

$irc = new \MyIRCBot\IRC();
$irc->main();

//
//$config = include(__DIR__ . '/config/irc.php');
//
//if (isset($argv[1]) && $argv[1] == 'minion')
//{
//	$minion = new \MyIRCBot\Minion($argv[2]);
//	$minion->setConfig($config);
//	$minion->main();
//
//}
//else if (isset($argv[1]) && $argv[1] == 'ai')
//{
//	$cleverbot = new \MyIRCBot\Cleverbot();
//	$cleverbot->setConfig($config);
//	$cleverbot->main();
//}
//else {
//	$irc = new \MyIRCBot\IRC();
//	$irc->setConfig($config);
//	$irc->main();
//}