<?php
namespace Controller;
use Model\Product;
use Model\UserProductWishlist;
use Model\UserProduct;

class WishlistController
{
    private Product $product;
    private UserProductWishlist $wishlist;
    private UserProduct $userProduct;

    public function __construct()
    {
        $this->product = new Product();
        $this->wishlist = new UserProductWishlist();
        $this->userProduct = new UserProduct();
    }

    public function addProductToWishlist()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        }
        $userId = $_SESSION['user_id'];

        $errors = $this->validateProduct();
        if (empty($errors)) {
            $productId = $_POST['product_id'];

//            $amount = $_POST['amount'];
//            $price = $this->product->getByProductId($productId);

            $isProductInWishlist = $this->wishlist->getByUserIdAndProductId($userId, $productId); //есть ли продукт или нет

            if ($isProductInWishlist === false) {
                $this->wishlist->addProductToWishlist($userId, $productId); // Добавляем
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
            $wishlistObj = $this->product->getByProductId($elem['product_id']);

            $productsInWishlist[] = $wishlistObj;

            /*if ($product){
                $product['amount'] = $elem['amount'];
                $productsInWishlist[] = $product;
            }*/
        }

//        print_r($productsInWishlist);
        require_once "./../View/wishlist.php";
    }


//    public function addFromWishlistToCart()
//    {
//        session_start();
//        if (!isset($_SESSION['user_id'])) {
//            header('Location: /login');
//        }
//        $userId = $_SESSION['user_id'];
//        $errors = $this->validateProduct();
//
//        if (empty($errors)) {
//            $productId = $_POST['product_id'];
//            $amount = $_POST['amount'];
//
//            $isProductInCart = $this->userProduct->getByUserIdAndProductId($userId, $productId); //есть ли продукт в козрине или нет
//            if ($isProductInCart === false) {
//                $this->userProduct->addProductToCart($userId, $productId, $amount); // Добавляем товар
//                $this->wishlist->deleteProduct($userId, $productId);
//                header('Location: /cart');
//                exit;
//            } else {
//                $newAmount = $amount + $isProductInCart['amount'];
//                $this->userProduct->plusProductAmountInCart($userId, $productId, $newAmount);
//                $this->wishlist->deleteProduct($userId, $productId);
//                header('Location: /cart');
//                exit;
//            }
//        }
//
//        require_once "./../View/add_product.php";
//    }

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


    private function validateProduct(): array
    {
        $errors = [];

        if (isset($_POST['product_id'])) {
            $productId = $_POST['product_id'];
            $isCorrectIdProduct = $this->product->getByProductId($productId);  //есть ли такой товар к продуктах

            if (empty($productId)) {
                $errors['product'] = "ID товара не должно быть пустым";
            } elseif (!ctype_digit($productId)) {
                $errors['product'] = "Поле ID товара должно содержать только цифры!";
            } elseif ($productId <= 0) {
                $errors['product'] = "Поле ID товара не должно содержать отрицательные значения";
            } elseif ($isCorrectIdProduct['id'] === false) {
                $errors['product'] = "Введите корректный ID товара";
            }
        } else {
            $errors['product'] = 'Выберите продукт';
        }

        if (isset($_POST['amount'])) {
            $amount = $_POST['amount'];
            if (empty($amount)) {
                $errors['amount'] = "Выберите количество товара";
            } elseif (!ctype_digit($amount)) {
                $errors['amount'] = "Поле количества товара должно содержать только цифры!";
            } elseif ($amount <= 0) {
                $errors['amount'] = "Количество товара не должно быть отрицательным";
            }
        } else {
            $errors['amount'] = 'Выберите количество товара';
        }

        return $errors;
    }
}