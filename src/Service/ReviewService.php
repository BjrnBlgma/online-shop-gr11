<?php
namespace Ariana\FirstProject\Service;

use Ariana\FirstProject\Model\Product;
use Ariana\FirstProject\Model\Review;

class ReviewService
{
    public function getAverageRating(int $productId)
    {
        $reviews = Review::getByProductId($productId);
        $average = $this->calculateAverage($reviews);
        if (empty($average)){
            return null;
        }
        $averageRating = round($average, 1);
        return $averageRating;
    }

    private function calculateAverage($array = []): float|int|null
    {
        $sum = 0;
        $count = 0;
        foreach ($array as $value) {
            $sum += $value->getRating();
            $count++;
        }
        if (empty($count)){
            return null;
        }
        return $sum / $count;
    }
}