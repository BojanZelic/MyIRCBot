<?php
require_once('bootstrap.php');

$config = include(__DIR__ . '/config/irc.php');


if (isset($argv[1]) && $argv[1] == 'minion')
{
	$minion = new \MyIRCBot\Minion();
	$minion->setConfig($config);
	$minion->main();

} else {
	$irc = new \MyIRCBot\IRC();
	$irc->setConfig($config);
	$irc->main();
}