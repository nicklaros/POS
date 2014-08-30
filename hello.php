<?php

require 'vendor/autoload.php';
require 'remote/session.php';
$session->start();

var_dump( $session->get('pos/state') );
var_dump( (object) $session->get('pos/currentUser') );

$event = 'ngok/create/sss';

$array = explode('/', $event);
echo count($array);

$module = $array[0];
$methode = $array[1];

echo "module $module method $methode";

$module();

function user(){
    echo 'fungsi user';
}

function ngok(){
    echo 'fungsi ngok';
}

$msg = '{"event:"ngok", "data":1, "a":2}';
$msg = json_decode($msg);
if (!$msg) echo "zero";
if (!isset($msg->event) || !isset($msg->data)) throw new Exception('Wrong turn buddy');