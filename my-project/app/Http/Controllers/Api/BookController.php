<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Validators\BookValidator;
use App\Services\BookService;

class BookController extends Controller
{
    private $bookValidator;
    private $bookService;

    public function __construct( BookValidator $bookValidator, BookService $bookService )
    {
        $this->bookService = $bookService;
        $this->bookValidator = $bookValidator;  
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = $this->bookService->index();

        return $response;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate data
        $validationResults = $this->bookValidator->validate( $request->all() );

        if( $validationResults->fails() ):
            return response()->json(["warning", "The book could not save", $validationResults->errors()->first()], 422);
        endif;

        // Create new book
        $response = $this->bookService->store( $request->all() );

        // Response
        return $response;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate data
        $validationResults = $this->bookValidator->validate( $request->all() );

        if( $validationResults->fails() ):
            return response()->json(["warning", "The book could not update", $validationResults->errors()->first()], 422);
        endif;

        // Create new book
        $response = $this->bookService->update( $request->all(), $id );

        // Response
        return $response;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = $this->bookService->destroy($id);

        return $response;
    }
}
