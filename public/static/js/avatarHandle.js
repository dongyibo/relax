$(document).ready(function() {
    //上传头像
    uploadImage();
    //头像提示信息
    promptHead();
});

/**
 * 选择图片，上传头像
 */
function  uploadImage() {
    //头像事件
    eventUtil.addHandler(head,'click',function () {
        $('#form_file').click();
    });

}

/**
 * 头像提示信息
 */
function promptHead(){
    eventUtil.addHandler(head,'mouseover',function () {
        //显示提示信息
        $('#prompt_head').addClass('border_show');
        $('#prompt_head_span').text('点击头像可更换');
    });
    eventUtil.addHandler(head,'mouseout',function () {
        //隐藏提示信息
        $('#prompt_head').removeClass('border_show');
        $('#prompt_head_span').text('');
    });
}

/**
 * 文件选择后触发次函数，来上传头像（ajax）
 */
function fileSelected() {
    var options = {
        success:function (response) {
            if(response.success == false) {
                alert(response.error);
            }
            else{
                //alert(response.avatar);
                head.src='/relax/public/'+response.avatar;
            }
        },
        error:function () {
            alert('wrong');
        },
        dataType: 'json'
    };
    //提交
    $('#upload').ajaxForm(options).submit();

}
