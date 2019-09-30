<?php
include '../init.php';
 //  $_POST['hashtag'] is the variable set in hashtag.js -> datastring

if(isset($_POST['hashtag'])){
    $hashtag = $getFromU->checkInput($_POST['hashtag']);

    if(substr($hashtag,0, 1) === '#'){
        $trend = str_replace('#', '', $hashtag);
        $trends = $getFromT->getTrendByHash($trend);

        foreach($trends as $hash){
            echo '<li><a href="#"><span class="getValue">#'.$hash->hashtag.'</span></a></li>';
        }
    }

    if(substr($hashtag, 0 ,1) === '@'){
        $trend = str_replace('@', '', $hashtag);
        $trends = $getFromT->getMention($trend);

        foreach($trends as $mention){
                        echo '<li><div class="nav-right-down-inner">
                <div class="nav-right-down-left">
                    <span><img src="'.$mention->profileImage.'"></span>
                </div>
                <div class="nav-right-down-right">
                    <div class="nav-right-down-right-headline">
                        <a>'.$mention->screenName.'</a><span class="getValue">@'.$mention->username.'</span>
                    </div>
                </div>
            </div><!--nav-right-down-inner end-here-->
            </li>
            ';


            echo '<li><a href="#"><span class="getValue">@'.$mention->username.'</span></a></li>';
        }
    }
}

