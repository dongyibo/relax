
$(document).ready(function() {
    //活动介绍与详情切换
    switchBlock();
    //处理降序按钮
    handleDescBtn();
    //年份月份处理
    handleTime();
});

/**
 * 活动介绍与详情切换
 */
function switchBlock(){
    $('.more_detail').click(function () {
        var ancestor=$(this).parent().parent().parent();
        //隐藏介绍面板
        ancestor.css("display","none");
        //显示详情面板
        ancestor.next().css("display","block");
    });

    $('.back_to_introduction').click(function () {
        var ancestor=$(this).parent().parent().parent().parent().parent();;
        //隐藏详情面板
        ancestor.css("display","none");
        //显示介绍面板
        ancestor.prev().css("display","block");
    });
}

/**
 * 发布
 */
function releaseActivity(id) {
        //上传活动文字信息
        uploadText(id);
}

/**
 * 上传活动文字信息
 */
function uploadText(id) {
    var name=$('#name').val();
    var address=$('#address').val();
    var year=$('#year').val();
    var month=$('#month').val();
    var day=$('#day').val();
    var hour=$('#hour').val();
    var minute=$('#minute').val();
    var second=$('#second').val();
    var limit=$('#peopleLimit').val();
    var detail=$('#detail').val();
    var value=$('#input_file').val();
    if(value==''){
        alert("请选择图片~");
        return;
    }
    // alert(hour+" "+minute);
    //定义成功后的处理
    var success=function (data) {
        if(data.msg=='success'){
            clearErrorsPrompt();
            //alert(data.id);
            //再上传图片
            uploadPicture();
        }
        else{
            //处理文字错误信息
            handleErrors(data);
        }
    };
    //开始异步传输数据
    $.ajax({
        type: 'POST',
        url: '/relax/public/ajax/activity',
        data: {
            'sponsorId':id,
            'name' : name,
            'address':address,
            'year':year,
            'month':month,
            'day':day,
            'hour':hour,
            'minute':minute,
            'second':second,
            'limit':limit,
            'detail':detail
        },
        dataType: 'json',
        success: success,
        error: function(xhr, type){
            alert(xhr.status);
            alert(xhr.readyState);
            alert(type);
        }
    });
}

/**
 * 上传活动图片信息
 */
function uploadPicture() {
    var options = {
        success:function (response) {
            alert(response.success);
            //让活动以发布时间降序
            window.location = '/relax/public/admin/activity/release';
        },
        error:function (xhr, type) {
            alert(xhr.status);
            alert(xhr.readyState);
            alert(type);
        },
        dataType: 'json'
    };
    //提交
    $('#upload_img').ajaxForm(options).submit();
}

/**
 * 处理文字错误信息
 * @param data
 */
function handleErrors(data) {
    //先清空所有错误提示
    clearErrorsPrompt();
    //显示错误
    for(var i in data){
        var split=data[i].split(' ');
        switch(split[0]){
            case '活动名称':
                $('#name_error').text(data[i]);
                break;
            case '活动地址':
                $('#address_error').text(data[i]);
                break;
            case '人数上限':
                $('#limit_error').text(data[i]);
                break;
            case '活动详情':
                $('#detail_error').text(data[i]);
                break;
            default:  break;
        }
    }
}

/**
 * 清空所有错误提示
 */
function clearErrorsPrompt() {
    $('#name_error').text('');
    $('#address_error').text('');
    $('#limit_error').text('');
    $('#detail_error').text('');
}

/**
 * 处理降序按钮
 */
function handleDescBtn() {
    $("button", '#desc_div').click(function() {
        if($(this).hasClass('active')){
            //处于当前页面，则不跳转
            return false;
        }
    })
}

/**
 * 让活动下架
 * @param id
 * @param time
 */
function deleteActivity(id,time) {
    var timestamp=Math.round(new Date().getTime()/1000) ;
    if(time>timestamp){
        if(confirm("活动还未过期，确定下台吗？")){
            window.location='/relax/public/admin/activity/'+id;
        }
    }
    else {
        window.location = '/relax/public/admin/activity/' + id;
    }
}

/**
 * 时间处理
 */
function handleTime(){
    var timeHandler=function () {
        var numOfMonth=[31,28,31,30,31,30,31,31,30,31,30,31];
        var year=$('#year').val();
        var month=$('#month').val();
        var num="";
        if(month==2&&isLeapYear(year)){
            num=numOfMonth[month-1]+1;
        }
        else{
            num=numOfMonth[month-1];
        }
        $('#day').empty();
        for(var i=1;i<=num;i++){
            if(i<10){
                $('#day').append('<option>0'+i+'</option>>');
            }
            else{
                $('#day').append('<option>'+i+'</option>>');
            }
        }
    };
    $('#year').change(timeHandler);
    $('#month').change(timeHandler);
}

/**
 * 判断是否为闰年
 * @param year
 * @returns {boolean}
 */
function isLeapYear(year) {
    return ((year%4==0&&year%100!=0)||year%400==0);
}

/**
 * 用户参与活动
 */
function joinActivity(btn,userId,activityId,time){
    //数据预处理
    var people = $(btn).parent().prev().children("h4.h4_num");
    var signed = $(people[0]).text();
    var num = parseInt($(people[1]).text());
    var timestamp = Math.round(new Date().getTime() / 1000);
    if($(btn).text()=='参与') {
        if (num == signed) {
            alert('抱歉~该活动人数已满');
            return;
        }
        if (time < timestamp) {
            alert('抱歉~该活动已结束');
            return;
        }
        //传输数据
        $.ajax({
            type: 'POST',
            url: '/relax/public/ajax/activity/attend',
            data: {
                'userId': userId,
                'activityId': activityId
            },
            dataType: 'json',
            success: function (data) {
                alert(data.msg);
                $(people[0]).text(parseInt(signed) + 1);
                $(btn).removeClass('btn-primary');
                $(btn).addClass('btn-warning');
                $(btn).text('取消参与');
            },
            error: function (xhr, type) {
                alert(xhr.status);
                alert(xhr.readyState);
                alert(type);
            }
        });
    }
    //取消参与
    else{
        if(time < timestamp){
            alert('抱歉~该活动已结束');
            return;
        }
        //传输数据
        $.ajax({
            type: 'POST',
            url: '/relax/public/ajax/activity/cancel',
            data: {
                'userId': userId,
                'activityId': activityId
            },
            dataType: 'json',
            success: function (data) {
                alert(data.msg);
                $(people[0]).text(parseInt(signed) - 1);
                $(btn).removeClass('btn-warning');
                $(btn).addClass('btn-primary');
                $(btn).text('参与');
            },
            error: function (xhr, type) {
                alert(xhr.status);
                alert(xhr.readyState);
                alert(type);
            }
        });
    }
}

// /**
//  * 刷新热门活动
//  */
// function refreshHot() {
//     var success=function (data) {
//         window.location="/relax/public/admin/activity/start";
//     };
//     //传输数据
//     $.ajax({
//         type: 'GET',
//         url: '/relax/public/ajax/hotActivities',
//         dataType: 'json',
//         success: success,
//         error: function (xhr, type) {
//             alert(xhr.status);
//             alert(xhr.readyState);
//             alert(type);
//         }
//     });
// }

/**
 * 展示ppt
 */
function showPPt() {
    var box =new PPTBox();
    box.width = 960; //宽度
    box.height = 430;//高度
    box.autoplayer = 3;//自动播放间隔时间
    //box.add({"url":"图片地址","title":"悬浮标题","href":"链接地址"})
    box.add({"url":"/relax/public/uploads/hot/0.jpg","href":"#","title":"悬浮提示标题1"});
    box.add({"url":"/relax/public/uploads/hot/1.jpg","href":"#","title":"悬浮提示标题2"});
    box.add({"url":"/relax/public/uploads/hot/2.jpg","href":"#","title":"悬浮提示标题3"});
    box.add({"url":"/relax/public/uploads/hot/3.jpg","href":"#","title":"悬浮提示标题4"});
    box.add({"url":"/relax/public/uploads/hot/4.jpg","href":"#","title":"悬浮提示标题3"});
    box.add({"url":"/relax/public/uploads/hot/5.jpg","href":"#","title":"悬浮提示标题4"});
    box.show();
}
