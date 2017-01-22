$(document).ready(function() {
    //初始化图表
    initMyChart();
    //上传数据面板的展示和收起
    switchUploadPanel();
    //处理时间先后
    handleTimeOrder();
    //预处理
    timeHandler();
    //alert(window.error_flag);
});

//window.error_flag=false;

/**
 * 时间处理细节
 */
var timeHandler=function () {
    var sh=parseInt($('#start_hour').val());
    var sm=parseInt($('#start_minute').val());
    var ss=parseInt($('#start_second').val());
    var eh=parseInt($('#end_hour').val());
    var em=parseInt($('#end_minute').val());
    var es=parseInt($('#end_second').val());
    var lower=sh*10000+sm*100+ss;
    var upper=eh*10000+em*100+es;
    //alert(lower+" "+upper);
    if(upper<=lower){
        $('#time_error').text('结束时间早于开始时间');
    }
    else{
        $('#time_error').text('');
    }
};

/**
 * 添加时间有晚于已有的最晚的结束时间
 */
var timeAfterAlready=function () {
    // timeHandler();
    var children=$('#tbody').children();
    var last=$(children[$(children).length-1]);
    var endChildren=$(last).children();
    var lastChild=$(endChildren[1]);
    var end=$(lastChild).text();
    var sh=parseInt($('#start_hour').val());
    var sm=parseInt($('#start_minute').val());
    var ss=parseInt($('#start_second').val());
    var split=end.split(':');
    var lower=parseInt(split[0])*10000+parseInt(split[1])*100+parseInt(split[2]);
    var upper=sh*10000+sm*100+ss;
    if(upper<lower){
        $('#time_fail').text('与记录中的时间段重叠');
        //window.error_flag=true;
    }
    else{
        $('#time_fail').text('');
        //window.error_flag=false;
    }


};

/**
 * 时间处理函数
 */
var timeFunction = function () {
    timeHandler();
    timeAfterAlready();
}

/**
 * 处理时间先后顺序
 */
function handleTimeOrder() {
    $('#start_hour').change(timeFunction);
    $('#start_minute').change(timeFunction);
    $('#start_second').change(timeFunction);
    $('#end_hour').change(timeFunction);
    $('#end_minute').change(timeFunction);
    $('#end_second').change(timeFunction);
}

/**
 * 上传运动数据
 */
function uploadSportData() {
    timeFunction();
    if($('#time_fail').text()==''&&$('#time_error').text()==''){
        document.sport_form.submit();
    }
}

/**
 * 上传面板显示
 */
var uploadEvent=function () {
    if($('#upload_btn').text()=='上传'){
        $('#upload_btn').text('收起');
        $('#upload_btn').removeClass('btn-primary');
        $('#upload_btn').addClass('btn-warning');
        //显示上传数据面板
        $('#form_upload_div_row').css('display','block');
    }
    else{
        $('#upload_btn').text('上传');
        $('#upload_btn').removeClass('btn-warning');
        $('#upload_btn').addClass('btn-primary');
        //显示上传数据面板
        $('#form_upload_div_row').css('display','none');
    }
};

/**
 * 上传数据面板的展示和收起
 */
function switchUploadPanel() {
    $('#upload_btn').click(uploadEvent);
}

/**
 * 初始化图表
 */
function initMyChart(){
    var id=window.currentId;
    var success=function (data) {
        var myChart=echarts.init(document.getElementById('my_chart'));
        var date = [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23];
        var re = [];
        for(var i=0;i<24;i++){
            if(i<10){
                re[i]=data['0'+i.toString()];
            }
            else{
                re[i]=data[i.toString()];
            }
        }


        option = {
            tooltip: {
                trigger: 'axis',
                position: function (pt) {
                    return [pt[0], '10%'];
                }
            },
            title: {
                left: 'center',
                text: '每日分时刻运动距离统计',
            },
            xAxis: {
                type: 'category',
                boundaryGap: false,
                data: date
            },
            yAxis: {
                type: 'value',
                boundaryGap: [0, '100%'],
                name : '距离/m'
            },
            series: [
                {
                    name:'距离',
                    type:'line',
                    smooth:true,
                    symbol: 'none',
                    sampling: 'average',
                    itemStyle: {
                        normal: {
                            color: 'rgb(255, 70, 131)'
                        }
                    },
                    areaStyle: {
                        normal: {
                            color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                                offset: 0,
                                color: 'rgb(255, 158, 68)'
                            }, {
                                offset: 1,
                                color: 'rgb(255, 70, 131)'
                            }])
                        }
                    },
                    data: re
                }
            ]
        };
        // 使用刚指定的配置项和数据显示图表。
        myChart.setOption(option);
    };
    $.ajax({
        type: 'GET',
        url: '/relax/public/ajax/userPerDay/'+id,
        dataType: 'json',
        success: success,
        error: function (xhr, type) {
            alert(xhr.status);
            alert(xhr.readyState);
            alert(type);
        }
    });
}
