<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
<main id="cart" style="max-width:960px">
    <div class="back"><a href="/catalog " >&#11178; shop</a></div>

    <div class="twitter"><i class="fab fa-twitter"></i>
        <a href="/wishlist" ><svg class="heart" version="1.1" viewBox="0 0 512 512" width="40px" xml:space="preserve" id="wishlist" stroke="#727272" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <path d="M340.8,98.4c50.7,0,91.9,41.3,91.9,92.3c0,26.2-10.9,49.8-28.3,66.6L256,407.1L105,254.6c-15.8-16.6-25.6-39.1-25.6-63.9c0-51,41.1-92.3,91.9-92.3c38.2,0,70.9,23.4,84.8,56.8C269.8,121.9,302.6,98.4,340.8,98.4 M340.8,83C307,83,276,98.8,256,124.8c-20-26-51-41.8-84.8-41.8C112.1,83,64,131.3,64,190.7c0,27.9,10.6,54.4,29.9,74.6L245.1,418l10.9,11l10.9-11l148.3-149.8c21-20.3,32.8-47.9,32.8-77.5C448,131.3,399.9,83,340.8,83L340.8,83z" stroke="#727272"/></svg>
                </a></div>

    <h1>Your Cart</h1>
    <div class="container-fluid">
        <div class="row align-items-start">
            <div class="col-12 col-sm-8 items">
                <!--1-->
                <?php foreach($productsInCart as $product): ?>
                    <div class="cartItem row align-items-start">
                        <div class="col-3 mb-2">
                            <img class="w-100" src="<?php echo $product->getProduct()->getImage(); ?>" alt="art image">
                        </div>
                        <div class="col-5 mb-2">
                            <h6 class=""><?php echo $product->getProduct()->getName(); ?></h6>
<!--                            <p class="pl-1 mb-0">20 x 24</p>-->
                            <!--<p class="pl-1 mb-0">Matte Print</p>-->
                        </div>
                        <div class="col-2">
                            <p class="cartItemQuantity p-1 text-center"><?php echo $product->getAmount(); ?></p>
                        </div>
                        <div class="col-2">
                            <p id="cartItem1Price"> <?php echo "{$product->getProduct()->getPrice()}$" ?> </p>
                        </div>
                    </div>
                    <hr>
                <?php endforeach; ?>



            </div>
            <div class="col-12 col-sm-4 p-3 proceed form">
                <hr>
                <div class="row mx-0 mb-2">
                    <div class="col-sm-8 p-0 d-inline">
                        <h5>Итого</h5>
                    </div>
                    <div class="col-sm-4 p-0">
                        <input type="hidden" id="sum" name="sum" value="<?php echo $allSum ?? null ?>" required>
                        <p id="total"> <?php echo $allSum . "$";?> </p>
                    </div>
                </div>
                <a href="order"><button id="btn-checkout" class="shopnow"><span>Оформить</span></button></a>
            </div>
        </div>
    </div>
    </div>
</main>
<footer class="container">
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>


<style>
    #cart {
        max-width: 1440px;
        padding-top: 60px;
        margin: auto;
    }
    .form div {
        margin-bottom: 0.4em;
    }
    .cartItem {
        --bs-gutter-x: 1.5rem;
    }
    .cartItemQuantity,
    .proceed {
        background: #f4f4f4;
    }
    .items {
        padding-right: 30px;
    }
    #btn-checkout {
        min-width: 100%;
    }

    /* stasysiia.com */
    @import url("https://fonts.googleapis.com/css2?family=Exo&display=swap");
    body {
        background-color: #fff;
        font-family: "Exo", sans-serif;
        font-size: 22px;
        margin: 0;
        padding: 0;
        color: #111111;
        justify-content: center;
        align-items: center;
    }
    a {
        color: #0e1111;
        text-decoration: none;
    }
    .btn-check:focus + .btn-primary,
    .btn-primary:focus {
        color: #fff;
        background-color: #111;
        border-color: transparent;
        box-shadow: 0 0 0 0.25rem rgb(49 132 253 / 50%);
    }
    button:hover,
    .btn:hover {
        box-shadow: 5px 5px 7px #c8c8c8, -5px -5px 7px white;
    }
    button:active {
        box-shadow: 2px 2px 2px #c8c8c8, -2px -2px 2px white;
    }

    /*PREVENT BROWSER SELECTION*/
    a:focus,
    button:focus,
    input:focus,
    textarea:focus {
        outline: none;
    }
    /*main*/
    main:before {
        content: "";
        display: block;
        height: 88px;
    }
    h1 {
        font-size: 2.4em;
        font-weight: 600;
        letter-spacing: 0.15rem;
        text-align: center;
        margin: 30px 6px;
    }
    h2 {
        color: rgb(37, 44, 54);
        font-weight: 700;
        font-size: 2.5em;
    }
    h3 {
        border-bottom: solid 2px #000;
    }
    h5 {
        padding: 0;
        font-weight: bold;
        color: #92afcc;
    }
    p {
        color: #333;
        font-family: "Roboto", sans-serif;
        margin: 0.6em 0;
    }
    h1,
    h2,
    h4 {
        text-align: center;
        padding-top: 16px;
    }
    /* yukito bloody */
    .back {
        position: relative;
        top: -30px;
        font-size: 16px;
        margin: 10px 10px 3px 15px;
    }
    .inline {
        display: inline-block;
    }

    .shopnow,
    .contact {
        background-color: #000;
        padding: 10px 20px;
        font-size: 30px;
        color: white;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.5s;
        cursor: pointer;
    }
    .shopnow:hover {
        text-decoration: none;
        color: white;
        background-color: #c41505;
    }
    /* for button animation*/
    .shopnow span {
        cursor: pointer;
        display: inline-block;
        position: relative;
        transition: all 0.5s;
    }
    .shopnow span:after {
        content: url("https://badux.co/smc/codepen/caticon.png");
        position: absolute;
        font-size: 30px;
        opacity: 0;
        top: 2px;
        right: -6px;
        transition: all 0.5s;
    }
    .shopnow:hover span {
        padding-right: 25px;
    }
    .shopnow:hover span:after {
        opacity: 1;
        top: 2px;
        right: -6px;
    }
    .ma {
        margin: auto;
    }
    .price {
        color: slategrey;
        font-size: 2em;
    }
    #mycart {
        min-width: 90px;
    }
    #cartItems {
        font-size: 17px;
    }
    #product .container .row .pr4 {
        padding-right: 15px;
    }
    #product .container .row .pl4 {
        padding-left: 15px;
    }


    .twitter {
        position: fixed;
        top: 1px;
        font-size: 19px;
        margin: 10px 10px 3px 15px;

        right: 20px;
    }
</style>