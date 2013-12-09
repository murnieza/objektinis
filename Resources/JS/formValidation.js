(function($){

    $('#registration-form').on("submit", function(event){
        var username = $("#content input[name='username']");
        var password = $("#content input[name='password']");
        var password2 = $("#content input[name='password2']");

        username.removeClass("error");
        password.removeClass("error");
        password2.removeClass("error");

        setError(username, "");
        setError(password, "");
        setError(password2, "");

        if (username.val().length == 0) {
            username.addClass("error");
            setError(username, "Empty field");
            event.preventDefault();
        }

        if (password.val().length == 0) {
            password.addClass("error");
            setError(password, "Empty field");
            event.preventDefault();
        }

        if (password2.val().length == 0) {
            password2.addClass("error");
            setError(password2, "Empty field");
            event.preventDefault();
        }

        if (password.val().length > 0 && password2.val().length > 0 && password.val() != password2.val()) {
            password.addClass("error");
            password2.addClass("error");
            setError(password, "Passwords differs");
            setError(password2, "Passwords differs");
            event.preventDefault();
        }
    });

    $('#loginForm').on("submit", function(event){
        var username = $("#loginForm input[name='username']");
        var password = $("#loginForm input[name='password']");

        username.removeClass("error");
        password.removeClass("error");

        if (username.val().length == 0) {
            username.addClass("error");
            event.preventDefault();
        }

        if (password.val().length == 0) {
            password.addClass("error");
            event.preventDefault();
        }

    });

    $('.editCourse').on("submit", function(event){
        var title = $(this).find("input[name='title']");
        var date = $(this).find("input[name='date']");
        var price = $(this).find("input[name='price']");
        var freeSlots = $(this).find("input[name='freeSlots']");
        var totalSlots = $(this).find("input[name='totalSlots']");
        var description = $(this).find("textarea[name='description']");

        title.removeClass("error");
        date.removeClass("error");
        price.removeClass("error");
        freeSlots.removeClass("error");
        totalSlots.removeClass("error");
        description.removeClass("error");

        if (title.val().length == 0) {
            title.addClass("error");
            setError(title, "Empty field");
            event.preventDefault();
        }

        if (date.val().length == 0) {
            date.addClass("error");
            setError(date, "Empty field");
            event.preventDefault();
        }

        if (price.val().length == 0) {
            price.addClass("error");
            setError(price, "Empty field");
            event.preventDefault();
        }

        if (freeSlots.val().length == 0) {
            freeSlots.addClass("error");
            setError(freeSlots, "Empty field");
            event.preventDefault();
        }

        if (totalSlots.val().length == 0) {
            totalSlots.addClass("error");
            setError(totalSlots, "Empty field");
            event.preventDefault();
        }

        if (description.val().length == 0) {
            description.addClass("error");
            setError(description, "Empty field");
            event.preventDefault();
        }
    });

    function setError(obj, errorText) {
        obj.next(".error-message").html(errorText);
    }

})(jQuery);