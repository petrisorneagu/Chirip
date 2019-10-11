<?php
include '../init.php';

if(isset($_POST['showpopup']) && !empty($_POST['showpopup'])){
    $tweetId = $_POST['shoupopup'];
    $user_id = $_SESSION['user_id'];
    $tweet   = $getFromT->getPopUpTweet($tweetId);
    $likes   = $getFromT->likes($user_id, $tweetId);
    $retweet = $getFromT->checkRetweet($tweetId, $user_id);


    ?>

    <div class="tweet-show-popup-wrap">
        <input type="checkbox" id="tweet-show-popup-wrap">
        <div class="wrap4">
            <label for="tweet-show-popup-wrap">
                <div class="tweet-show-popup-box-cut">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </div>
            </label>
            <div class="tweet-show-popup-box">
                <div class="tweet-show-popup-inner">
                    <div class="tweet-show-popup-head">
                        <div class="tweet-show-popup-head-left">
                            <div class="tweet-show-popup-img">
                                <img src="PROFILE-IMAGE"/>
                            </div>
                            <div class="tweet-show-popup-name">
                                <div class="t-s-p-n">
                                    <a href="PROFILE-LINK">
                                        SCREEN-NAME
                                    </a>
                                </div>
                                <div class="t-s-p-n-b">
                                    <a href="PROFILE-LINK">
                                        @USERNAME
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="tweet-show-popup-head-right">
                            <button class="f-btn"><i class="fa fa-user-plus"></i> Follow </button>
                        </div>
                    </div>
                    <div class="tweet-show-popup-tweet-wrap">
                        <div class="tweet-show-popup-tweet">
                            STATUS
                        </div>
                        <div class="tweet-show-popup-tweet-ifram">
                            <img src="TWEET-IMAGE"/>
                        </div>
                    </div>
                    <div class="tweet-show-popup-footer-wrap">
                        <div class="tweet-show-popup-retweet-like">
                            <div class="tweet-show-popup-retweet-left">
                                <div class="tweet-retweet-count-wrap">
                                    <div class="tweet-retweet-count-head">
                                        RETWEET
                                    </div>
                                    <div class="tweet-retweet-count-body">
                                        RETWEET-COUNT
                                    </div>
                                </div>
                                <div class="tweet-like-count-wrap">
                                    <div class="tweet-like-count-head">
                                        LIKES
                                    </div>
                                    <div class="tweet-like-count-body">
                                        LIKES-COUNT
                                    </div>
                                </div>
                            </div>
                            <div class="tweet-show-popup-retweet-right">

                            </div>
                        </div>
                        <div class="tweet-show-popup-time">
                            <span>TWEET-TIME</span>
                        </div>
                        <div class="tweet-show-popup-footer-menu">
                            <ul>
                                <li><button type="buttton"><i class="fa fa-share" aria-hidden="true"></i></button></li>
                                <li><button type="button"><i class="fa fa-retweet" aria-hidden="true"></i><span class="retweetsCount">RETWEET-COUNT</span></button></li>
                                <li><button type="button"><i class="fa fa-heart" aria-hidden="true"></i><span class="likesCount">LIKES-COUNT</span></button></button></li>
                                <li>
                                    <a href="#" class="more"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
                                    <ul>
                                        <li><label class="deleteTweet" >Delete Tweet</label></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div><!--tweet-show-popup-inner end-->
                <div class="tweet-show-popup-footer-input-wrap">
                    <div class="tweet-show-popup-footer-input-inner">
                        <div class="tweet-show-popup-footer-input-left">
                            <img src="PROFILE-IMAGE"/>
                        </div>
                        <div class="tweet-show-popup-footer-input-right">
                            <input id="commentField" type="text" name="comment"  placeholder="Reply to @username">
                        </div>
                    </div>
                    <div class="tweet-footer">
                        <div class="t-fo-left">
                            <ul>
                                <li>
                                    <!-- <label for="t-show-file"><i class="fa fa-camera" aria-hidden="true"></i></label>
                                    <input type="file" id="t-show-file"> -->
                                </li>
                                <li class="error-li">
                                </li>
                            </ul>
                        </div>
                        <div class="t-fo-right">
                            <input type="submit" id="postComment">
                        </div>
                    </div>
                </div><!--tweet-show-popup-footer-input-wrap end-->

                <div class="tweet-show-popup-comment-wrap">
                    <div id="comments">
                        <!--COMMENTS-->
                    </div>

                </div>
                <!--tweet-show-popup-box ends-->
            </div>
        </div>

    <?php

}

?>