<?php
namespace Ariana\FirstProject\Controller;

use Ariana\FirstProject\Model\Product;
use Ariana\FirstProject\Model\UserProductWishlist;
use Ariana\FirstProject\Request\WishlistRequest;
use Core\Authentication\AuthServiceInterface;
use Ariana\FirstProject\Service\CartService;
use Ariana\FirstProject\Service\WishlistService;

class WishlistController
{
    private AuthServiceInterface $authentication;
    private CartService $cartService;
    private WishlistService $wishlistService;

    public function __construct(
        AuthServiceInterface $authentication,
        CartService $cartService,
        WishlistService $wishlistService
    )
    {
        $this->authentication = $authentication;
        $this->cartService = $cartService;
        $this->wishlistService = $wishlistService;
    }
    public function addProductToWishlist(WishlistRequest $request)
    {
        if (!$this->authentication->checkSessionUser()){
            header('Location: /login');
        }
        $userId = $this->authentication->getCurrentUser()->getId();

        $errors = $request->validate();
        if (empty($errors)) {
            $productId = $request->getProductId();

            $this->wishlistService->addProductToWishlist($userId, $productId);
            header('Location: /wishlist');
        }
    }

    public function lookWishlist()
    {
        $this->authentication->checkSessionUser();
        $userId = $this->authentication->getCurrentUser()->getId();

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
        if (!$this->authentication->checkSessionUser()){
            header('Location: /login');
        }
        $userId = $this->authentication->getCurrentUser()->getId();
        $errors = $request->validate();

        if (empty($errors)) {
            $productId = $request->getProductId();
            $amount = $request->getAmount();

            $this->cartService->addProductToCart($userId, $productId, $amount);
            $this->wishlistService->deleteProductFromWishlist($userId, $productId);
            header('Location: /cart');
            exit;
        }

        require_once "./../View/add_product.php";
    }

    public function deleteProductFromWishlist(WishlistRequest $request)
    {
        if (!$this->authentication->checkSessionUser()){
            header('Location: /login');
        }
        $userId = $this->authentication->getCurrentUser()->getId();
        $productId = $request->getProductId();

        $this->wishlistService->deleteProductFromWishlist($userId, $productId);
        header('Location: /wishlist');
        exit;
    }
}