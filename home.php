<?php
include 'core/init.php';

$user_id =  $_SESSION['user_id'];
$user    = $getFromU->userData($user_id);

if($getFromU->loggedIn() === false){
    header('Location: index.php');
}

if(isset($_POST['chirp'])){
    $status = $getFromU->checkInput($_POST['status']);
    $chirpImage = '';

    if(!empty($status) || !empty($_FILES['name'][0])){
        if(!empty($_FILES['file']['name'][0])){
            $chirpImage = $getFromU->uploadImage($_FILES['file']);
        }
        if(strlen($status) > 200){
            $error = 'The length of your chirp is too long';
        }
//        create the post(chirp)
        $getFromU->create('chirps', array('status' => $status, 'chirpBy' => $user_id, 'chirpImage' => $chirpImage, 'postedOn' => date('Y-m-d H:i:s' )));

        preg_match_all('/#+([a-zA-Z0-9_]+)/i', $status, $hashtag);
        if(!empty($hashtag)){
            $getFromT->addTrend($status);
        }

    }else{
        $error = 'Type something or choose an image to post';
    }

}


?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Chirpy</title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css"/>
    <link rel="stylesheet" href="assets/css/style-complete.css"/>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
</head>
<body>
<div class="wrapper">
    <div class="header-wrapper">

        <div class="nav-container">
            <div class="nav">

                <div class="nav-left">
                    <ul>
                        <li><a href="#"><i class="fa fa-home" aria-hidden="true"></i>Home</a></li>
                        <li><a href="i/notifications"><i class="fa fa-bell" aria-hidden="true"></i>Notification</a></li>
                        <li><i class="fa fa-envelope" aria-hidden="true"></i>Messages</li>
                    </ul>
                </div>

                <div class="nav-right">
                    <ul>
                        <li>
                            <input type="text" placeholder="Search" class="search"/>
                            <i class="fa fa-search" aria-hidden="true"></i>
                            <div class="search-result">

                            </div>
                        </li>

                        <li class="hover"><label class="drop-label" for="drop-wrap1"><img src="<?= $user->profileImage; ?>"/></label>
                            <input type="checkbox" id="drop-wrap1">
                            <div class="drop-wrap">
                                <div class="drop-inner">
                                    <ul>
                                        <li><a href="<?= $user->username; ?>"><?= $user->username; ?></a></li>
                                        <li><a href="settings/account">Settings</a></li>
                                        <li><a href="includes/logout.php">Log out</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li><label class="addTweetBtn">Chirp</label></li>
                    </ul>
                </div>

            </div>

        </div>

    </div>

    <script type="text/javascript" src="assets/js/search.js"></script>
    <script type="text/javascript" src="assets/js/hashtag.js"></script>

    <!---Inner wrapper-->
    <div class="inner-wrapper">
        <div class="in-wrapper">
            <div class="in-full-wrap">
                <div class="in-left">
                    <div class="in-left-wrap">
                        <div class="info-box">
                            <div class="info-inner">
                                <div class="info-in-head">
                                    <img src="<?= $user->profileCover; ?>"/>
                                </div>
                                <div class="info-in-body">
                                    <div class="in-b-box">
                                        <div class="in-b-img">

                                            <img src="<?= $user->profileImage; ?>"/>
                                        </div>
                                    </div>
                                    <div class="info-body-name">
                                        <div class="in-b-name">
                                            <div><a href="<?= $user->username; ?>"><?= $user->screenName; ?></a></div>
                                            <span><small><a href="<img src=<?= $user->username; ?>">@<?= $user->username; ?></a></small></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="info-in-footer">
                                    <div class="number-wrapper">
                                        <div class="num-box">
                                            <div class="num-head">
                                                CHIRPS
                                            </div>
                                            <div class="num-body">
                                                10
                                            </div>
                                        </div>
                                        <div class="num-box">
                                            <div class="num-head">
                                                FOLLOWING
                                            </div>
                                            <div class="num-body">
                                                <span class="count-following"><?= $user->following;?></span>
                                            </div>
                                        </div>
                                        <div class="num-box">
                                            <div class="num-head">
                                                FOLLOWERS
                                            </div>
                                            <div class="num-body">
                                                <span class="count-followers"><?= $user->followers;?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
                <div class="in-center">
                    <div class="in-center-wrap">
                        <div class="tweet-wrap">
                            <div class="tweet-inner">
                                <div class="tweet-h-left">
                                    <div class="tweet-h-img">
                                        <img src="<?= $user->profileImage; ?>"/>
                                    </div>
                                </div>
                                <div class="tweet-body">
                                    <form method="post" enctype="multipart/form-data">
                                        <textarea class="status" name="status" placeholder="Type Something here!" rows="4" cols="50"></textarea>
                                        <div class="hash-box">
                                            <ul>
                                            </ul>
                                        </div>
                                </div>
                                <div class="tweet-footer">
                                    <div class="t-fo-left">
                                        <ul>
                                            <input type="file" name="file" id="file"/>
                                            <li><label for="file"><i class="fa fa-camera" aria-hidden="true"></i></label>
                                                <span class="tweet-error">
                                                    <?php if(isset($error)){echo $error;}else if(isset($imageError)){echo $imageError;
                                                    };?>
                                                </span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="t-fo-right">
                                        <span id="count">140</span>
                                        <input type="submit" name="chirp" value="chirp"/>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="tweets">

                            <?php $getFromT->chirps(); ?>
                        </div>

                        <div class="loading-div">
                            <img id="loader" src="assets/images/loading.svg" style="display: none;"/>
                        </div>
                        <div class="popupTweet"></div>

                            <script type="text/javascript" src="assets/js/like.js"></script>

                    </div>
                </div>

                <div class="in-right">
                    <div class="in-right-wrap">


                    </div>

                </div>

            </div>

        </div>
    </div>
</div>
</body>

</html>
