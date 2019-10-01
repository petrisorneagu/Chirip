$(function(){
    $(document).on('click', '.like-btn', function(){
        var tweetId = $(this).data('tweet');
        var user_id = $(this).data('user');
        var counter = $(this).find('.likesCounter');
        var count   = counter.text();
        var button  = $(this);

        $.post('http://dev.test.com/Chirip/core/ajax/like.php',
            {like: tweetId,
                user_id: user_id},
            function(){
                button.addClass('unlike-btn');
                button.removeClass('like-btn');
                count++;
                counter.text(count);
                button.find('.fa-heart-o').addClass('fa-heart');
                button.find('.fa-heart').removeClass('fa-heart-o');
            }
        );
    });

})
