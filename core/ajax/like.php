<?php

include '../init.php';

if(isset($_POST['like']) && !empty($_POST['like'])){
    $user_id   = $_SESSION['user_id'];
    $tweet_id  = $_POST['like'];
    $get_id    = $_POST['user_id'];

    $getFromT->addLike($user_id, $tweet_id, $get_id);

}