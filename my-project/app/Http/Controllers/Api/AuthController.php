<?php

namespace App\Http\Controllers\Api;

use Laravel\Sanctum\PersonalAccessToken;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Validators\AuthValidator;
use App\Services\AuthService;
use Cookie;
class AuthController extends Controller
{
    private $authValidator;
    private $authService;

    public function __construct( AuthValidator $authValidator, AuthService $authService ){
        $this->authService = $authService;
        $this->authValidator = $authValidator;
    }

    public function index(Request $request)
    {
        // Get the user connected
        $response = $this->authService->index();

        // Response
        return $response;
    }

    /**
     * Register user
     */
    public function register( Request $request )
    {
        // Validate data
        $validationResults = $this->authValidator->validate( $request->all() );

        if( $validationResults->fails() ):
            return response()->json(["warning", "The user could not register", $validationResults->errors()->first()], 422);
        endif;

        // Register a user
        $response = $this->authService->register( $request->all() );

        // Response
        return $response;
    }

    /**
     * Log in
     */
    public function login( Request $request )
    {
        // Validate data
        $validationResults = $this->authValidator->validateLogin( $request->all() );

        if( $validationResults->fails() ):
            return response()->json(["warning", "The user could not register", $validationResults->errors()->first()], 422);
        endif;

        // Log in user
        $response = $this->authService->login( $request->all() );

        // response
        return $response;
        
    }

    /**
     * Close the session.
     */
    public function logout()
    {
        // Log out user
        $response = $this->authService->logout();

        // response
        return $response;
    }

    /**
     * Decrypt the token of the cookie that is used to verify if the user is logged up (for the front-end developer).
     */
    public function decrypt()
    {
        // Log out user
        $response = $this->authService->decrypt();

        // response
        return $response;
    }
}
