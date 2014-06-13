<!DOCTYPE html>
<html class="bg-fsnau-blue">
    <head>
        <meta charset="UTF-8">
        <title>FSNAU Data Warehouse | Log in</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="<?= site_url('css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="<?= site_url('css/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="<?= site_url('css/style.css'); ?>" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="<?= site_url('js/html5shiv.js'); ?>"></script>
          <script src="<?= site_url('js/respond.min.js'); ?>"></script>
        <![endif]-->
    </head>
    <body class="bg-fsnau-bg">

        <div class="form-box" id="login-box">
        	<div class="logo"><img src="<?= site_url('img/fsnau-logo-white.png'); ?>" /></div>
            <div class="header">Sign In</div>
            <form action="<?= site_url('login'); ?>" method="post">
                <div class="body bg-gray">
                    <div class="form-group">
                        <input type="text" name="email" class="form-control" placeholder="Email Address"/>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="Password"/>
                    </div>
                </div>
                <div class="footer">
                    <button type="submit" class="btn btn-info btn-block">Sign me in</button>  
                    
                    <p><a href="<?= site_url('password/forgot'); ?>">I forgot my password</a></p>
                    
                    <a href="<?= site_url('account/signup'); ?>" class="text-center">Signup for a new account</a>
                </div>
            </form>

            <div class="margin text-center">
                <span>Sign in using social networks</span>
                <br/>
                <button class="btn bg-light-blue btn-circle"><i class="fa fa-facebook"></i></button>
                <button class="btn bg-aqua btn-circle"><i class="fa fa-twitter"></i></button>
                <button class="btn bg-red btn-circle"><i class="fa fa-google-plus"></i></button>

            </div>
        </div>


        <!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="<?= site_url('js/bootstrap.min.js'); ?>" type="text/javascript"></script>        

    </body>
</html>