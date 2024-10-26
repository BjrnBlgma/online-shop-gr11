<?php
namespace Controller;
use Model\UserProduct;
use Model\Product;
use Model\UserProductWishlist;
use Controller\WishlistController;
use Request\ProductRequest;

class ProductController
{
    private Product $product;
    private UserProduct $userProduct;
    private UserProductWishlist $userProductWishlist;

    public function __construct()
    {
        $this->product = new Product();
        $this->userProduct = new UserProduct();
        $this->userProductWishlist = new UserProductWishlist();
    }

    public function getCatalog()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        }
        $catalog = $this->product->getProducts();


        require_once "./../View/catalog.php";
    }

    public function getAddProductForm()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        } else{
            require_once "./../View/add_product.php";
        }
    }
    public function addProductToCart(ProductRequest $request)
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        }
        $userId = $_SESSION['user_id'];
        $errors = $request->validate();

        if (empty($errors)) {
            $productId = $request->getProductId();
            $amount = $request->getAmount();

            $isProductInCart = $this->userProduct->getByUserIdAndProductId($userId, $productId); //есть ли продукт в козрине или нет
            if (empty($isProductInCart)) {
                $this->userProduct->addProductToCart($userId, $productId, $amount); // Добавляем товар
                //$this->userProductWishlist->deleteProduct($userId, $productId);
                header('Location: /cart');
                exit;
            } else {
                $newAmount = $amount + $isProductInCart->getAmount();
                $this->userProduct->plusProductAmountInCart($userId, $productId, $newAmount);
                //$this->userProductWishlist->deleteProduct($userId, $productId);
                header('Location: /cart');
                exit;
            }
        }

        require_once "./../View/add_product.php";
    }
}