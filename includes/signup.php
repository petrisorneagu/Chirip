<?php
include '../core/init.php';

$user_id = $_SESSION['user_id'];

$user = $getFromU->userData($user_id);

if(isset($_GET['step']) && !empty($_GET['step'])){
    if(isset($_POST['next'])){
        $username = $getFromU->checkInput($_POST['username']);

        if(!empty($username)){
            if(strlen($username) > 20){
                $error = "Username must be 6 to 20 characters";
            }else if($getFromU->checkUsername($username) === true){
                $error = "Username is already taken!";
            }else{
//                update username
                $getFromU->update('users', $user_id, array('username'=>$username));
                header('Location: signup.php?step=2');
            }
        }else{
            $error = "Please, choose your username!";
        }
    }
    ?>


    <!--    //    display username form for update-->
    <html>
    <head>
        <title>Chirp update</title>
        <meta charset="UTF-8" />
        <link rel="stylesheet" href="../assets/css/font/css/font-awesome.css"/>
        <link rel="stylesheet" href="../assets/css/style-complete.css"/>
    </head>
    <body>
    <div class="wrapper">
        <div class="nav-wrapper">
            <div class="nav-container">
                <div class="nav-second">
                    <ul>
                        <li><a href="#"<i class="fa fa-commenting" aria-hidden="true"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="inner-wrapper">
            <div class="main-container">
                <?php if($_GET['step'] == '1') {?>

                    <div class="step-wrapper">
                        <div class="step-container">
                            <form method="post">
                                <h2>Choose a Username</h2>
                                <h4>Don't worry,you can change it anytime.</h4>
                                <div>
                                    <input type="text" name="username" placeholder="Username"/>
                                </div>
                                <div>
                                    <ul>
                                        <li><?php  if(isset($error)){echo $error;};?></li>
                                    </ul>
                                </div>
                                <div>
                                    <input type="submit" name="next" value="Next"/>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php }?>

<!--                success message-->
                <?php if($_GET['step'] == '2') {?>
                <div class='lets-wrapper'>
                    <div class='step-letsgo'>
                        <h2>We're glad you're here, <?= $user->screenName;?></h2>
                        <p>Chirp is a constantly updating stream of the coolest, most important news, media, sports, TV, conversations and more--all tailored just for you.</p>
                        <br/>
                        <p>
                            Tell us about all the stuff you love and we'll help you get set up.
                        </p>
                        <span>
				<a href='../home.php' class='backButton'>Let's go!</a>
			</span>
                    </div>
                </div>
        <?php } ?>
            </div>
        </div>
    </div>
    </body>
    </html>

<?php } ?>