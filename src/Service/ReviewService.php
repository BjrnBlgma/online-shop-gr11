<?php
namespace Service;

use Model\Model;
use Model\Product;
use Model\Review;

class ReviewService
{
//    public function createReview()
//    {
//        Model::getPdo()->beginTransaction();
//        try {
//            Review::createReview($review, $rating, $productId, $userId);
//
//        } catch (\PDOException $exception) {
//            Model::getPdo()->rollBack();
//            throw $exception;
//        }
//        Model::getPdo()->commit();
//    }
    public function getAverageRating(int $productId)
    {
        $reviews = Review::getByProductId($productId);
        $average = $this->calculateAverage($reviews);
        return $average;
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