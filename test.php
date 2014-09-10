<?php

use ORM\MenuQuery;
use ORM\OptionQuery;
use ORM\UserQuery;
use Propel\Runtime\Propel;

require '/vendor/autoload.php';
require '/remote/propel-config.php';
require '/remote/session.php';

$data['a'] = [1,2,3,4,5];

$data = json_encode($data);

var_dump($data);