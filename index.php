<?php

require_once './AsynClient.php';
require_once './Shard.php';


$async_client = new AsynClient();
$async_client->setShard(new Shard('localhost', 'testuser', 'testpass', 'test'));
$async_client->setShard(new Shard('localhost', 'testuser', 'testpass1', 'test'));
$async_client->setShard(new Shard('localhost', 'testuser', 'testpass', 'test'));


$res = $async_client->fetch("select * from bets where created_at between '2016-01-01' and '2016-10-31'");


print "<pre>";
print_r($res);
print "</pre>";




