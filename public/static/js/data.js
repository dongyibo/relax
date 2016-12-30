var edit=function () {
    $('.input_data').removeAttr("readonly");
    $('.input_radio_data').removeAttr('disabled');
    $('#check_btn_div').css('display','none');
    $('#edit_btn_div').css('display','block');
};

var resetPWD=function () {
    if($('#pwd_btn').hasClass('active')){
        return false;
    }
    else{
        $('#pwd_btn').addClass('active');
        $('#data_btn').removeClass('active');
        $('#info_div').css('display','none');
        $('#password_div').css('display','block');
    }
};

var diff_flag=false;

$(document).ready(function() {
    //个人信息与重置密码切换
    switchArea();
    //个人信息面板编辑与展示的切换
    dataPanelDetail();
    //用户名更改时异步处理，避免重复
    handleUsername();
    //处理两次密码不同
    handlePwdDifferent();
    //处理新旧密码一样
    handlePwdSame();
});

/**
 * 个人信息与重置密码切换
 */
function switchArea() {
    //个人信息按钮
    $('#data_btn').click(function () {
        if($(this).hasClass('active')){
            return false;
        }
        else{
            $(this).addClass('active');
            $('#pwd_btn').removeClass('active');
            $('#password_div').css('display','none');
            $('#info_div').css('display','block');
        }
    });
    //重置密码按钮
    $('#pwd_btn').click(resetPWD);
}

/**
 * 个人信息面板编辑与展示的切换
 */
function dataPanelDetail() {
    $('#edit_btn').click(edit);

}

/**
 * 恢复信息
 * @param id
 */
function restoreData(id) {
    //清空所有错误提示
    $('.text-danger').text('');
    var username='';
    var email='';
    var age='';
    var sex='';
    var height='';
    var weight='';
    //还原数据 ajax
    var success=function (data) {
        $('#edit_btn_div').css('display','none');
        $('#check_btn_div').css('display','block');
        username=data.username;
        email=data.email;
        age=data.age;
        sex=data.sex;
        height=data.height;
        weight=data.weight;
        $('#username').val(username);
        $('#email').val(email);
        $('#age').val(age);
        if(sex=='男'){
            $('#radio_woman').removeAttr("checked");
            $('#radio_man').attr("checked","checked");
            $('#radio_man').click();
        }
        else{
            $('#radio_man').removeAttr("checked");
            $('#radio_woman').attr("checked","checked");
            $('#radio_woman').click();
        }
        $('#height').val(height);
        $('#weight').val(weight);
        $('.input_data').attr("readonly","readonly");
        $('.input_radio_data').attr("disabled","disabled");
    };
    $.ajax({
        type: 'GET',
        url: '/relax/public/ajax/data/'+id,
        dataType: 'json',
        success: success,
        error: function (xhr, type) {
            alert(xhr.status);
            alert(xhr.readyState);
            alert(type);
        }
    });
}

/**
 * 用户名更改时异步处理，避免重复
 */
function handleUsername(){
    var username=document.getElementById('username');
    //失去焦点事件
    username.onchange=function (event) {
        event = event || window.event;
        //alert("test");
        usernameDetail();
    }
}

/**
 * 修改用户名细节
 */
function usernameDetail(){
    var username=document.getElementById('username');
    var tmp=username.value;
    var nameToJudge=document.getElementById("nameToJudge").value;
    //定义成功后的处理
    var success=function (data) {
        var prompt=document.getElementById('username_repeat');
        if(data.msg=='用户名重复'){
            if(nameToJudge==username.value){
                prompt.innerHTML="";
            }
            else{
                prompt.innerHTML="sorry~用户名 "+tmp+" 已被使用";
                username.value="";
            }
        }
        else if(data.msg=='用户名唯一'){
            prompt.innerHTML="";
        }
        else{}
    };
    //开始异步传输
    $.ajax({
        type: 'POST',
        url: '/relax/public/ajax/register',
        data: {
            'username' : username.value},
        dataType: 'json',
        success: success,
        error: function(xhr, type){
            alert('error!!!')
        }
    });
}

/**
 * 提交修改信息
 */
function submitModifyData() {
    var username=document.getElementById('username');
    var tmp=username.value;
    var nameToJudge=document.getElementById("nameToJudge").value;
    //定义成功后的处理
    var success=function (data) {
        var prompt=document.getElementById('username_repeat');
        if(data.msg=='用户名重复'){
            if(nameToJudge==username.value){
                prompt.innerHTML="";
                document.modifyData_form.submit();
            }
            else{
                prompt.innerHTML="sorry~用户名 "+tmp+" 已被使用";
                username.value="";
            }
        }
        else if(data.msg=='用户名唯一'){
            prompt.innerHTML="";
            document.modifyData_form.submit();
        }
        else{}
    };
    //开始异步传输
    $.ajax({
        type: 'POST',
        url: '/relax/public/ajax/register',
        data: {
            'username' : username.value},
        dataType: 'json',
        success: success,
        error: function(xhr, type){
            alert('error!!!')
        }
    });
}

/**
 * 处理两次密码输入不同
 */
function handlePwdDifferent() {
    var newPWD=document.getElementById('new_password');
    var againPWD=document.getElementById('again_password');
    var againPrompt=document.getElementById('again_pwd_prompt');
    againPWD.onkeyup=function () {
        if(this.value!=newPWD.value&&this.value!=''){
            againPrompt.innerHTML='两次密码不一样';
            diff_flag=true;
        }
        else{
            againPrompt.innerHTML='';
            diff_flag=false;
        }
    }

    newPWD.onkeyup=function () {
        if(this.value!=againPWD.value&&this.value!=''){
            againPrompt.innerHTML='两次密码不一样';
            diff_flag=true;
        }
        else{
            againPrompt.innerHTML='';
            diff_flag=false;
        }
    }
}

/**
 * 根据密码是否一致行动
 */
function confirmPwd(id) {
    if(!diff_flag){
        document.password_form.submit();
    }
}

/**
 * 处理新旧密码一样
 */
function handlePwdSame() {
    var oldPWD=document.getElementById('old_password');
    var newPWD=document.getElementById('new_password');
    var prompt=document.getElementById('new_pwd_prompt');
    newPWD.onchange=function () {
        if(this.value==oldPWD.value&&this.value!=''){
            prompt.innerHTML='新密码和原密码一样';
            this.value='';
        }
        else{
            prompt.innerHTML='';
        }
    };

    oldPWD.onchange=function () {
        if(this.value==newPWD.value&&this.value!=''){
            prompt.innerHTML='新密码和原密码一样';
            newPWD.value='';
        }
        else{
            prompt.innerHTML='';
        }
    };
}