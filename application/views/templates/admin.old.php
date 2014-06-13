<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title; ?></title>

    <!-- Bootstrap -->
    <link href="<?php echo base_url(); ?>css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/ihrm.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="<?php echo base_url(); ?>js/html5shiv.js"></script>
      <script src="<?php echo base_url(); ?>js/respond.min.js"></script>
    <![endif]-->
    <link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Armata' rel='stylesheet' type='text/css'>
  </head>
  <body class="admin">

    <div class="container">

      <div class="row logged-in-as rounded-bottom-corners">
        <div class="col-md-2"><img src="<?= site_url('img/fsnau-logo-transparent.png'); ?>" /></div>
        <div class="col-md-10">Logged in as: <?php echo $this->session->userdata('fullname'); ?></div>
      </div>

      <!-- Logo and name of the application -->
      <div class="row header">
        <div class="col-md-4"><img src="<?php echo base_url(); ?>img/IHRM-Logo.jpg" class="logo" /></div>
        <div class="col-md-8"><?php echo $this->admin_model->menu($current_menu); ?></div>
      </div>
      
      <div class="row app-header-admin">
        <div class="col-md-12">HR Mentorship Programme - Administrator Section</div>
      </div>
      
      <div class="row">
        <div class="col-md-8">
          <?php if (!isset($page)) { ?>
          <h2><?php echo $title; ?></h2>
          <?php } else { echo '<p>&nbsp;</p>'; } ?>
          &nbsp;
        </div>
        <div class="col-md-4 search-box">
          <form class="navbar-form navbar-right" role="search" method="get" action="<?= site_url('admin/search'); ?>">
            <div class="form-group">
              <select name="table" id="table" class="form-control">
                <option value="mentors">Mentors</option>
                <option value="mentees">Mentees</option>
              </select>
              <input type="text" name="search_term" id="search_term" class="form-control" value="<?php if (isset($search_term)) { echo $search_term; } ?>" placeholder="Search Applicants">
            </div>
            <input type="submit" class="btn btn-info" value="Search" />
          </form>
        </div>
      </div>

        <!-- Error/notices go here -->
        <!-- // Available error message classes are: warning (yellow); danger (red/pink); success (green); info (light blue) -->
        <?php if (isset($msg)) { ?>
        <div class="alert alert-<?php echo $msg['style']; ?> alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php echo $msg['text']; ?>
        </div>
        <?php } ?>
        <!-- END: Error/notices -->

        <!-- Flashdata -->
        <?php
        $flashdata_message = $this->session->flashdata('message');
        if ($flashdata_message != '') {
        ?>
        <div class="alert alert-<?= $flashdata_message['style']; ?> alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?= $flashdata_message['text']; ?>
        </div>
        <?php } ?>
        <!-- END: Flashdata -->
        
        <!-- Load the view here: start -->
        <div class="content">
          <?php $this->load->view($view); ?>
        </div>
        <!-- Load the view here: start -->
        
      <div class="row footer">Copyright &copy <?php echo date('Y', time()); ?>, Institute of Human Resource Management, All Rights Reserved &#8226; Terms and Conditions</div>

    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="<?php echo base_url(); ?>js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
  </body>
</html>