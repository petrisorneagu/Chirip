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
        header('Location: '.BASE_URL. 'index.php');
    }

    /**
     * create user & insert it into db
     * @param $table
     * @param array $fields
     * @return mixed
     */
    public function create($table, $fields = array()){
        $columns = implode(',', array_keys($fields));
        $values  = ':'. implode(', :', array_keys($fields));
        $sql     = "INSERT INTO {$table} ({$columns}) VALUES ({$values})";

        if($stmt = $this->pdo->prepare($sql)){
            foreach($fields as $key => $data){
                $stmt->bindValue(':'.$key, $data);
            }
            $stmt->execute();
            return $this->pdo->lastInsertId();
        }
    }

    /**
     * update db
     * @param $table
     * @param $user_id
     * @param array $fields
     */
    public function update($table, $user_id, $fields = array()){
        $columns = '';
        $i = 1;
// gets the columns name from the field array
        foreach($fields as $name => $value){
            $columns .= "`{$name}` = :{$name}";
            if($i < count($fields)){
                $columns .= ', ';
            }
            $i++;
        }
        $sql = "UPDATE {$table} SET {$columns} WHERE `user_id` = {$user_id}";
        if($stmt = $this->pdo->prepare($sql)){
//            bind var
            foreach($fields as $key => $value){
                $stmt->bindValue(':'.$key, $value);
            }
        }
        $stmt->execute();
    }

    /**
     * check if user exists
     * @param $username
     * @return bool
     */
    public function checkUsername($username){
        $stmt = $this->pdo->prepare("SELECT `username` FROM `users` WHERE `username ` = :username");
        $stmt->bindParam(":username", $username, PDO::FETCH_OBJ);
        $stmt->execute();

        $count = $stmt->rowCount();
        if($count > 0){
            return true;
        }else{
            return false;
        }
    }

    /**
     * check if email already exists
     * @param $email
     * @return bool
     */
    public function checkEmail($email){
        $stmt = $this->pdo->prepare("SELECT `email` FROM `users` WHERE `email ` = :email");
        $stmt->bindParam(":email", $email, PDO::FETCH_OBJ);
        $stmt->execute();

        $count = $stmt->rowCount();
        if($count > 0){
            return true;
        }else{
            return false;
        }
    }

    public function loggedIn(){
        return (isset($_SESSION['user_id'])) ? true : false;
    }

    /**
     * takes the user id related to username
     * @param $username
     * @return mixed
     */
    public function userIdByUsername($username){
        $stmt = $this->pdo->prepare("SELECT `user_id` FROM users WHERE `username` = :username");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_OBJ);

        return $user->user_id;
    }

    /**
     * register new user in db
     * @param $email
     * @param $screenName
     * @param $password
     */
    public function register($email, $screenName, $password){
            $stmt = $this->pdo->prepare("INSERT INTO `users` ('email','password','screenName','profileImage','profileCover') VALUES (:email, :password, :screenName, 'assets/images/defaultProfileImage.png', 'assets/images/defaultCoverImage.png')");
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $password, PDO::PARAM_STR);
            $stmt->bindParam(':screenName', $screenName, PDO::PARAM_STR);
            $stmt->execute();

            $user_id = $this->pdo->lastInsertId();
            $_SESSION['user_id'] = $user_id;
    }

}