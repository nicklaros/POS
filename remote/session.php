<?php
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\MemcacheSessionHandler;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;

$memcache = new Memcache;
$memcache->connect('localhost', 11211);

$storage = new NativeSessionStorage(array(), new MemcacheSessionHandler($memcache));

$session = new Session($storage);