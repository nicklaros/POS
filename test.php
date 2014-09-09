<?php

use ORM\MenuQuery;
use ORM\OptionQuery;
use ORM\UserQuery;
use Propel\Runtime\Propel;

require '/vendor/autoload.php';
require '/remote/propel-config.php';
require '/remote/session.php';

var_dump($session->get('pos/info'));