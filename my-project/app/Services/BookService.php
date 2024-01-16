<?php

namespace App\Services;

use App\Models\Book;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use Cookie;

class BookService
{
    public function store( array $data )
    {
        $book = new Book();
        $book->title = $data[ "title" ];
        $book->publication_year = $data[ "publication_year" ];
        $user = auth('sanctum')->user();
        $book->author = $user->name;
        

        if ( $book->save() ) {
            return response()->json(["success", "Successful operation", "The book has registered successfully."], 201);
        } else {
            return response()->json(["error", "Failed operation", "The book has can not registered for a problem the server, cominicate have the admin."], 500);
        }
    }


    public function index()
    {
        $books = Book::orderBy('id', 'asc')->paginate(
                $perPage = 12, $columns = [ "*" ]
            )->onEachSide(0);
        return $books;
    }

    public function update( array $data, $id )
    {
        $book = Book::find($id);
        $user = auth('sanctum')->user();
        if(!isset($user)):
            return response()->json(["error", "Failed operation", "There is no connected user."], 201);
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
        return response()->json(["error", "Failed operation", "The book is not yours."], 505);       
    }

    public function destroy( $id )
    {
        $book = Book::find($id);

        if ( $book->delete() ) {
            return response()->json(["success", "Successful operation", "The book could be deleted without problems."], 201);
        }
        return response()->json(["error", "Failed operation", "The book could not be deleted."], 201);  
    }
}