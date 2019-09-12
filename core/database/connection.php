<?php
    $dsn = 'mysql:host=localhost; dbname=chirip';
    $user = 'root';
    $pass = '11';

    try{
        $pdo = new PDO($dsn,$user,$pass);

    }catch(PDOException $e){
        echo 'Connection error!' . $e->getMessage();
    }
