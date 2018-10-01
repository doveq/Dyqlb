<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>haowu.in</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/admin.css">
    <script src="/js/jquery-3.3.1.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container-fluid">

    <div class="row">
        <div class="col-md-4 offset-md-4" style="margin-top: 8rem;">
            <form>
                <div class="form-group">
                    <input type="text" id="inputName" class="form-control" placeholder="用户名" required autofocus>
                </div>
                <div class="form-group">
                    <input type="password" id="inputPassword" class="form-control" placeholder="密码" required>
                </div>
                <button class="btn btn-primary btn-block" type="submit">登 录</button>
            </form>
        </div>
    </div>

</div>
</body>
</html>
