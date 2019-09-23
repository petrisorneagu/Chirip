$(function(){
    $('.search').keyup(function(){
        var search = $(this).val();
        $.post('http://dev.test.com/Chirip/core/ajax/search.php',
            {'search': search},
            function(data){
                $('.search-result').html(data);
            });
    });
});


