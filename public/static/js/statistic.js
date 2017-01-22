$(document).ready(function () {
    //初始化性别图表
    initSexChart();
    //初始化用户个人运动距离图表
    initDistance(window.dataId);
});

function initSexChart() {
    var success = function (data) {
        var sexChart = echarts.init(document.getElementById('sex_chart'));
        option = {
            // title : {
            //     text: '某站点用户访问来源',
            //     subtext: '纯属虚构',
            //     x:'center'
            // },
            tooltip: {
                trigger: 'item',
                formatter: "{a} <br/>{b} : {c} ({d}%)"
            },
            legend: {
                orient: 'vertical',
                left: 'right',
                data: ['男', '女']
            },
            series: [
                {
                    name: '人数',
                    type: 'pie',
                    radius: '55%',
                    center: ['50%', '60%'],
                    data: [
                        {value: data.woman, name: '女'},
                        {value: data.man, name: '男'}
                    ],
                    itemStyle: {
                        emphasis: {
                            shadowBlur: 10,
                            shadowOffsetX: 0,
                            shadowColor: 'rgba(0, 0, 0, 0.5)'
                        }
                    }
                }
            ]
        };
        sexChart.setOption(option);
    };
    $.ajax({
        type: 'GET',
        url: '/relax/public/ajax/sex',
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
 * 初始化用户个人运动距离图表
 */
function initDistance(id) {
    var xAxis = "";
    var year = $('#year_data').val();
    var month = $('#month_data').val();
    if (month < 10) {
        month = '0' + month;
    }
    //alert(year+" "+month);
    var success = function (data) {
        //alert(data);
        var myChart = echarts.init(document.getElementById('self_chart'));
        var date = [];
        var res = [];
        var count = 1;
        for (var i in data) {
            date.push(count);
            if (count < 10) {
                res.push(data['0' + count.toString()]);
            }
            else {
                res.push(data[count.toString()]);
            }
            count++;
        }

        option = {
            tooltip: {
                trigger: 'axis',
                position: function (pt) {
                    return [pt[0], '10%'];
                }
            },
            xAxis: {
                type: 'category',
                boundaryGap: false,
                data: date,
                name: xAxis
            },
            yAxis: {
                type: 'value',
                boundaryGap: [0, '100%'],
                name: '距离/m'
            },
            series: [
                {
                    name: '距离',
                    type: 'line',
                    smooth: true,
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
                    data: res
                }
            ]
        };
        // 使用刚指定的配置项和数据显示图表。
        myChart.setOption(option);
    };
    if (month > 0) {
        xAxis = "日期/天";
        $.ajax({
            type: 'GET',
            url: '/relax/public/ajax/sport/' + id + '/' + year + '/' + month,
            dataType: 'json',
            success: success,
            error: function (xhr, type) {
                alert(xhr.status);
                alert(xhr.readyState);
                alert(type);
            }
        });
    }
    else {
        xAxis = "日期/月";
        $.ajax({
            type: 'GET',
            url: '/relax/public/ajax/sport/' + id + '/' + year,
            dataType: 'json',
            success: success,
            error: function (xhr, type) {
                alert(xhr.status);
                alert(xhr.readyState);
                alert(type);
            }
        });
    }

}
