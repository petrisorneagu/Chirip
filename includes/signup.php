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
            }
        }else{
            $error = "Please, choose your username!";
        }

    }


    ?>
    <!--    //    display username form for update-->
    <html>
    <head>
        <title>chirp</title>
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
                                    <li><!-- error --></li>
                                </ul>
                            </div>
                            <div>
                                <input type="submit" name="next" value="Next"/>
                            </div>
                        </form>
                    </div>
                </div>


            </div>

        </div>
    </div>

    </body>
    </html>

<?php } ?>