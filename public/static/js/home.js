// 全局变量
var current_item = 0;


$(document).ready(function() {
	//导航栏事件处理
	handleNavigation();
	//主按钮事件处理
	handleButton();
    //用户名注册时异步处理
    handleUsername();
	//进入首页判断cookie用户名
	//judgeUsername();
});

/**
 * 导航栏事件处理
 */
function handleNavigation() {
	$("a", '.mainmenu').click(function() {
		//alert('dsadasd');
		if( ! $(this).hasClass('active') ) {
			current_item = this;
			// 根据按钮显示内容
			if($(current_item).attr('id')=='login_link'){
				$('.section#head').hide();
				$('#register').hide();
				$('#login').show();
			}
			else if($(current_item).attr('id')=='register_link'){
				$('.section#head').hide();
				$('#login').hide();
				$('#register').show();
			}
			else if($(current_item).attr('id')=='back_link'){
				$('#login').hide();
				$('#register').hide();
				$('.section#head').show();
			}
			else{}
			$('a', '.mainmenu').removeClass( 'active' );
			$(current_item).addClass( 'active' );
		}

		return false;
	});
}

/**
 * 显示注册面板
 */
function showRegister() {
    $('#login').hide();
    $('#register').show();
}

/**
 * 主按钮时间处理
 */
function handleButton() {
	$('.btn').click(function () {
		//alert('dasdas');
		if($(this).attr('id')=='login_btn'){
			$('.section#head').hide()
			$('#register').hide();
			$('#login').show();
		}
		else if($(this).attr('id')=='register_btn'){
			$('.section#head').hide();
			$('#login').hide();
			$('#register').show();
		}
		else{}
		$('a', '.mainmenu').removeClass( 'active' );
	});
}

/**
 * 用户名注册时异步处理，避免重复
 */
function handleUsername(){
    var username=document.getElementById('form-username');
    //失去焦点事件
    username.onchange=function (event) {
        event = event || window.event;
        //alert(username.value);
        //定义成功后的处理
        var success=function (data) {
            var prompt=document.getElementById('username_repeat');
            if(data.msg=='用户名重复'){
                prompt.innerHTML="sorry~用户名 "+username.value+" 已被注册";
                username.value="";
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
                alert('Ajax error!')
            }
        });

    }
}

//提交注册信息
function submitRegister() {
	var username=document.getElementById('form-username');
	var success=function (data) {
		var prompt=document.getElementById('username_repeat');
		if(data.msg=='用户名重复'){
			prompt.innerHTML="sorry~用户名 "+username.value+" 已被注册";
			username.value="";
		}
		else if(data.msg=='用户名唯一'){
			prompt.innerHTML="";
			document.register_form.submit();
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
			alert('Ajax error!')
		}
	});
}
