$(function(){
    // match the hashtag abd @ symbol
    var regex = /[#|@](\w+)$/ig;

    $(document).on('keyup', '.status', function(){
        var content = $.trim($(this).val());
        var text = content.match(regex);
        var max = 140;

        if(max != null){
            var dataString = 'hashtag=' + text;

            $.ajax({
                type: "POST",
                url:  "http://dev.test.com/Chirip/core/ajax/getHashtag.php",
                // root dependig of your root project
                data: dataString,
                cache: false,
                success: function(data){
                        $('.hash-box ul').html(data);

                }
            })
        }
    });
});