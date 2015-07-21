<?php
return array(
		'driver'    => 'pdo_mysql',
		'user'      => getenv('db_username'),
		'password'  => getenv('db_password'),
		'dbname'    => getenv('myircbot_dbname'),
		'host'      => '127.0.0.1'
);