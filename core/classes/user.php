<?php


class User{
    protected $pdo;
    function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @param $var
     * @return string
     */
    public function checkInput($var){
        $var = htmlspecialchars($var);
        $var = trim($var);
        $var = stripcslashes($var);

        return $var;
    }

    /**
     * login with user & pass
     * @param $email
     * @param $password
     * @return bool
     */
    public function login($email, $password){
//            error_reporting(null); for passing md5 by reference in bindParam -- if needed
        $stmt = $this->pdo->prepare("SELECT user_id FROM users WHERE email = :email AND password = :password");
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $password = md5($password);
        $stmt->bindParam(":password", $password, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_OBJ);
        $count = $stmt->rowCount($user);

        if($count >0){
            $_SESSION['user_id'] = $user->user_id;
            header('Location: home.php');
        }else{
            return false;
        }
    }

    /**
     * returns * from users table
     * @param $user_id
     * @return mixed
     */
    public function userData($user_id){
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE user_id = :user_id");
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function logout(){
        $_SESSION = array();
        session_destroy();
        header('Location: ../index.php');
    }

}