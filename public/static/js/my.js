//头像
var head=document.getElementById('img_face');
//等级常量
var LE=50;

$(document).ready(function() {
    //处理导航
    handleNavigation();
    //进度条提示信息
    promptProgress();
    // //进度条随等级和活跃值所变化
    // initProgress();
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

/**
 * 进度条提示信息
 */
function promptProgress(){
    var progress=document.getElementById('progress');
    // eventUtil.addHandler(progress,'mouseover',function () {
    //     //显示提示信息
    //     $('#prompt_activity').addClass('border_show');
    //     $('#prompt_activity_span').text('活跃度 1000');
    // });
    eventUtil.addHandler(progress,'mouseout',function () {
        //隐藏提示信息
        $('#prompt_activity').removeClass('border_show');
        $('#prompt_activity_span').text('');
    });
}

/**
 * 显示活力值
 */
function showActivity(level,activity) {
    // alert(level+"   "+activity);
    var lower=LE*level*(level-1);
    var upper=LE*level*(level+1);
    var activity_sum=upper-lower;
    var activity_show=activity-lower;
    var value=Math.round(((1.0*activity_show)/activity_sum)*100);
    var show=value+"%";
    $('#prompt_activity').addClass('border_show');
    $('#prompt_activity_span').text('活跃度 '+activity+" ("+show+")");
}

