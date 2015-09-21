<?php

class AuthController extends BaseController {

  /**
   * Display the login page
   * @return View
   */
  public function getLogin()
  {
    return View::make('admin.auth.login');
  }

  /**
   * Login action
   * @return Redirect
   */
  public function postLogin()
  {
    $credentials = array(
        'email' => Input::get('email'),
        'password' => Input::get('password')
    );

    try
    {
      $user = Sentry::authenticate($credentials, false);

      if($user)
      {
        // $path = Session::get('original.request', 'admin');
        return Redirect::intended('admin');
      }
    }
    catch (\Exception $e)
    {
      return Redirect::route('admin.login')
              ->withErrors(array('login' => $e->getMessage()));
    }
  }

  /**
   * Logout action
   * @return Redirect
   */
  public function getLogout()
  {
    Sentry::logout();

    return Redirect::route('admin.login');
  }

}