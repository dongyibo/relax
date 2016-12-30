$(document).ready(function() {
    //处理导航
    handleNavigation();
});

/**
 * 处理导航
 */
function handleNavigation() {
    $("a", '.mainmenu').click(function() {
        if($(this).hasClass('active')){
            //处于当前页面，则不跳转
            return false;
        }
    })
}