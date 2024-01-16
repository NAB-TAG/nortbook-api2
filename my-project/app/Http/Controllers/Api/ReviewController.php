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
     * Display a listing of the reviews.
     */
    public function index(string $id)
    {
        // view all reviews
        $response = $this->reviewService->index($id);

        // Response
        return $response;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
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
     * Display the specified review.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
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
