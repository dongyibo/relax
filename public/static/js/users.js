$(document).ready(function() {

});/**
 * Created by 董轶波 on 2016/10/19 0019.
 */

/**
 * 删除用户
 */
function deleteUser(id){
    if(confirm('确定删除该用户吗？')){
        window.location='/relax/public/admin/user/delete/'+id;
    }
}