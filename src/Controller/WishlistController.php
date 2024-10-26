<?php
namespace Controller;
use Model\Product;
use Model\UserProductWishlist;
use Model\UserProduct;
use Request\WishlistRequest;

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

            $isProductInWishlist = UserProductWishlist::getByUserIdAndProductId($userId, $productId); //есть ли продукт или нет

            if ($isProductInWishlist === false) {
                UserProductWishlist::addProductToWishlist($userId, $productId); // Добавляем
                header('Location: /wishlist');
                exit;
            } else{
//            $newAmount = $amount + $isProductInWishlist['amount'];
//            $this->wishlist->plusProductAmountInCart($userId, $productId, $newAmount);
                $errors['product'] = 'Product already in wishlist';
                header('Location: /wishlist');
                exit;
            }
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
//
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

            /*if ($product){
                $product['amount'] = $elem['amount'];
                $productsInWishlist[] = $product;
            }*/
        }

//        print_r($productsInWishlist);
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

            $isProductInCart = UserProduct::getByUserIdAndProductId($userId, $productId); //есть ли продукт в козрине или нет
            if (empty($isProductInCart)) {
                UserProduct::addProductToCart($userId, $productId, $amount); // Добавляем товар
                UserProductWishlist::deleteProduct($userId, $productId);
                header('Location: /cart');
                exit;
            } else {
                $newAmount = $amount + $isProductInCart->getAmount();
                UserProduct::plusProductAmountInCart($userId, $productId, $newAmount);
                UserProductWishlist::deleteProduct($userId, $productId);
                header('Location: /cart');
                exit;
            }
        }

        require_once "./../View/add_product.php";
    }

    public function deleteProductFromWishlist()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        }
        $userId = $_SESSION['user_id'];
        $productId = $_POST['product_id'];

        $isProductInWishlist = UserProductWishlist::getByUserIdAndProductId($userId, $productId);
        if ($isProductInWishlist) {
            UserProductWishlist::deleteProduct($userId, $productId);
            header('Location: /wishlist');
            exit;
        }
    }
}