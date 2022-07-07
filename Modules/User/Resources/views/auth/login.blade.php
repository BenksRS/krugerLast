<x-layouts.guest>
	<div class="row justify-content-center">
		<div class="col-md-8 col-lg-6 col-xl-5">
			<div class="card overflow-hidden">
				<div class="bg-primary bg-dark">
					<div class="row">
						<div class="col-7">
							<div class="text-primary p-4">
{{--								<h5 class="text-primary">Welcome !</h5>--}}
								<p></p>
							</div>
						</div>
						<div class="col-5 align-self-end mt-4 mb-4">
							<img src="{{ themes('images/logo/light/logo-lg.png') }}" alt="" class="img-fluid">
{{--                            http://krugerdev.sys:8080/themes/system/assets/images/logo/light/logo-lg.png--}}
						</div>
					</div>
				</div>
				<div class="card-body pt-0">
					<div class="auth-logo">
						<a href="index.html" class="auth-logo-light">
							<div class="avatar-md profile-user-wid mb-4">
								<span class="avatar-title rounded-circle bg-light">
									<img src="{{ themes('images/logo/dark/logo-sm.png') }}" alt="" class="rounded-circle" height="34">
								</span>
							</div>
						</a>
						<a href="index.html" class="auth-logo-dark">
							<div class="avatar-md profile-user-wid mb-4">
								<span class="avatar-title rounded-circle bg-light">
									<img src="{{ themes('images/logo/dark/logo-sm.png') }}" alt="" class="rounded-circle" height="34">
								</span>
							</div>
						</a>
					</div>
					<div class="p-2 pb-3">

						<x-form route="auth.login" method="POST">
							<div class="mb-3">
								<x-form-input type="email" name="email" label="E-mail" />
							</div>

							<div class="mb-3">
								<x-form-input type="password" name="password" label="Password" />
							</div>

							<div class="form-check">
								<input class="form-check-input" type="checkbox" id="remember-check">
								<label class="form-check-label" for="remember-check"> Remember me </label>
							</div>

							<div class="mt-3 d-grid">
								<x-button value="Log In" />
							</div>
						</x-form>

					</div>
				</div>
			</div>
		</div>
	</div>
</x-layouts.guest>
