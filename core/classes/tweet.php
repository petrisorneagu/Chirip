<?php

class Tweet extends User{

    function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function chirps(){
        $stmt = $this->pdo->prepare("SELECT * FROM `chirps` , `users` WHERE `chirpBy` = `user_id`");
        $stmt->execute();

        $chirps = $stmt->fetchAll(PDO::FETCH_OBJ);

        foreach($chirps as $chirp){
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
                            '.$chirp->status.'
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
                        <li><button><a href="#"><i class="fa fa-heart-o" aria-hidden="true"></i></a></button></li>
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
        $stmt = $this->pdo->prepare("SELECT * FROM trends WHERE hashtag LIKE :hashtag");
        $stmt->bindValue(':hashtag', $hashtag.'%');
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }



}

?>
