<?php

namespace App\Services;

use App\Models\Book;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class BookService
{
    /**
     * Logic to show all the books
     */
    public function index()
    {
        $books = Book::orderBy('id', 'asc')->paginate(
                $perPage = 12, $columns = [ "*" ]
            )->onEachSide(0);
            return $books;
    }
     /**
     * Logic to create a new book
     */   
    public function store( array $data )
    {
        $book = new Book();
        $book->title = $data[ "title" ];
        $book->publication_year = $data[ "publication_year" ];
        $user = auth('sanctum')->user();
        $book->author = $user->name;

        // To verify if the user this connected.
        if(!isset($user)):
            return response()->json(["error", "Failed operation", "There is no connected user."], 403);
        endif;

        // Create a book
        if ( $book->save() ) {
            return response()->json(["success", "Successful operation", "The book has registered successfully."], 201);
        } else {
            return response()->json(["error", "Failed operation", "The book has can not registered for a problem the server, cominicate have the admin."], 500);
        }
    }
     /**
     * Get a list of books specifies
     */   
    public function show( string $search )
    {
        $books = Book::orderBy('id', 'asc')
            ->orWhere('author', 'like', "%$search%")
            ->orWhere('publication_year', 'like', "%$search%")
            ->orWhere('title', 'like', "%$search%")
            ->paginate(
                $perPage = 12, $columns = [ "*" ])
            ->onEachSide(0);

        return $books;
    }
    /**
     * To update a book
     */
    public function update( array $data, $id )
    {
        $book = Book::find($id);
        $user = auth('sanctum')->user();
        if(!isset($user)):
            return response()->json(["error", "Failed operation", "There is no connected user."], 403);
        endif;
        
        if ( $user->name == $book->author) {
            $book->title = $data[ 'title' ];
            $book->publication_year = $data[ "publication_year" ];
            $book->author = $user->name;
            if ( $book->save() ) {
                return response()->json(["success", "Successful operation", "The book has update successfully."], 201);
            } 
            return response()->json(["error", "Failed operation", "The book has not update."], 500);
        }
        return response()->json(["error", "Failed operation", "The book is not yours."], 403);       
    }
    /**
     * To delete a book
     */
    public function destroy( $id )
    {
        $book = Book::find($id);
        $user = auth('sanctum')->user();
        if(!isset($user)):
            return response()->json(["error", "Failed operation", "There is no connected user."], 403);
        endif;

        if ($user->name == $book->author) {
            if ( $book->delete() ) {
                return response()->json(["success", "Successful operation", "The book could be deleted without problems."], 201);
            }
            return response()->json(["error", "Failed operation", "The book could not be deleted."], 500);  
        }
        
        return response()->json(["error", "Failed operation", "The book is not yours."], 403);       
    }
}