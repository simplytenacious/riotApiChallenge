<?php

$root = dirname(__DIR__);

require_once $root.'/etc/config.php';
require_once $root.'/lib/classes/mysql.php';
require_once $root.'/lib/classes/API.php';
require_once $root.'/lib/h2o.php';

\connection\Connection::setConnectionData($_db);
