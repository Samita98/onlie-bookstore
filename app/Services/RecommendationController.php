<?php

namespace App\Services;

use App\Model\User;
use App\Model\Review;

class RecommendationController extends Controller
{
    public function recommend(User $user)
    {
        // Implement recommendation algorithm to get recommendations
        $recommendations = $this->getRecommendations($user);

        // Pass recommendations to the view
        return view('recommendations', ['recommendations' => $recommendations]);
    }

    private function getRecommendations(User $user)
    {
        // Implement your recommendation algorithm here and return recommended items
        // For simplicity, let's return top rated items for now
        $recommendations = Review::where('user_id', $user->id)
            ->orderBy('rating', 'desc')
            ->limit(5)
            ->get();

        return $recommendations;
    }

private function calculateCosineSimilarity(User $user1, User $user2)
{
    $ratings1 = $user1->reviews->pluck('rating')->toArray();
    $ratings2 = $user2->reviews->pluck('rating')->toArray();

    // Calculate dot product
    $dotProduct = array_sum(array_map(function ($rating1, $rating2) {
        return $rating1 * $rating2;
    }, $ratings1, $ratings2));

    // Calculate magnitude of vectors
    $magnitude1 = sqrt(array_sum(array_map(function ($rating) {
        return pow($rating, 2);
    }, $ratings1)));

    $magnitude2 = sqrt(array_sum(array_map(function ($rating) {
        return pow($rating, 2);
    }, $ratings2)));

    // Calculate cosine similarity
    if ($magnitude1 != 0 && $magnitude2 != 0) {
        $similarity = $dotProduct / ($magnitude1 * $magnitude2);
    } else {
        $similarity = 0; // Handle division by zero
    }

    return $similarity;
}


}
