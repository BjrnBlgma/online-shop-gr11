<?php
namespace Controller;
use Model\Product;
use Model\Review;
use Request\ProductCardRequest;
use Service\Authentication\AuthServiceInterface;
use Service\ReviewService;

class ProductController
{
    private AuthServiceInterface $authentication;
    private ReviewService $reviewService;

    public function __construct(AuthServiceInterface $authentication, ReviewService $reviewService)
    {
        $this->authentication = $authentication;
        $this->reviewService = $reviewService;
    }

    public function getCatalog()
    {
        if (!$this->authentication->checkSessionUser()){
            header('Location: /login');
        }
        $catalog = Product::getProducts();

        require_once "./../View/catalog.php";
    }

    public function getAddProductForm()
    {
        $userId = $this->authentication->getCurrentUser()->getId();
        if (!isset($userId)) {
            header('Location: /login');
        } else{
            require_once "./../View/add_product.php";
        }
    }

    public function openProduct(ProductCardRequest $request)
    {
        if (!$this->authentication->checkSessionUser()){
            header('Location: /login');
        }
        $errors = $request->validate();
        if (empty($errors)) {
            $productId = $request->getProductId();
            $productCard = Product::getByProductId($productId);

            $reviews = Review::getByProductId($productId);
            $averageRating = $this->reviewService->getAverageRating($productId);
        }
        require_once "./../View/product_card.php";
    }
}