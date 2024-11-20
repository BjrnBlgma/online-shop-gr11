<?php
namespace Ariana\FirstProject\Controller;
use Ariana\FirstProject\Model\OrderProduct;
use Ariana\FirstProject\Model\Product;
use Ariana\FirstProject\Model\Review;
use Ariana\FirstProject\Request\ProductCardRequest;
use Core\Authentication\AuthServiceInterface;
use Ariana\FirstProject\Service\ReviewService;

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
        $userId = $this->authentication->getCurrentUser()->getId();
        $errors = $request->validate();
        if (empty($errors)) {
            $productId = $request->getProductId();
            $productCard = Product::getByProductId($productId);

            $reviews = Review::getByProductId($productId);
            $averageRating = $this->reviewService->getAverageRating($productId);

            $isOrderProduct = OrderProduct::getByUserIdandProductId($userId, $productId);

        }
        require_once "./../View/product_card.php";
    }
}