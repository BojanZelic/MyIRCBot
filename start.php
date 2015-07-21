<?php
require_once('bootstrap.php');

$config = array(
	"server"       => "irc.dev",
	"port"         => 6667,
	"username"     => "jQuery",
	"realname"     => "Why not javascript??",
	"nick"         => "jQuery",
	"channels"     => array( '#dev' ),
	"unflood"      => 500,
	"debug"        => true,
	"log"          => __DIR__ . '/bot.log',
);

$irc = new \MyIRCBot\IRC();
$irc->setConfig($config);
$irc->main();