$(document).ready(function () {
    //展现评论区
    showComment();
    //关闭评论区
    closeComment();
});

/**
 * 展现评论区
 */
function showComment() {
    $('.comment_btn').click(function () {
        var parent = $(this).parent();
        var comment = $(parent).next().next().next();
        $(comment).css('display', 'block');
    });
}

/**
 * 关闭评论区
 */
function closeComment() {
    $('.close_btn').click(function () {
        var parent = $(this).parent().parent();
        //var comment=$(parent).siblings('.comment_area');
        // var t=$(parent).find("textarea")[0].val();
        //alert(t);
        $(parent).css('display', 'none');

    });
}

/**
 * 将关注的用户放在好友列表
 */
function appendFriend(myId, friendId, portrait, name) {
    //alert(avatar);
    var path = "";
    if (portrait) {
        path = '/relax/public/uploads/avatar/' + portrait;
    }
    else {
        path = '/relax/public/static/images/my/temp.png';
    }
    var detail = '/relax/public/user/' + friendId;
    var cancel = 'cancelFork(' + myId + ',' + friendId + ',this);';
    var cancel_img = '/relax/public/static/images/my/friend/delete.png';
    var node = '<li class="list-group-item">' +
        '<div class="row">' +
        '<div class="col-lg-1">' +
        "<img class='friend_list_avatar' src=" + path + ">" +
        '</div>' +
        '<div class="col-lg-6">' +
        '<span>' + name + '</span>' +
        '</div>' +
        '<div class="col-lg-1 col-lg-offset-2">' +
        '<a target="_blank" href=' + detail + '><img class="friend_list_icon" src="/relax/public/static/images/my/friend/detail.png"></a>' +
        '</div>' +
        '<div class="col-lg-1">' +
        "<input class='friend_list_icon' onclick=" + cancel + " type='image' src=" + cancel_img + ">" +
        '</div>' +
        '</div>' +
        '</li>';
    $('#friend_list').append(node);

}

/**
 * 取消关注
 */
function cancelFork(myId, forkId, link) {
    if(!window.confirm("你确定取消关注该用户吗？")){
        return;
    }

    var success = function (data) {
        //alert(link);
        //$(link).parent().parent().parent().remove();
        var del = link.parentNode.parentNode.parentNode;
        var ancestor = document.getElementById('friend_list');
        ancestor.removeChild(del);
    };
    $.ajax({
        type: 'POST',
        url: '/relax/public/ajax/cancelFork',
        data: {
            'userId': myId,
            'friendId': forkId
        },
        dataType: 'json',
        success: success,
        error: function (xhr, type) {
            alert('Ajax error!')
        }
    });
}

/**
 * 添加图片
 */
function addPic() {
    $('#blog_file').click();
}

/**
 * 文件选择
 */
function fileChange() {
    $('#file_path_icon').show();
    var path = $('#blog_file').val();
    var p = path.split("\\");
    $('#file_path').text(p[p.length - 1]);
    // alert(p[p.length-1]);
}

/**
 * 删除文件
 */
function deleteFile() {
    // alert("dada");
    var file = $("#blog_file")
    file.after(file.clone().val(""));
    file.remove();
    $('#file_path_icon').hide();
}

/**
 * 发表评论
 */
function releaseComment(btn, blogId, userId) {
    //alert(blogId);return;
    var parent = $(btn).parent().parent().prev();
    var area = $(parent).find("textarea")[0];
    var comment = $(area).val();
    if (comment == '') {
        return;
    }
    /// alert(comment);return;
    var success = function (data) {
        //插入评论
        var name = data.username;
        var commentId = data.commentId;
        var ancestor = $(parent).parent().prev();
        var colon = ':';
        var path = '/relax/public/static/images/my/friend/close1.png';
        var showFunc = 'showDelete(this,' + userId + ',' + userId + ');';
        var hideFunc = 'hideDelete(this,' + userId + ',' + userId + ');';
        var delFunc = 'deleteComment(this,' + commentId + ');';
        var node = '<div class="row comment_content" onmouseover=' + showFunc + ' onmouseout=' + hideFunc + '>' +
            '<span class="comment_name">' + name + '</span>' +
            '<span class="comment_name_colon"> ' + colon + ' </span>' +
            '<span>' + comment + '</span>' +
            '<a class="delete_span" href="javascript:void(0)"><span><img onclick=' + delFunc + ' src=' + path + '></span></a>' +
            '</div>';
        $(ancestor).append(node);
        //评论区消失
        $(parent).parent().css('display', 'none');
    };
    $.ajax({
        type: 'POST',
        url: '/relax/public/ajax/comment',
        data: {
            'userId': userId,
            'blogId': blogId,
            'content': comment
        },
        dataType: 'json',
        success: success,
        error: function (xhr, type) {
            alert('Ajax error!')
        }
    });
}

/**
 * 显示删除按钮
 */
function showDelete(div, userId, cId) {
    if (userId == cId) {
        var del = $(div).children("a")[0];
        $(del).show();
    }
}

/**
 * 隐藏删除按钮
 */
function hideDelete(div, userId, cId) {
    if (userId == cId) {
        var del = $(div).children("a")[0];
        $(del).hide();
    }
}

/**
 * 删除评论
 * @param btn
 * @param cid
 */
function deleteComment(btn, commentId) {
    var success = function (data) {
        $(btn).parent().parent().parent().remove();
    };
    $.ajax({
        type: 'POST',
        url: '/relax/public/ajax/delComment',
        data: {
            'commentId': commentId
        },
        dataType: 'json',
        success: success,
        error: function (xhr, type) {
            alert('Ajax error!')
        }
    });
}

/**
 * 删除微博
 * @param btn
 * @param blogId
 */
function deleteBlog(btn, blogId) {
    //alert(blogId);return;
    var success = function (data) {
        //alert(data.msg);
        //移除该博客板块
        var parent = $(btn).parent().parent().parent();
        $(parent).next().remove();
        $(parent).remove();
    };
    $.ajax({
        type: 'POST',
        url: '/relax/public/ajax/delBlog',
        data: {
            'blogId': blogId
        },
        dataType: 'json',
        success: success,
        error: function (xhr, type) {
            alert('Ajax error!')
        }
    });
}

/**
 * 点赞和取消
 */
function praise(btn, userId, blogId) {
    var success = function (data) {
        var parent = $(btn).parent().parent().next();
        var nameP = $(parent).parent().next().next();
        //点赞
        if (data.msg == 'support') {
            //alert('点赞');
            //人数加1
            if (data.count == 1) {
                var node = '<h5 class="praise_h5">1</h5>';
                $(parent).append(node);
            }
            else {
                var sub = $(parent).children('h5')[0];
                var num = parseInt($(sub).text());
                $(sub).text(num + 1);
            }
            // 改图片颜色
            $(btn).attr('src',"/relax/public/static/images/my/friend/praise1.png");
            //名字显示
            if (data.count == 1) {
                var node1 = '<h5 class="praise_users">' + data.name + '</h5>';
                var node2 = '<h5 class="praise_users_set">&nbsp;觉得很赞</h5>';
                $(nameP).append(node1, node2);
            }
            else {
                var prepend = '<h5 class="praise_users">' + data.name + '</h5>';
                $(nameP).prepend(prepend);
            }
        }
        //取消赞
        else if (data.msg == 'cancel') {
            //alert('取消');
            //人数减1
            if (data.count == 0) {
                $(parent).empty();
            }
            else {
                var sub2 = $(parent).children('h5')[0];
                var num2 = parseInt($(sub2).text());
                $(sub2).text(num2 - 1);
            }
            // 改图片颜色
            $(btn).attr('src',"/relax/public/static/images/my/friend/praise.png");
            //名字擦去
            if (data.count == 0) {
                $(nameP).empty();
            }
            else {
                var nodes = $(nameP).children("h5.praise_users");
                for (var i in nodes) {
                    if ($(nodes[i]).text() == data.name) {
                        $(nodes[i]).remove();
                        break;
                    }
                }
            }
        }
        else {
        }
    };
    $.ajax({
        type: 'POST',
        url: '/relax/public/ajax/praise',
        data: {
            'blogId': blogId,
            'userId': userId
        },
        dataType: 'json',
        success: success,
        error: function (xhr, type) {
            alert('Ajax error!')
        }
    });

}

/**
 * 显示未读信息
 */
function showInfos(id) {
    $('#info_record_div').show();
    //将看过消息的记录反馈给后台
    var success = function (data) {
        //alert(data.msg);
    };
    $.ajax({
        type: 'POST',
        url: '/relax/public/ajax/info',
        data: {
            'userId': id
        },
        dataType: 'json',
        success: success,
        error: function (xhr, type) {
            alert('Ajax error!')
        }
    });
}

