<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title; ?></title>

    <!-- Bootstrap -->
    <link href="<?php echo base_url(); ?>css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/style.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="<?php echo base_url(); ?>js/html5shiv.js"></script>
      <script src="<?php echo base_url(); ?>js/respond.min.js"></script>
    <![endif]-->
    <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed' rel='stylesheet' type='text/css'>
  </head>
  <body>
  
  <!-- BODY CONTAINER STARTS HERE NOW -->
    <div class="container-fluid">

    <!-- NAVBAR (FIXED AT THE TOP) -->
    <!-- Fixed navbar -->
    <div class="row">
      <div class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">FSNAU Data Warehouse</a>
          </div>
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li class="active"><a href="#">Home</a></li>
              <li><a href="#about">About</a></li>
              <li><a href="#contact">Contact</a></li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="#">Action</a></li>
                  <li><a href="#">Another action</a></li>
                  <li><a href="#">Something else here</a></li>
                  <li class="divider"></li>
                  <li class="dropdown-header">Nav header</li>
                  <li><a href="#">Separated link</a></li>
                  <li><a href="#">One more separated link</a></li>
                </ul>
              </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Nicholas Kerandi <b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="#"><span class="glyphicon glyphicon-user smaller fsnau-blue"></span>My Profile</a></li>
                  <li><a href="#"><span class="glyphicon glyphicon-lock smaller fsnau-blue"></span>Change Password</a></li>
                  <li class="divider"></li>
                  <li><a href="#"><span class="glyphicon glyphicon-log-out smaller fsnau-blue"></span>Log Out</a></li>
                </ul>
              </li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

      <!-- TOP BAR -->
      <div class="row topbar">
          <div class="container">
            <div class="col-md-2"><img src="<?= site_url('img/fsnau-logo-transparent.png'); ?>" class="logo" /></div>
            <div class="col-md-10">
              <small class="pull-right">
                <?php
                $fullname = trim($this->session->userdata('fullname'));
                if ($fullname != '') { echo $fullname; }  else { echo 'You are not logged in'; }
                ?>
              </small>
            </div>
          </div>
      </div>  <!-- End: div.topbar -->

      <!-- MAIN CONTENT -->
      <div class="row white content">
        <!-- LOAD PAGE SPECIFIC VIEW HERE: START -->
        <?php $this->load->view($view); ?>
        <!-- LOAD PAGE SPECIFIC VIEW HERE: START -->
      </div>
      
      <!-- FOOTER / COPYRIGHT -->
      <div class="container footer">
        <!-- Copyright -->
        <div class="row">
          <div class="col-md-12">
            <p class="text-center">
              <small>
                Copyright &copy <?php echo date('Y', time()); ?>, Food Security and Nutrition Analysis Unit (FSNAU), All Rights Reserved &#8226; Terms and Conditions
              </small>
            </p>
          </div> <!-- End: div.col-md-12 -->          
        </div>
      </div> <!-- End: div.container -->

    </div> <!-- End: div.container-fluid -->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="<?php echo base_url(); ?>js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
  </body>
</html>