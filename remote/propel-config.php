<?php
$serviceContainer = \Propel\Runtime\Propel::getServiceContainer();
$serviceContainer->checkVersion('2.0.0-dev');
$serviceContainer->setAdapterClass('pos', 'mysql');
$manager = new \Propel\Runtime\Connection\ConnectionManagerSingle();
$manager->setConfiguration(array (
  'dsn' => 'mysql:host=localhost;dbname=pos',
  'user' => 'root',
  'password' => 'sqlpass',
));
$manager->setName('pos');
$serviceContainer->setConnectionManager('pos', $manager);
$serviceContainer->setDefaultDatasource('pos');