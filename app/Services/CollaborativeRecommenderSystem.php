<?php

namespace App\Services;

use App\Model\Product;
use App\Model\Review;
use App\User;
use Illuminate\Support\Facades\DB;

class CollaborativeRecommenderSystem
{
    public function suggestProductsFor($userId)
    {
        // Validate input
        if (empty($userId)) {
            return [];
        }

        $similarUsers = $this->findSimilarUsers($userId);
        $suggestedProducts = $this->getSuggestedProducts($userId, $similarUsers);

        return $suggestedProducts;
    }

    private function findSimilarUsers($userId)
    {
        $users = User::where('id', '!=', $userId)->get();
        $similarities = [];

        foreach ($users as $user) {
            $similarity = $this->computeSimilarity($userId, $user->id);
            $similarities[$user->id] = $similarity;
        }

        arsort($similarities);
        return $similarities;
    }

    private function computeSimilarity($userId1, $userId2)
    {
        $ratings1 = $this->getUserRatings($userId1);
        $ratings2 = $this->getUserRatings($userId2);

        $dotProduct = $this->dotProduct($ratings1, $ratings2);
        $magnitude1 = $this->magnitude($ratings1);
        $magnitude2 = $this->magnitude($ratings2);

        if ($magnitude1 == 0 || $magnitude2 == 0) {
            return 0;
        }

        return $dotProduct / ($magnitude1 * $magnitude2);
    }

    private function dotProduct($vec1, $vec2)
    {
        $dotProduct = 0;
        foreach ($vec1 as $itemId => $rating) {
            if (isset($vec2[$itemId])) {
                $dotProduct += $rating * $vec2[$itemId];
            }
        }
        return $dotProduct;
    }

    private function magnitude($vec)
    {
        $magnitude = 0;
        foreach ($vec as $rating) {
            $magnitude += pow($rating, 2);
        }
        return sqrt($magnitude);
    }

    private function getUserRatings($userId)
    {
        $ratings = Review::where('user_id', $userId)->pluck('rating', 'product_id')->toArray();
        return $ratings;
    }

    private function getSuggestedProducts($userId, $similarUsers)
    {
        $suggestedProducts = [];
        $minRatingThreshold = 3; // Set the minimum rating threshold

        foreach ($similarUsers as $similarUserId => $similarity) {
            $products = $this->getUserRatings($similarUserId);

            foreach ($products as $productId => $rating) {
                // Check if the user has already interacted with this product
                if (!Review::where('user_id', $userId)->where('product_id', $productId)->exists()) {
                    // Check if the rating meets the minimum threshold
                    if ($rating >= $minRatingThreshold) {
                        if (!array_key_exists($productId, $suggestedProducts)) {
                            $suggestedProducts[$productId] = 0;
                        }

                        $suggestedProducts[$productId] += $rating * $similarity;
                    }
                }
            }
        }

        arsort($suggestedProducts);
        return array_slice($suggestedProducts, 0, 8, true);
    }
}