<?php

namespace App\Services;

use App\Models\Review;

class ReviewService
{
    /**
     * Logic to see all the reviews of a certain book
     */
    public function index($id)
    {
        $reviews = Review::orderBy('id', 'asc')->where('book_id', '=', $id)->get();

        return $reviews;
    }
    /**
     * Logic to create a review
     */
    public function store( array $data, string $id )
    {
        $review = new Review();
        $review->review_text = $data[ 'review_text' ];
        $review->rating = $data[ 'rating' ];
        $user = auth('sanctum')->user();
        if(!isset($user)):
            return response()->json(["error", "Failed operation", "There is no connected user."], 403);
        endif;

        $review->user_id = $user->id;
        $review->book_id = $id;
        

        if ( $review->save() ) {
            return response()->json(["success", "Successful operation", "The review has registered successfully."], 201);
        } else {
            return response()->json(["error", "Failed operation", "The review has can not registered for a problem the server, cominicate have the admin."], 500);
        }
    }
    /**
     * Logic to update a review
     */
    public function update( array $data, string $id )
    {
        $review = Review::find($id);
        $user = auth('sanctum')->user();
        if(!isset($user)):
            return response()->json(["error", "Failed operation", "There is no connected user."], 403);
        endif;

        if ( $user->id == $review->user_id) {
            $review->review_text = $data[ 'review_text' ];
            $review->rating = $data[ 'rating' ];
            if ( $review->save() ) {
                return response()->json(["success", "Successful operation", "The review has update successfully."], 201);
            } 
            return response()->json(["error", "Failed operation", "The review has not update."], 500);
        }
        return response()->json(["error", "Failed operation", "You did not publish this review."], 505);
    }
    /**
     * Logic to delete a review
     */
    public function destroy( string $id )
    {
        $review = Review::find($id);
        $user = auth('sanctum')->user();
        if(!isset($user)):
            return response()->json(["error", "Failed operation", "There is no connected user."], 403);
        endif;
        
        if ( $user->id != $review->user_id) {
            return response()->json(["error", "Failed operation", "You can not delete a review that is not yours."], 505);
        }

        if ( $review->delete() ) {
            return response()->json(["success", "Successful operation", "The review could be deleted without problems."], 201);
        }
        return response()->json(["error", "Failed operation", "The review could not be deleted."], 500); 
    }
}