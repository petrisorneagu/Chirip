<?php

if (isset($_POST['signup'])){
    $screenName = $_POST['screenName'];
    $email      = $_POST['email'];
    $password   = $_POST['password'];

    $error = '';
    if(empty($screenName) || empty($email) || empty($password)){
            $error = 'All fields are required!';
    }else{
//        email validation
        $email = $getFromU->checkInput($email);
        $screenName = $getFromU->checkInput($screenName);
        $password = $getFromU->checkInput($password);
         if(!filter_var($email)){
             $error = "Invalid email format";
         }else if(strlen($screenName) > 20){
             $error = 'Name should not be greater than 20 characters.';
         }else if(strlen($password) < 5){
             $error = 'Password is too short.';
         }else{
             if($getFromU->checkEmail($email) === true){
                 $error = 'Email is already in use.';
             }else{
//                 create the account
                $user_id = $getFromU->create('users', array('email'=>$email, 'password' => md5($password), 'screenName' => $screenName, 'profileImage'=> 'assets/images/defaultProfileImage.png', 'profileCover'=>'assets/images/defaultCoverImage.png'));
                $_SESSION['user_id'] = $user_id;
                 header('Location: includes/signup.php?step=1');
//                 echo $user_id;

             }
         }
    }
}

?>

<form method="post">
    <div class="signup-div">
        <h3>Register </h3>
        <ul>
            <li>
                <input type="text" name="screenName" placeholder="Full Name"/>
            </li>
            <li>
                <input type="email" name="email" placeholder="Email"/>
            </li>
            <li>
                <input type="password" name="password" placeholder="Password"/>
            </li>
            <li>
                <input type="submit" name="signup" Value="Inregistreaza-te la Chirip">
            </li>
        </ul>
<?php

if(isset($error)){
    echo '<li class="error-li">
	  <div class="span-fp-error">'.$error.'</div>
	 </li>';
}
?>


    </div>
</form>
