document.onload = function() {
    var screen_size = $( window ).width();
    $.ajax ({
        type: 'post',
        data: {screen_size:screen_size},
        cache: false,
    });
};