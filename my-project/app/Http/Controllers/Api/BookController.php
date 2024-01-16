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
     * To show a list of books.
     */
    public function index()
    {
        $response = $this->bookService->index();

        return $response;
    }

    /**
     * To create a new book.
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
     * It shows a list it specifies of books.
     */
    public function show(string $search)
    {
        // Create new book
        $response = $this->bookService->show( $search );

        // Response
        return $response;
    }

    /**
     * It upgrades a product in I specify.
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
     * To eliminate a product.
     */
    public function destroy(string $id)
    {
        $response = $this->bookService->destroy($id);

        return $response;
    }
}
