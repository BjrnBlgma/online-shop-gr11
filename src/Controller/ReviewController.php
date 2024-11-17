<?php
namespace Controller;

use Model\Model;
use Model\Product;
use Model\Review;
use Request\ProductCardRequest;
use Request\ReviewRequest;
use Service\Authentication\AuthServiceInterface;
use Model\OrderProduct;

class ReviewController
{
    private AuthServiceInterface $authentication;
    public function __construct(
        AuthServiceInterface $authentication
    )
    {
        $this->authentication = $authentication;
    }

    public function getReviewForm(ProductCardRequest $request)
    {
        if (!$this->authentication->checkSessionUser()) {
            header('Location: /login');
        } else{
            $userId = $this->authentication->getCurrentUser()->getId();
            $errors = $request->validate();
            if (empty($errors)) {
                $productId = $request->getProductId();
                $isOrderProduct = OrderProduct::getByUserIdandProductId($userId, $productId);
                if (empty($isOrderProduct)) {
                    header('Location: /cart');
                    //добавила условие для видимости кнопки "review":)
                }
                $reviews = Review::getByProductId($productId);
                if (count($reviews) >= count($isOrderProduct)) {
                    $errors['warning'] = "Вы можете написать отзыв только такое же количество раз, сколько заказывали товар";
                }
            }
            require_once "./../View/create_review_form.php";
        }
    }

    public function createReview(ReviewRequest $request)
    {
        if (!$this->authentication->checkSessionUser()){
            header('Location: /login');
        }
        $userId = $this->authentication->getCurrentUser();
        $errors = $request->validate();

        if (empty($errors)) {
            $review = $request->getReview();
            $rating = $request->getRating();
            $productId = $request->getProductId();

            Review::createReview($review, $rating, $productId, $userId);
            header('Location: /catalog');
        }
    }
}