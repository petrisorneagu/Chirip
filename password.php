<?php
include 'core/init.php';

$user_id = $_SESSION['user_id'];
$user = $getFromU->userData($user_id);

if($getFromU->loggedIn() === false){
    header('Location: index.php');
}

if(isset($_POST['submit'])){
    $currentPwd = $_POST['currentPwd'];
    $newPassword = $_POST['newPassword'];
    $rePassword = $_POST['rePassword'];
    $error = array();

    if(!empty($currentPwd) && !empty($newPassword) && !empty($rePassword)){
        if($getFromU->checkPassword($currentPwd) === true){
            if(strlen($newPassword) < 4){
                $error['newPassword'] = 'Password should not be less than 6 characters';
            }elseif ($newPassword != $rePassword){
                $error['rePassword'] = 'Password does not match';
            }else{
                $getFromU->update('users', $user_id, array('password' => md5($newPassword)));
                header("Location: password.php");
            }
        }else{
            $error['newPassword'] = 'Password is incorrect';
        }
    }else{
        $error['fields'] = 'All fields are required';
    }
}

?>
<html>
<head>
    <title>Password settings</title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css"/>
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <link rel="stylesheet" href="assets/css/style-complete.css"/>
</head>
<body>
<div class="wrapper">
    <div class="header-wrapper">
        <div class="nav-container">
            <div class="nav">
                <div class="nav-left">
                    <ul>
                        <li><a href="home.php"><i class="fa fa-home" aria-hidden="true"></i>Home</a></li>
                        <li><a href="i/notifications"><i class="fa fa-bell" aria-hidden="true"></i>Notification</a></li>
                        <li id="messagePopup" rel="user_id"><i class="fa fa-envelope" aria-hidden="true"></i>Messages</li>
                    </ul>
                </div>
                <div class="nav-right">
                    <ul>
                        <li><input type="text" placeholder="Search" class="search"/><i class="fa fa-search" aria-hidden="true"></i></li>
                        <div class="nav-right-down-wrap">
                            <ul class="search-result">

                            </ul>
                        </div>
                        <li class="hover"><label class="drop-label" for="drop-wrap1"><img src="<?= $user->profileImage;?>"/></label>
                            <input type="checkbox" id="drop-wrap1">
                            <div class="drop-wrap">
                                <div class="drop-inner">
                                    <ul>
                                        <li><a href="<?= $user->username;?> "><?= $user->username;?></a></li>
                                        <li><a href="settings/account">Settings</a></li>
                                        <li><a href="includes/logout.php">Log out</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li><label for="pop-up-tweet" class="addTweetBtn">Chirp</label></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="container-wrap">

        <div class="lefter">
            <div class="inner-lefter">

                <div class="acc-info-wrap">
                    <div class="acc-info-bg">
                        <img src="<?=  $user->profileCover;?>"/>
                    </div>
                    <div class="acc-info-img">
                        <img src="<?= $user->profileImage;?>"/>
                    </div>
                    <div class="acc-info-name">
                        <h3><?= $user->screenName;?></h3>
                        <span><a href="<?=$user->username;?>">@<?=  $user->username;?></a></span>
                    </div>
                </div>

                <div class="option-box">
                    <ul>
                        <li>
                            <a href="/settings/account" class="bold">
                                <div>
                                    Account
                                    <span><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="/settings/password">
                                <div>
                                    Password
                                    <span><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>

        <div class="righter">
            <div class="inner-righter">
                <div class="acc">
                    <div class="acc-heading">
                        <h2>Password</h2>
                        <h3>Change your password or recover your current one.</h3>
                    </div>
                    <form method="POST">
                        <div class="acc-content">
                            <div class="acc-wrap">
                                <div class="acc-left">
                                    Current password
                                </div>
                                <div class="acc-right">
                                    <input type="password" name="currentPwd"/>
                                    <span>
                                         <?php if(isset($error['currentPwd'])) {echo $error['currentPwd'];}?>
							</span>
                                </div>
                            </div>

                            <div class="acc-wrap">
                                <div class="acc-left">
                                    New password
                                </div>
                                <div class="acc-right">
                                    <input type="password" name="newPassword" />
                                    <span
                                    <?php if(isset($error['newPassword'])) {echo $error['newPassword'];}?>
                                    </span>
                                </div>
                            </div>

                            <div class="acc-wrap">
                                <div class="acc-left">
                                    Verify password
                                </div>
                                <div class="acc-right">
                                    <input type="password" name="rePassword"/>
                                    <span>
                                        <?php if(isset($error['rePassword'])) {echo $error['rePassword'];}?>
							</span>
                                </div>
                            </div>
                            <div class="acc-wrap">
                                <div class="acc-left">
                                </div>
                                <div class="acc-right">
                                    <input type="Submit" name="submit" value="Save changes"/>
                                </div>
                                <div class="settings-error">
                                    <?php if(isset($error['fields'])) {echo $error['fields'];}?>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
            <div class="content-setting">
                <div class="content-heading">

                </div>
                <div class="content-content">
                    <div class="content-left">

                    </div>
                    <div class="content-right">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</body>
</html>


