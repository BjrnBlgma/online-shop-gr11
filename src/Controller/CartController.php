<?php
namespace Controller;
use Model\UserProduct;
use Request\ProductRequest;
use Service\Authentication\AuthServiceInterface;
use Service\CartService;

class CartController
{
    private AuthServiceInterface $authentication;
    private CartService $cartService;

    public function __construct(
        AuthServiceInterface $authentication,
        CartService $cartService
    )
    {
        $this->authentication = $authentication;
        $this->cartService = $cartService;
    }


    public function lookCart()
    {
        if (!$this->authentication->checkSessionUser()){
            header('Location: /login');
        }
        $userId = $this->authentication->getCurrentUser()->getId();

//        $productsInCart = UserProduct::getByUserIdWithoutJoin($userId);
        $productsInCart = UserProduct::getByUserIdWithJoin($userId);

        $allSum= $this->cartService->getTotalSum($userId);

        require_once "./../View/cart.php";
    }

    public function addProductToCart(ProductRequest $request)
    {
        if (!$this->authentication->checkSessionUser()){
            header('Location: /login');
        }
        $userId = $this->authentication->getCurrentUser()->getId();
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