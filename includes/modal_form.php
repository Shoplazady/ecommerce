<!--------------login modal------------------>
<div id="modalSignin" class="modal fade">
	<div class="modal-dialog mb-2 p-2">
		<div class="modal-content">
			<div class="modal-header text-center">
				<button class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span>
				</button>
				<h2 class="modal-title"><i class="bi bi-person-circle"></i> สมาชิกเข้าสู่ระบบ</h2>
				<br>
				<ul class="nav nav-tabs mb-2">
					<li class="nav-item">
						<a class="nav-link active" data-toggle="tab" href="#tab1"><i class="bi bi-door-open"></i> Login</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" data-toggle="tab" href="#tab2"><i class="bi bi-pencil"></i> Register</a>
					</li>
				</ul>
			</div>
			<div class="modal-body text-center">
				<div class="tab-content">
					<div class="tab-pane fade active" id="tab1">

						<form action="verify.php" method="POST">
							<div class="form-group has-feedback">
								<input type="email" class="form-control" name="email" placeholder="Email" required>
								<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
							</div>
							<div class="form-group has-feedback">
								<input type="password" class="form-control" name="password" placeholder="Password" required>
								<span class="glyphicon glyphicon-lock form-control-feedback"></span>
							</div>
							<button type="submit" class="btn btn-success btn-lg" name="login"><i class="bi bi-box-arrow-in-left"></i> เข้าสู่ระบบ</button>
						</form>
						<div class="modal-footer">
							<script>
								function loginWithFacebook() {
									FB.login(function(response) {
										if (response.authResponse) {
											// User is logged in with Facebook
											FB.api('/me', {
												fields: 'id, email, name'
											}, function(response) {
												if (response.error) {
													console.log(response.error);
													return;
												}
												// Send the Facebook login data to the server for processing
												var fbId = response.id;
												var email = response.email;
												var name = response.name;

												var xhr = new XMLHttpRequest();
												xhr.open('POST', 'login_with_facebook.php', true);
												xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
												xhr.onreadystatechange = function() {
													if (xhr.readyState === XMLHttpRequest.DONE) {
														if (xhr.status === 200) {
															var result = JSON.parse(xhr.responseText);
															if (result.success) {
																// Login or registration successful
																window.location.reload();
															} else {
																console.log(result.message);
															}
														} else {
															console.log('Request failed with status ' + xhr.status);
														}
													}
												};
												xhr.send('fb_id=' + fbId + '&email=' + email + '&name=' + name);
											});
										} else {
											console.log('User cancelled login or did not fully authorize.');
										}
									}, {
										scope: 'public_profile,email'
									});
								}

								// Load the Facebook SDK asynchronously
								window.fbAsyncInit = function() {
									FB.init({
										appId: '608963957965080',
										cookie: true,
										xfbml: true,
										version: 'v17.0'
									});
								};

								(function(d, s, id) {
									var js, fjs = d.getElementsByTagName(s)[0];
									if (d.getElementById(id)) return;
									js = d.createElement(s);
									js.id = id;
									js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v17.0&appId=608963957965080&autoLogAppEvents=1';
									fjs.parentNode.insertBefore(js, fjs);
								})(document, 'script', 'facebook-jssdk');
							</script>
							
							<center>
								<h4><i class="bi bi-caret-down-fill"></i> หรือล็อกอินด้วย <i class="bi bi-caret-down-fill"></i></h4>
								<br>
								<button class="btn btn-primary btn-lg" onclick="loginWithFacebook()"><i class="bi bi-facebook"></i> Login with Facebook</button>
							</center>
						</div>
					</div>
					<div class="tab-pane fade" id="tab2">

						<form action="register.php" method="POST">
							<div class="form-group has-feedback">
								<input type="text" class="form-control" name="firstname" placeholder="Firstname" value="<?php echo (isset($_SESSION['firstname'])) ? $_SESSION['firstname'] : '' ?>" required>
								<span class="glyphicon glyphicon-user form-control-feedback"></span>
							</div>
							<div class="form-group has-feedback">
								<input type="text" class="form-control" name="lastname" placeholder="Lastname" value="<?php echo (isset($_SESSION['lastname'])) ? $_SESSION['lastname'] : '' ?>" required>
								<span class="glyphicon glyphicon-user form-control-feedback"></span>
							</div>
							<div class="form-group has-feedback">
								<input type="email" class="form-control" name="email" placeholder="Email" value="<?php echo (isset($_SESSION['email'])) ? $_SESSION['email'] : '' ?>" required>
								<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
							</div>
							<div class="form-group has-feedback">
								<input type="password" class="form-control" name="password" placeholder="Password" required>
								<span class="glyphicon glyphicon-lock form-control-feedback"></span>
							</div>
							<div class="form-group has-feedback">
								<input type="password" class="form-control" name="repassword" placeholder="Retype password" required>
								<span class="glyphicon glyphicon-log-in form-control-feedback"></span>
							</div>
							<hr>
							<center><button type="submit" class="btn btn-warning btn-lg" name="signup"><i class="fa fa-pencil"></i> สมัครสมาชิก</button></center>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>