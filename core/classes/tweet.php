<?php

class Tweet extends User{

    function __construct($pdo)
    {
        $this->pdo = $pdo;
    }


//    this is a mess...I should include some files  :((
    public function chirps($user_id){
        $stmt = $this->pdo->prepare("SELECT * FROM `chirps` LEFT JOIN  `users` ON `chirpBy` = `user_id` WHERE `chirpBy` = :user_id AND `rechirpId` = 0  OR `chirpBy` = `user_id` AND `rechirpBy` != :user_id");

        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $chirps = $stmt->fetchAll(PDO::FETCH_OBJ);

        foreach($chirps as  $chirp){
            $likes = $this->likes($user_id, $chirp->chirpId);
            $retweet = $this->checkRetweet($chirp->chirpId, $user_id);
            $user = $this->userData($chirp->rechirpBy);

            echo '
<div class="all-tweet">
    <div class="t-show-wrap">
        <div class="t-show-inner">
        
        '.(($retweet['rechirpId'] === $chirp->rechirpId || $chirp->rechirpId > 0)  ? '
            <div class="t-show-banner">
                <div class="t-show-banner-inner">
                    <span><i class="fa fa-retweet" aria-hidden="true"></i></span><span>'.$user->screenName.' Retweeted</span>
                </div>
            </div>
            
            ' : '' ).'
        
        '.((!empty($chirp->rechirpMsg) && $chirp->chirpId === $retweet['rechirpId'] || $chirp->rechirpId > 0 ) ? '
        
        <div class="t-show-head">
	<div class="t-show-img">
		<img src="'.BASE_URL.$user->profileImage. '"/>
	</div>
	<div class="t-s-head-content">
		<div class="t-h-c-name">
			<span><a href="'.BASE_URL.$user->screenName.'">'.$user->screenName.'</a></span>
			<span>@'.$user->username.'</span>
			<span>'.$this->getChirpLinks($retweet['postedOn']).'</span>
		</div>
		<div class="t-h-c-dis">
			'.$chirp->rechirpMsg.'
		</div>
	</div>
</div>
<div class="t-s-b-inner">
	<div class="t-s-b-inner-in">
		<div class="retweet-t-s-b-inner">
		
		'.((!empty($chirp->chirpImage)) ? '
			<div class="retweet-t-s-b-inner-left">
				<img src="'.BASE_URL.$chirp->chirpImage.'"/>	
			</div>
			' : '').'
			
			<div class="retweet-t-s-b-inner-right">
				<div class="t-h-c-name">
					<span><a href="'.BASE_URL.$chirp->username.'">'.$chirp->screenName.'</a></span>
					<span>@'.$chirp->username.'</span>
					<span>'.$chirp->username.'</span>
				</div>
				<div class="retweet-t-s-b-inner-right-text">		
					'.$chirp->status.'
				</div>
			</div>
		</div>
	</div>
</div>
        ' : '
            
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
                </div>'.

            ((!empty($chirp->chirpImage)) ?
                 ' <div class="t-show-body" >
                    <div class="t-s-b-inner" >
                        <div class="t-s-b-inner-in" >
                            <img src = "'.$chirp->chirpImage.'" class="imagePopup" />
                        </div >
                    </div >
                </div >
                    ' : '').'
                
               
          </div>
          
          ').'
            <div class="t-show-footer">
                <div class="t-s-f-right">
                    <ul>
                        <li><button><a href="#"><i class="fa fa-share" aria-hidden="true"></i></a></button></li>
                        
                        <li>'.(($chirp->chirpId) === $retweet['rechirpId']
                ? '<button class="retweeted" data-tweet="'.$chirp->chirpId.'" data-user="'.$chirp->chirpBy.'"><a href="#"><i class="fa fa-retweet" aria-hidden="true"></i></a><span class="retweetsCount">'.$chirp->rechirpCount.'</span></button>'
                : '<button class="retweeted" data-tweet="'.$chirp->chirpId.'" data-user="'.$chirp->chirpBy.'"><a href="#"><i class="fa fa-retweet" aria-hidden="true"></i></a><span class="retweetsCount">'.(($chirp->rechirpCount > 0) ? $chirp->rechirpCount :'').'</span></button>').'
                        </li>
                       
                        <li>
                        '.(($likes['likeOn'] === $chirp->chirpId)
                    ? '<button class="unlike-btn" data-tweet="'.$chirp->chirpId.'" data-user="'.$chirp->chirpBy.'"><a href="#"><i class="fa fa-heart" aria-hidden="true"></i></a><span class="likesCounter">'.$chirp->likesCount.'</span></button>'
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

    /**
     * @param $tweet_id
     * @return mixed
     */
    public function getPopUpTweet($tweet_id){
        $stmt = $this->pdo->prepare("SELECT * FROM `chirps`, `users` WHERE `chirpId` = :chirpId AND `chirpBy` = `user_id`");
        $stmt->bindParam(':chirpId', $tweet_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * @param $tweet_id
     * @param $user_id
     * @param $get_id
     * @param $comment
     */
    public function retweet($tweet_id,$user_id,$get_id,$comment){
        $stmt = $this->pdo->prepare("UPDATE `chirps` SET `rechirpCount` = `rechirpCount` + 1 WHERE `chirpId` = :chirpId");
        $stmt->bindParam(':chirpId', $tweet_id, PDO::PARAM_INT);
        $stmt->execute();

//        in case of duplicate
        $stmt = $this->pdo->prepare("INSERT INTO chirps (`status`,`chirpBy`,`rechirpId`,`rechirpBy`,`chirpImage`,`postedOn`,`likesCount`,`rechirpCount`,`rechirpMsg`) SELECT `status`,`chirpBy`,`chirpImage`,`chirpId`, :user_id, CURRENT_TIMESTAMP,`likesCount`,`rechirpCount`,:rechirpMsg FROM `chirps` WHERE `chirpId` = :chirp_id") ;
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':rechirpMsg', $comment, PDO::PARAM_STR);
        $stmt->bindParam(':chirp_id', $tweet_id, PDO::PARAM_INT);

        $stmt->execute();
    }

    public function checkRetweet($tweet_id, $user_id){
        $stmt = $this->pdo->prepare("SELECT * FROM `chirps` WHERE `rechirpId` = :tweet_id AND `rechirpBy` = :user_id OR `chirpId` = :tweet_id");
        $stmt->bindParam(':tweet_id', $tweet_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);

    }

    public function addLike($user_id, $tweet_id, $get_id){
        $stmt = $this->pdo->prepare("UPDATE `chirps` SET `likesCount` = `likesCount` + 1 WHERE chirpId = :chirpId");
        $stmt->bindParam(':chirpId', $tweet_id, PDO::PARAM_INT);
        $stmt->execute();

        $this->create('likes', array('likeBy'=>$user_id, 'likeOn' => $tweet_id ));
    }

    public function unlike($user_id, $tweet_id, $get_id){
        $stmt = $this->pdo->prepare("UPDATE `chirps` SET `likesCount` = `likesCount` - 1 WHERE `chirpId` = :chirpId");
        $stmt->bindParam(':chirpId', $tweet_id, PDO::PARAM_INT);
        $stmt->execute();

        $stmt = $this->pdo->prepare("DELETE FROM `likes` WHERE `likeBy` = :user_id AND `likeOn` = :chirpId");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':chirpId', $tweet_id, PDO::PARAM_INT);
        $stmt->execute();

    }

    public function likes($user_id, $tweet_id){
        $stmt = $this->pdo->prepare("SELECT * FROM likes WHERE `likeBy` = :user_id AND `likeOn` = :chirpId");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':chirpId', $tweet_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}

