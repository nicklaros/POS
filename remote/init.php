<?php

use ORM\MenuQuery;
use ORM\OptionQuery;
use ORM\UserQuery;
use Propel\Runtime\Propel;

require '../vendor/autoload.php';
require 'propel-config.php';
require 'session.php';

$con = Propel::getConnection('pos');
$con->beginTransaction();

try{
    // Get application info from database
    $info = [];
    $options = OptionQuery::create()
        ->filterByName([
            'app_name',
            'app_photo',
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
    
    // get shortcut key from database
    $shortcutKeys = [];
    $keys = OptionQuery::create()
        ->filterByName([
            'sales_key',
            'sales_add_key',
            'sales_pay_key',
            'sales_save_key',
            'sales_cancel_key',
            'purchase_key',
            'purchase_add_key',
            'purchase_pay_key',
            'purchase_save_key',
            'purchase_cancel_key'
        ])
        ->find($con);

    foreach($keys as $key){
        $shortcutKeys[$key->getName()] = $key->getValue();
    }

    $root['shortcutKeys'] = $shortcutKeys;
    
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
            ->withColumn('Detail.Address', 'address')
            ->withColumn('Detail.Phone', 'phone')
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

    // get application root folder
    $homepath       = $info['homepath'];
    $localpath      = getenv('SCRIPT_NAME');
    $absolutepath   = realpath(basename($localpath));
    $absolutepath   = str_replace("\\","/", $absolutepath);
    $root['folder'] = substr($absolutepath, 0, strpos($absolutepath, $localpath)) . $homepath;
    
    $session->set('pos/state', $root['state']);
    $session->set('pos/current_user', $root['current_user']);
    $session->set('pos/info', $root['info']);
    $session->set('pos/menu', $root['menu']);
    $session->set('pos/folder', $root['folder']);

    $con->commit();
}catch (Exception $e){
    $con->rollBack();

   die($e->getMessage());
}

echo 'App = {};';

echo 'App.init = ';
echo json_encode($root);
echo ';';