$(function(){
    $(document).on('click', '.t-show-popup', function(){
        var tweet_id = $(this).data('tweet');

        $.post('http://dev.test.com/Chirip/core/ajax/popuptweets.php',
            {showpopup: tweet_id},
            function (data) {
                    $('.popupTweet').html(data);
            }
        )
    })
})