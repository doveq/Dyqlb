/**
 * 登录注册验证回调
*/
$("#login-modal .form-submit").on('click', function (e) {

    var email = $("#index-login-form input[name='email']");
    var emailVal = email.val();

    var passwd = $("#index-login-form input[name='passwd']");
    var passwdVal = passwd.val();

    var divAlert = $("#index-login-form .alert");
    divAlert.hide();

    var errors = "";

    var mailReg = /^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/;
    if (mailReg.length < 3 || !mailReg.test(emailVal))
        errors += "<p>邮箱地址错误</p>";

    if (passwdVal.length < 6)
        errors += "<p>密码最少6个任意字符</p>";

    if (errors.length > 0) {
        divAlert.html(errors);
        divAlert.show();
        return false;
    }

    /* 人机验证回调 */
    var captcha = new TencentCaptcha('2063899576', function(res) {
        var url = $("#index-login-form").attr('action');
        var postData = {};
        postData.email = emailVal;
        postData.passwd = passwdVal;
        postData.randstr = res.randstr;
        postData.ticket = res.ticket;

        $.ajax({
            type: "POST",
            url: url,
            data: postData,
            dataType: "json",
            success: function(data) {
                if (data.status == 1) {
                    window.location.reload();
                } else {
                    var errors = "";
                    if (data.errors instanceof Array) {
                        for(var i = 0, j = data.errors.length; i < j; i++) {
                            errors += "<p>"+ data.errors[i] +"</p>";
                        }
                    } else
                        errors = data.errors;

                    var divAlert = $("#index-login-form .alert");
                    divAlert.html(errors);
                    divAlert.show();
                }
            }
        });

    });

    captcha.show();

    return false;
});

$("#register-modal .form-submit").on('click', function (e) {

    var email = $("#index-register-form input[name='email']");
    var emailVal = email.val();

    var passwd = $("#index-register-form input[name='passwd']");
    var passwdVal = passwd.val();

    var repasswd = $("#index-register-form input[name='repasswd']");
    var repasswdVal = repasswd.val();

    var divAlert = $("#index-register-form .alert");
    divAlert.hide();

    var errors = "";

    var mailReg = /^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/;
    if (mailReg.length < 3 || !mailReg.test(emailVal))
        errors += "<p>邮箱地址错误</p>";

    if (passwdVal.length < 6)
        errors += "<p>密码最少6个任意字符</p>";

    if (passwdVal !== repasswdVal)
        errors += "<p>二次密码不匹配</p>";

    if (errors.length > 0) {
        divAlert.html(errors);
        divAlert.show();
        return false;
    }

    /* 人机验证回调 */
    var captcha = new TencentCaptcha('2063899576', function(res) {

        var url = $("#index-register-form").attr('action');
        var postData = {};
        postData.email = emailVal;
        postData.passwd = passwdVal;
        postData.passwd_confirmation = repasswdVal;
        postData.randstr = res.randstr;
        postData.ticket = res.ticket;

        $.ajax({
            type: "POST",
            url: url,
            data: postData,
            dataType: "json",
            success: function(data) {
                if (data.status == 1) {
                    alert("注册成功");
                    window.location.reload();
                } else {
                    var errors = "";
                    if (data.errors instanceof Array) {
                        for(var i = 0, j = data.errors.length; i < j; i++) {
                            errors += "<p>"+ data.errors[i] +"</p>";
                        }
                    } else
                        errors = data.errors;

                    var divAlert = $("#index-register-form .alert");
                    divAlert.html(errors);
                    divAlert.show();
                }
            }
        });
    });

    captcha.show();

    return false;
});


function addFavorite(id) {
    var postData = {};
    postData.id = id;

    $.ajax({
        type: "POST",
        url: favoriteUrl,
        data: postData,
        dataType: "json",
        success: function(data) {
            if (data.status == -10) {
                $('#login-modal').modal('show');
            } else {
                alert("添加到收藏夹成功");
            }
        }
    });
}

$(".card-add-favorite").on("click", function (e) {
    var id = $(this).parents(".index-card").data("id");
    addFavorite(id);
});

function switchToLogin() {
    $('#register-modal').modal('hide');
    $('#login-modal').modal('show');
}

function switchToRegister() {
    $('#login-modal').modal('hide');
    $('#register-modal').modal('show');
}
