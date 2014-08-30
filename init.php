<?php

use ORM\MenuQuery;
use ORM\OptionQuery;
use ORM\UserQuery;
use Propel\Runtime\Propel;

require 'vendor/autoload.php';
require 'remote/propel-config.php';
require 'remote/session.php';

$con = Propel::getConnection('pos');
$con->beginTransaction();

try{
    // Get application info from database
    $info = [];
    $options = OptionQuery::create()
        ->filterByName([
            'app_name',
            'dev_name',
            'dev_email',
            'dev_phone',
            'dev_website',
            'dev_address',
            'client_name',
            'client_email',
            'client_phone',
            'client_website',
            'client_address',
            'homepath'
        ])
        ->find($con);

    foreach($options as $row){
        $info[$row->getName()] = $row->getValue();
    }

    $root['info'] = $info;
    
    // Check previous session
    try{
        if (
            $session->get('pos/state') === 0 
            ||
            !isset($session->get('pos/current_user')->id)
        ){
            throw new Exception();
        }

        $user = UserQuery::create()
            ->filterById($session->get('pos/current_user')->id)
            ->select([
                'id',
                'user',
                'role_id'
            ])
            ->leftJoin('Detail')
            ->withColumn('Detail.Name', 'name')
            ->findOne($con);
        if(!$user) throw new Exception();

        $root['state'] = 1;
        $root['current_user'] = (object) $user;
    }catch (Exception $e){
    
        $root['state'] = 0;
        $root['current_user'] = null;
    }

    // Get menu from database based on state
    $menu = [];

    $menus = MenuQuery::create()
        ->filterByStatus('Active');

    ($root['state'] == 1 || $menus->filterByState(0));

    $menus
        ->select(array(
            'sub',
            'icon',
            'text',
            'action'
        ))
        ->orderBy('sub', 'ASC')
        ->orderBy('order', 'ASC')
        ->find($con);

    foreach($menus as $row){
        $menu[$row['sub']][] = $row;
    }

    $root['menu'] = $menu;

    $session->set('pos/state', $root['state']);
    $session->set('pos/current_user', $root['current_user']);
    $session->set('pos/info', $root['info']);
    $session->set('pos/menu', $root['menu']);

    $con->commit();
}catch (Exception $e){
    $con->rollBack();

   die($e->getMessage());
}

echo 'App = {};';

echo 'App.init = ';
echo json_encode($root);
echo ';';