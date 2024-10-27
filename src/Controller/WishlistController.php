<?php
namespace Controller;
use Model\Product;
use Model\UserProductWishlist;
use Model\UserProduct;
use Request\WishlistRequest;

use Service\WishlistService;
use Service\CartService;
use Session\Session;

class WishlistController
{
    public function addProductToWishlist(WishlistRequest $request)
    {
        Session::start();
        Session::checkSessionUser();
        $userId = Session::getSessionUser();

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
        Session::start();
        Session::checkSessionUser();
        $userId = Session::getSessionUser();

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
        Session::start();
        Session::checkSessionUser();
        $userId = Session::getSessionUser();
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
        Session::start();
        Session::checkSessionUser();
        $userId = Session::getSessionUser();
        $productId = $request->getProductId();

        WishlistService::deleteProductFromWishlist($userId, $productId);
        header('Location: /wishlist');
        exit;
    }
}