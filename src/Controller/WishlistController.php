<?php
namespace Controller;
use Model\Product;
use Model\UserProductWishlist;
use Model\UserProduct;
use Request\WishlistRequest;

use Service\WishlistService;
use Service\CartService;

class WishlistController
{
    public function addProductToWishlist(WishlistRequest $request)
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        }
        $userId = $_SESSION['user_id'];

        $errors = $request->validate();
        if (empty($errors)) {
            $productId = $request->getProductId();

//            $amount = $_POST['amount'];
//            $price = $this->product->getByProductId($productId);

            WishlistService::checkProductInWishlist($userId, $productId);
        }
    }

    public function lookWishlist()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        }
        $userId = $_SESSION['user_id'];

        $wishlistProducts = UserProductWishlist::getWishlistByUserId($userId);

        //попробовать сократить код
//        $productsInWishlist =[];
//        $productIds = [];
//        foreach ($wishlistProducts as $elem) {
//            $productIds[] = $elem['product_id'];
//        }

//        $products = [];
//        foreach ($productIds as $prodId) {
//            $products [] = Product::getByProductId($prodId);
//        }
//
//        foreach ($products as $product) {
//            foreach ($wishlistProducts as $elem) {
//                if ($product['id'] === $elem['product_id']) {
//                    $product['amount'] = $elem['amount'];
//                    $productsInWishlist [] = $product;
//                }
//            }
//        }

        $productsInWishlist =[];
        $product=[];
        foreach ($wishlistProducts as $elem) {
            $wishlistObj = Product::getByProductId($elem['product_id']);

            $productsInWishlist[] = $wishlistObj;
        }
        require_once "./../View/wishlist.php";
    }

    public function addFromWishlistToCart(WishlistRequest $request)
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

            CartService::checkProductInCart($userId, $productId, $amount);
            WishlistService::deleteProductFromWishlist($userId, $productId);
            header('Location: /cart');
            exit;
        }

        require_once "./../View/add_product.php";
    }

    public function deleteProductFromWishlist(WishlistRequest $request)
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        }
        $userId = $_SESSION['user_id'];
        $productId = $request->getProductId();

        WishlistService::deleteProductFromWishlist($userId, $productId);
        header('Location: /wishlist');
        exit;
    }
}