(function(){
    $(".content-competitions__calendar-data").on("click", function () {
        $(".content-competitions__calendar-dropdown").toggleClass("content-competitions__calendar-dropdown-opened");
    });
    $('body').on('click', function(e) {
        if (!$(e.target).closest('.content-competitions__calendar').length){
            $(".content-competitions__calendar-dropdown").removeClass("content-competitions__calendar-dropdown-opened");
        };
    });
})();