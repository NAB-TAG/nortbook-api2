<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Validators\ReviewValidator;
use App\Services\ReviewService;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    private $reviewValidator;
    private $reviewService;

    public function __construct( ReviewValidator $reviewValidator, ReviewService $reviewService )
    {
        $this->reviewValidator = $reviewValidator;
        $this->reviewService = $reviewService;
    }
    /**
     * Show all reviews for a given book
     */
    public function index(string $id)
    {
        // View all reviews of the book with the $id
        $response = $this->reviewService->index($id);

        // Response
        return $response;
    }

    /**
     * create a new review.
     */
    public function store(Request $request, string $id)
    {
        // Validate data
        $validationResults = $this->reviewValidator->validate( $request->all() );

        if( $validationResults->fails() ):
            return response()->json(["warning", "The review could not post", $validationResults->errors()->first()], 422);
        endif;

        // Create new review
        $response = $this->reviewService->store( $request->all(), $id );

        // Response
        return $response;
    }
    /**
     * Update the review.
     */
    public function update(Request $request, string $id)
    {
        // Validate data
        $validationResults = $this->reviewValidator->validate( $request->all() );

        if( $validationResults->fails() ):
            return response()->json(["warning", "Could not update review", $validationResults->errors()->first()], 422);
        endif;

        // update new review
        $response = $this->reviewService->update( $request->all(), $id );

        // Response
        return $response;
    }

    /**
     * Remove the review.
     */
    public function destroy(string $id)
    {
        // remove review
        $response = $this->reviewService->destroy( $id );

        // Response
        return $response;
    }
}
