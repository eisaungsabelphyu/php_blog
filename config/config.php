<?php 
define('MYSQL_HOST','localhost');
define('DBNAME','blog');
define('USERNAME','root');
define('PASSWORD','');

try{
    $pdo = new PDO('mysql:host='.MYSQL_HOST.';dbname='.DBNAME,USERNAME,PASSWORD);
}catch(PDOException $e){
    die($e->getMessages());
}