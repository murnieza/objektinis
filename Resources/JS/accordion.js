(function($) {
    $('.accordion  .tab').on('click', function(){
       var element = $(this).next('ol');
        if (element.is(':visible')) {
            makeInvisible(element);
        } else {
            makeVisible(element);
        }
    });

    function makeVisible(element){
        element.css("display", "block");
    }

    function makeInvisible(element){
        element.css("display", "none");
    }

    $('.accordion p.heading').on('click', function(){
        var parentDiv = $(this).parent();

        $('div.form').addClass('invisible').removeClass('visible');

        var nextForm = parentDiv.find('div.form');
        nextForm.removeClass('invisible').addClass('visible');

    });
})(jQuery);