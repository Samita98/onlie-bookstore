<?php

namespace App\Services;

use App\Model\Product;
use Illuminate\Support\Facades\DB;

class CollaborativeRecommenderSystem
{
    public function suggestProductsFor(array $productIds)
    {
        // Validate input
        if (empty($productIds)) {
            return [];
        }

        $usersWhoLikedIt = $this->getUsersWhoLiked($productIds);
        $suggestedProducts = $this->getSuggestedProducts($usersWhoLikedIt, $productIds);

        return $suggestedProducts;
    }

    private function getUsersWhoLiked(array $productIDs)
    {
        $userIds = DB::table('reviews')
            ->whereIn('product_id', $productIDs)
            ->where('rating', '>', 3)
            ->pluck('user_id')
            ->toArray();

        return $userIds;
    }

    private function getSuggestedProducts(array $users, array $productIDs)
    {
        $productScores = [];

        if (!empty($users)) {
            $ratingObjects = DB::table('reviews')
                ->whereIn('user_id', $users)
                ->where('rating', '>', 3)
                ->whereNotIn('product_id', $productIDs)
                ->select('product_id', 'rating')
                ->get();

            foreach ($ratingObjects as $ratingObject) {
                if (isset($productScores[$ratingObject->product_id])) {
                    $productScores[$ratingObject->product_id] += $ratingObject->rating;
                } else {
                    $productScores[$ratingObject->product_id] = $ratingObject->rating;
                }
            }
        }

        arsort($productScores);
        $suggestedProducts = array_slice($productScores, 0, 12, true);

        return $suggestedProducts;
    }
}