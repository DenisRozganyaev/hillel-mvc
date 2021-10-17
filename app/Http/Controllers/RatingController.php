<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use willvincent\Rateable\Rating;

class RatingController extends Controller
{
    protected $ratingModel;

    public function __construct(Rating $rating)
    {
        $this->ratingModel = $rating;
    }

    public function add(Request $request, Product $product)
    {
        $rating = $product->ratings()->where('user_id', '=', auth()->id())->first();

        if (!is_null($rating)) {
            $rating->update(['rating' => $request->star]);
        } else {
            $this->ratingModel->rating = $request->star;
            $this->ratingModel->user_id = auth()->id();

            $product->ratings()->save($this->ratingModel);
        }

        return redirect()->back();
    }
}
