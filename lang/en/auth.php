<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'unauthorizedAccount'   => 'Unauthorized account, Please Login',
    'accountNotFound'   => 'Account Not Found.',
    'failed' => 'These credentials do not match our records.',
    'password' => 'The provided password is incorrect.',
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',
    'deleted_user' => 'Your account was suspended, Please Contact Admin.',
    'wrong_verification_code' => 'Wrong verification Code',
    'wrong_old_password' => 'Wrong Old Password',
    'nik_not_match' => 'ID Card not match with Employee Code.',

    'success' => [
        'login' => 'Hello :name',
        '2fa' => 'Verify OTP Code',
        'login-text' => 'Welcome to ' . env('APP_NAME') . ' Payroll App',
        'register' => 'You have successfully Register.',
        'logout' => 'You have successfully logged out.',

        '2fa-text-login' => 'Please input OTP code to verify',

        'account-verify' => 'Verification',
        '2fa-text' => 'Please check OTP code in your :method',
    ],

];
