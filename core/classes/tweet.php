<?php

class Tweet extends User{

    function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function chirps($user_id){
        $stmt = $this->pdo->prepare("SELECT * FROM `chirps` , `users` WHERE `chirpBy` = `user_id`");
        $stmt->execute();

        $chirps = $stmt->fetchAll(PDO::FETCH_OBJ);

        foreach($chirps as $chirp){
            $likes = $this->likes($user_id, $chirp->chirpId);
            echo '
<div class="all-tweet">
    <div class="t-show-wrap">
        <div class="t-show-inner">
            <!-- this div is for retweet icon
            <div class="t-show-banner">
                <div class="t-show-banner-inner">
                    <span><i class="fa fa-retweet" aria-hidden="true"></i></span><span>Screen-Name Retweeted</span>
                </div>
            </div>
            -->
            <div class="t-show-popup">
                <div class="t-show-head">
                    <div class="t-show-img">
                        <img src="'.$chirp->profileImage.'"/>
                    </div>
                    <div class="t-s-head-content">
                        <div class="t-h-c-name">
                            <span><a href="'.$chirp->username.'">'.$chirp->screenName.'</a></span>
                            <span>@'.$chirp->username.'</span>
                            <span>'.$chirp->postedOn.'</span>
                        </div>
                        <div class="t-h-c-dis">     
                            '.$this->getChirpLinks($chirp->status).'
                        </div>
                    </div>
                </div>';

            if(!empty($chirp->chirpImage)) {
                echo ' <div class="t-show-body" >
                    <div class="t-s-b-inner" >
                        <div class="t-s-b-inner-in" >
                            <img src = "'.$chirp->chirpImage.'" class="imagePopup" />
                        </div >
                    </div >
                </div >';
            }
            echo '</div>
            <div class="t-show-footer">
                <div class="t-s-f-right">
                    <ul>
                        <li><button><a href="#"><i class="fa fa-share" aria-hidden="true"></i></a></button></li>
                        <li><button><a href="#"><i class="fa fa-retweet" aria-hidden="true"></i></a></button></li>
                        <li>
                        '.(($likes['likeOn'] === $chirp->chirpId)
                    ? '<button class="un    like-btn" data-tweet="'.$chirp->chirpId.'" data-user="'.$chirp->chirpBy.'"><a href="#"><i class="fa fa-heart" aria-hidden="true"></i></a><span class="likesCounter">'.$chirp->likesCount.'</span></button>'
                    : '<button class="like-btn" data-tweet="'.$chirp->chirpId.'" data-user="'.$chirp->chirpBy.'"><a href="#"><i class="fa fa-heart-o" aria-hidden="true"></i></a><span class="likesCounter">'.(($chirp->likesCount > 0) ? $chirp->likesCount : '' ).'</span></button>' ).'
                        </li>
                        <li>
                            <a href="#" class="more"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
                            <ul>
                                <li><label class="deleteTweet">Delete Chirp</label></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
';

        }
    }

    public function getTrendByHash($hashtag){
        $stmt = $this->pdo->prepare("SELECT * FROM trends WHERE hashtag LIKE :hashtag LIMIT 5");
        $stmt->bindValue(':hashtag', $hashtag.'%');
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getMention($username){
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username LIKE :username OR screenName LIKE :username LIMIT 5");
        $stmt->bindValue(':username', $username.'%');
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function addTrend($hashtag){
        preg_match_all('/#+([a-zA-Z0-9_]+)/i', $hashtag, $matches);

        if($matches){
            $result = array_values($matches[1]);
        }
        $sql = "INSERT INTO `trends` (`hashtag`, `createdOn`) VALUES (:hashtag , CURRENT_TIMESTAMP)";

        foreach($result as $trend){
            if($stmt = $this->pdo->prepare($sql)){
                $stmt->execute(array(':hashtag' => $trend));
            }
        }
    }

    public function getChirpLinks($chirp){
//        get link/domain
        $chirp = preg_replace("/(https?:\/\/)?([\w]+.)([\w\.]+)/", "<a href = '$0' target='_blank'>$0</a>", $chirp);
//        get hashtag link
        $chirp = preg_replace("/#([\w]+)/", "<a href='".BASE_URL."hashtag/$1'>$0</a>", $chirp);
//        get @ link
        $chirp = preg_replace("/@([\w]+)/", "<a href='".BASE_URL."$1'>$0</a>", $chirp);

        return $chirp;
    }

    public function addLike($user_id, $tweet_id, $get_id){
        $stmt = $this->pdo->prepare("UPDATE `chirps` SET `likesCount` = `likesCount` +1 WHERE chirpId = :tweet_id");
        $stmt->bindParam(':tweet_id', $tweet_id, PDO::PARAM_INT);
        $stmt->execute();

        $this->create('likes', array('likeBy'=>$user_id, 'likeOn' => $tweet_id ));
    }

    public function likes($user_id, $tweet_id){
        $stmt = $this->pdo->prepare("SELECT * FROM likes WHERE `likeBy` = :user_id AND `likeOn` = :tweet_id");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':tweet_id', $$tweet_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}

