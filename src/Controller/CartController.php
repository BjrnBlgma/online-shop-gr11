<?php
namespace Controller;
use Model\UserProduct;
use Request\ProductRequest;
use Service\CartService;
use Service\Authentication;

class CartController
{
    private Authentication $authentication;
    private CartService $cartService;
    public function __construct(){
        $this->authentication = new Authentication();
        $this->cartService = new CartService();
    }
    public function lookCart()
    {
        $this->authentication->start();
        $this->authentication->checkSessionUser();
        $userId = $this->authentication->getSessionUser();

//        $productsInCart = UserProduct::getByUserIdWithoutJoin($userId);
        $productsInCart = UserProduct::getByUserIdWithJoin($userId);

        $allSum= $this->cartService->getTotalSum($userId);

        require_once "./../View/cart.php";
    }

    public function addProductToCart(ProductRequest $request)
    {
        $this->authentication->start();
        $this->authentication->checkSessionUser();
        $userId = $this->authentication->getSessionUser();
        $errors = $request->validate();

        if (empty($errors)) {
            $productId = $request->getProductId();
            $amount = $request->getAmount();

            $this->cartService->addProductToCart($userId, $productId, $amount);
            header('Location: /cart');
            exit;
        }

        require_once "./../View/add_product.php";
    }
}