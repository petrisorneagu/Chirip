<?php
if(isset($_GET['username']) && !empty($_GET['username'])){
    include 'core/init.php';
    $username    = $getFromU->checkInput($_GET['username']);
    $profileId   = $getFromU->userIdByUsername($username);

//    echo $profileId;
    $profileData = $getFromU->userData($profileId);
    $user_id     = $_SESSION['user_id'];
    $user        = $getFromU->userData($user_id);

    echo $user;

    if(!$profileData){
        header('Location: index.php');
    }
}

?>

<!doctype html>
<html>
<head>
    <title>Chirp - to Sara</title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="assets/css/style-complete.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css"/>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>

</head>
<body>
<div class="wrapper">
    <div class="header-wrapper">
        <div class="nav-container">
            <div class="nav">
                <div class="nav-left">
                    <ul>
                        <li><a href="home.php"><i class="fa fa-home" aria-hidden="true"></i>Home</a></li>
                        <?php if($getFromU->loggedIn() === true) {


                            ?>
                        <li><a href="i/notifications"><i class="fa fa-bell" aria-hidden="true"></i>Notification</a></li>
                        <li><i class="fa fa-envelope" aria-hidden="true"></i>Messages</li>
                        <?php }     ?>

                    </ul>
                </div>
                <div class="nav-right">
                    <ul>
                        <li><input type="text" placeholder="Search" class="search"/><i class="fa fa-search" aria-hidden="true"></i>
                            <div class="search-result">
                            </div>
                        </li>

                        <?php if($getFromU->loggedIn() === true) {
                            $getFromU->loggedIn()
                            ?>


                        <li class="hover"><label class="drop-label" for="drop-wrap1"><img src="<?php echo  BASE_URL. $user->profileImage;?>"/></label>
                            <input type="checkbox" id="drop-wrap1">
                            <div class="drop-wrap">
                                <div class="drop-inner">
                                    <ul>
                                        <li><a href="<?=BASE_URL. $user->username;?>"><?= $user->username;?></a></li>
                                        <li><a href="<?php echo BASE_URL ;?>settings/account">Settings</a></li>
                                        <li><a href="<?php echo BASE_URL ;?>includes/logout.php">Log out</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li><label for="pop-up-tweet" class="addTweetBtn">Chirp</label></li>
                        <?php }else {
                            echo '<li><a href="'.BASE_URL.'index.php">Have an account? Log in!</a></li>';
                        }
                        ?>
                    </ul>
                </div>

            </div>
        </div>
    </div>

    <div class="profile-cover-wrap">
        <div class="profile-cover-inner">
            <div class="profile-cover-img">

                <img src="<?=BASE_URL. $profileData->profileCover;?>"/>
            </div>
        </div>
        <div class="profile-nav">
            <div class="profile-navigation">
                <ul>
                    <li>
                        <div class="n-head">
                            CHIRPS
                        </div>
                        <div class="n-bottom">
                            0
                        </div>
                    </li>
                    <li>
                        <a href="<?=BASE_URL. $profileData->username;?>/following">
                            <div class="n-head">
                                <a href="<?=BASE_URL. $profileData->username;?>/following">FOLLOWING</a>
                            </div>
                            <div class="n-bottom">
                                <span class="count-following"><?=$profileData->following;?></span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="<?=BASE_URL. $profileData->username;?>/followers">
                            <div class="n-head">
                                FOLLOWERS
                            </div>
                            <div class="n-bottom">
                                <span class="count-followers"><?=$profileData->followers;?></span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <div class="n-head">
                                LIKES
                            </div>
                            <div class="n-bottom">
                                0
                            </div>
                        </a>
                    </li>
                </ul>
                <div class="edit-button">
		<span>
			<button class="f-btn follow-btn"  data-follow="user_id" data-user="user_id"><i class="fa fa-user-plus"></i> Follow </button>
		</span>
                </div>
            </div>
        </div>
    </div>


    <div class="in-wrapper">
        <div class="in-full-wrap">
            <div class="in-left">
                <div class="in-left-wrap">
                    <div class="profile-info-wrap">
                        <div class="profile-info-inner">
                            <div class="profile-img">
                                <img src="<?=$profileData->profileImage;?>"/>
                            </div>

                            <div class="profile-name-wrap">
                                <div class="profile-name">
                                    <a href="<?=BASE_URL. $profileData->profileCover;?>"><?=$profileData->screenName;?></a>
                                </div>
                                <div class="profile-tname">
                                    @<span class="username"><?=$profileData->username;?></span>
                                </div>
                            </div>

                            <div class="profile-bio-wrap">
                                <div class="profile-bio-inner">
                                    <?=$profileData->bio;?>
                                </div>
                            </div>

                            <div class="profile-extra-info">
                                <div class="profile-extra-inner">
                                    <ul>

                                        <?php if(!empty($profileData->country)) {?>
                                            <li>
                                                <div class="profile-ex-location-i">
                                                    <i class="fa fa-map-marker" aria-hidden="true"></i>
                                                </div>
                                                <div class="profile-ex-location">
                                                    <?=$profileData->country;?>
                                                </div>
                                            </li>
                                        <?php }?>

                                        <?php if(!empty($profileData->website)) {?>
                                            <li>
                                                <div class="profile-ex-location-i">
                                                    <i class="fa fa-link" aria-hidden="true"></i>
                                                </div>
                                                <div class="profile-ex-location">
                                                    <a href="<?php echo $profileData->website; ?>" target="_blank"><?php echo $profileData->website; ?></a>
                                                </div>
                                            </li>
                                        <?php }?>

                                        <li>
                                            <div class="profile-ex-location-i">

                                            </div>
                                            <div class="profile-ex-location">
                                            </div>
                                        </li>
                                        <li>
                                            <div class="profile-ex-location-i">
                                            </div>
                                            <div class="profile-ex-location">
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="profile-extra-footer">
                                <div class="profile-extra-footer-head">
                                    <div class="profile-extra-info">
                                        <ul>
                                            <li>
                                                <div class="profile-ex-location-i">
                                                    <i class="fa fa-camera" aria-hidden="true"></i>
                                                </div>
                                                <div class="profile-ex-location">
                                                    <a href="#">0 Photos and videos </a>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="profile-extra-footer-body">
                                    <ul>
                                        <!-- <li><img src="#"/></li> -->
                                    </ul>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="in-center">
                <div class="in-center-wrap">

                </div>
                <div class="popupTweet"></div>
            </div>

            <div class="in-right">
                <div class="in-right-wrap">


                </div>
            </div>

        </div>
    </div>
</div>
</body>
</html>

