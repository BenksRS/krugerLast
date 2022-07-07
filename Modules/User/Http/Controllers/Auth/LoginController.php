<?php

namespace Modules\User\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\User\Entities\User;
use Modules\User\Http\Requests\Auth\LoginRequest;

class LoginController extends Controller {

	use AuthenticatesUsers;

	/**
	 * Where to redirect users after login / registration.
	 *
	 * @var string
	 */
	public $redirectTo = '/';

	/**
	 * @var User
	 */
	protected $user;

	/**
	 * @param User $user
	 */
	public function __construct (User $user)
	{
		$this->user = $user;
		$this->middleware('guest:user')->except('logout');
	}

	public function index ()
	{
		return view('user::auth.login');
	}

	public function login (LoginRequest $request)
	{

		if ( $this->hasTooManyLoginAttempts($request) ) {
			$this->fireLockoutEvent($request);
			$this->sendLockoutResponse($request);
		}

		if ( $this->attemptLogin($request) ) {
			return $this->sendLoginResponse($request);
		}
		$this->incrementLoginAttempts($request);

		return $this->sendFailedLoginResponse($request);
	}

	protected function guard ()
	{
		return Auth::guard('user');
	}

}
