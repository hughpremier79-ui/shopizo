<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;

class AdminReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::latest()->get();
        return view('admin.reviews.index', compact('reviews'));
    }

    public function approve(Review $review)
    {
        $review->update(['status' => 'approved']);
        return redirect('/admin/reviews')->with('success', 'Avis approuvé !');
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return redirect('/admin/reviews')->with('success', 'Avis supprimé !');
    }
}