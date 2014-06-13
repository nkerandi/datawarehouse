<div class="container">
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<div class="text-center logo"><img src="<?= site_url('img/logo.png'); ?>" /></div>
			<div><h1 class="appname text-center">Data Warehouse</h1></div>
			<div class="login-form-container">
				<h4 class="uppercase text-center underlined-heading">Retrieve Forgotten Password</h4>
				<form role="form" method="post" action="<?= site_url('password/forgot'); ?>">
				  <div class="form-group">
				    <label for="email">Provide the email address you signed up with</label>
				    <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email">
				  </div>
				  <input type="submit" class="btn btn-info" value="  Reset my Password  " />
				</form>
				<div><p class="text-right"><a href="<?= site_url('welcome'); ?>">Log In</a></p></div>
			</div>
		</div>
	</div>
</div>