<div class="container">
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<div class="text-center logo"><img src="<?= site_url('img/logo.png'); ?>" /></div>
			<div><h1 class="appname text-center">Data Warehouse</h1></div>
			<div class="login-form-container">
				<form role="form" method="post" action="<?= site_url('login'); ?>">
				  <div class="form-group">
				    <label for="email">Email address</label>
				    <input type="email" name="email" class="form-control" id="email" placeholder="Enter email">
				  </div>
				  <div class="form-group">
				    <label for="password">Password</label>
				    <input type="password" name="password" class="form-control" id="password" placeholder="Password">
				  </div>
				  <input type="submit" class="btn btn-info" value="  Log In  " />
				</form>
				<div><p class="text-right"><a href="<?= site_url('password/forgot'); ?>">Forgot Your Password?</a><br/>Not registered? <a href="<?= site_url('signup'); ?>">Sign Up</a></p></div>
			</div>
		</div>
	</div>
</div>