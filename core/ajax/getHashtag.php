<?php
include '../init.php';
 //  $_POST['hashtag'] is the variable set in hashtag.js -> datastring

if(isset($_POST['hashtag'])){
    $hashtag = $getFromU->checkInput($_POST['hashtag']);

    if(substr($hashtag,0, 1) === '#'){
        $trend = str_replace('#', '', $hashtag);
        $trends = $getFromT->getTrendByHash($trend);

        foreach($trends as $hash){
            echo '<li><a href="#"><span class="getValue">'.$hash->hashtag.'</span></a></li>';
        }
    }
}

