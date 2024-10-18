<?php
namespace Controller;
use Model\Product;
use Model\UserProductWishlist;

class WishlistController
{
    private Product $product;
    private UserProductWishlist $wishlist;

    public function __construct()
    {
        $this->product = new Product();
        $this->wishlist = new UserProductWishlist();
    }

    public function addProductToWishlist()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        }
        $userId = $_SESSION['user_id'];

        $productId = $_POST['product_id'];
        $amount = $_POST['amount'];

        $price = $this->product->getByProductId($productId);

        $isProductInWishlist = $this->wishlist->getByUserIdAndProductId($userId, $productId); //есть ли продукт или нет

        if ($isProductInWishlist === false) {
            $this->wishlist->addProductToWishlist($userId, $productId, $amount, $price['price']); // Добавляем
            header('Location: /wishlist');
            exit;
        } else{
            $newAmount = $amount + $isProductInWishlist['amount'];
            $this->wishlist->plusProductAmountInCart($userId, $productId, $newAmount);
            header('Location: /wishlist');
            exit;
        }
    }

    public function lookWishlist()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        }
        $userId = $_SESSION['user_id'];

        $wishlistProducts = $this->wishlist->getWishlistByUserId($userId);

        //попробовать сократить код

//        $productsInWishlist =[];
//        $productIds = [];
//        foreach ($wishlistProducts as $elem) {
//            $productIds[] = $elem['product_id'];
//        }
//
//        $products = [];
//        foreach ($productIds as $prodId) {
//            $products [] = $this->product->getByProductId($prodId);
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
            $product = $this->product->getByProductId($elem['product_id']);
            if ($product){
                $product['amount'] = $elem['amount'];
                $productsInWishlist[] = $product;
            }
        }

//        print_r($productsInWishlist);
        require_once "./../View/wishlist.php";
    }

    public function deleteProductFromWishlist()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        }
        $userId = $_SESSION['user_id'];
        $productId = $_POST['product_id'];

        $isProductInWishlist = $this->wishlist->getByUserIdAndProductId($userId, $productId);
        if ($isProductInWishlist) {
            $this->wishlist->deleteProduct($userId, $productId);
            header('Location: /wishlist');
            exit;
        }
    }

}