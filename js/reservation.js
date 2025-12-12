
$(function () {
    $('.tabMenu li').click(function () {
        var num = $('.tabMenu li').index(this);
        $('.tabMenu li').removeClass('active');
        $(this).addClass('active');
        $('.tabContent').removeClass('active').eq(num).addClass('active');
    });
});