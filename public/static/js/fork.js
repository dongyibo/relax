/**
 * 关注用户
 */
function forkUser(myId,forkId) {
    //alert(myId+" "+forkId);
    var success=function (data) {
        alert(data.msg);
        if(data.success){
            appendFriend(myId,forkId,data.avatar,data.name);
        }
    };
    $.ajax({
        type: 'POST',
        url: '/relax/public/ajax/fork',
        data: {
            'userId' : myId,
            'friendId':forkId
        },
        dataType: 'json',
        success: success,
        error: function(xhr, type){
            alert('Ajax error!')
        }
    });
}


/**
 * 关注热门用户
 */
function forkHotUser(myId,forkId) {
    //alert(myId+" "+forkId);
    var success=function (data) {
        alert(data.msg);
    };
    $.ajax({
        type: 'POST',
        url: '/relax/public/ajax/fork',
        data: {
            'userId' : myId,
            'friendId':forkId
        },
        dataType: 'json',
        success: success,
        error: function(xhr, type){
            alert('Ajax error!')
        }
    });
}

