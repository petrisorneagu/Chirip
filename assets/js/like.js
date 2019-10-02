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
                counter.show();
                button.addClass('unlike-btn');
                button.removeClass('like-btn');
                count++;
                counter.text(count);
                button.find('.fa-heart-o').addClass('fa-heart');
                button.find('.fa-heart').removeClass('fa-heart-o');
            }
        );
    });

    $(document).on('click', '.unlike-btn', function(){
        var tweetId = $(this).data('tweet');
        var user_id = $(this).data('user');
        var counter = $(this).find('.likesCounter');
        var count   = counter.text();
        var button  = $(this);

        $.post('http://dev.test.com/Chirip/core/ajax/like.php',
            {unlike: tweetId,
                user_id: user_id},
            function(){
                counter.show();
                button.addClass('like-btn');
                button.removeClass('unlike-btn');
                count--;

                if(count < 1){
                    counter.hide();
                }else{
                    counter.text(count);
                }
                button.find('.fa-heart').addClass('fa-heart-o');
                button.find('.fa-heart-o').removeClass('fa-heart');
            }
        );
    });

})
