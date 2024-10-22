<h1>Catalog</h1>
<div class="back">
    <h1>
        <a href="/wishlist" ><svg class="heart" version="1.1" viewBox="0 0 512 512" width="40px" xml:space="preserve" id="wishlist"
                                   stroke="#727272" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <path d="M340.8,98.4c50.7,0,91.9,41.3,91.9,92.3c0,26.2-10.9,49.8-28.3,66.6L256,407.1L105,254.6c-15.8-16.6-25.6-39.1-25.6-63.9c0-51,41.1-92.3,91.9-92.3c38.2,0,70.9,23.4,84.8,56.8C269.8,121.9,302.6,98.4,340.8,98.4 M340.8,83C307,83,276,98.8,256,124.8c-20-26-51-41.8-84.8-41.8C112.1,83,64,131.3,64,190.7c0,27.9,10.6,54.4,29.9,74.6L245.1,418l10.9,11l10.9-11l148.3-149.8c21-20.3,32.8-47.9,32.8-77.5C448,131.3,399.9,83,340.8,83L340.8,83z" stroke="#727272"/></svg>
        </a>
    </h1>
    <h1><a href="/cart" >&#128722;</a></h1>
</div>

<div class="container">
    <?php foreach ($catalog as $product): ?>
        <div class="product">

            <div class="effect-1"></div>
            <div class="effect-2"></div>
            <div class="content">
                <img class="card-img-top" src="<?php echo $product->getImage(); ?>">

                <!--<div class="exercise"  ></div>-->

            </div>
            <span class="title">
                <?php echo $product->getName(); ?>
                <nav>
                <span> <?php echo "{$product->getPrice()}$" ?> </span>

                        <form action="/add" method="POST">
                            <input type="hidden" id="product_id" name="product_id" value="<?= $product->getId();?>" required>

                                <input type="text" placeholder="Введите кол-во" id="amount" name="amount" required>
                                <label style="color: red"> <?php print_r($errors['amount'] ?? '');?> </label>

                            <button type="submit">ADD to cart</button>
                        </form>


                <form action="/addToWishlist" method="POST">
                    <input type="hidden" id="product_id" name="product_id" value="<?= $product->getId();?>" required>
                    <input type="hidden" id="amount" name="amount" value="1" required>

                    <label style="color: red"> <?php print_r($errors['amount'] ?? '');?> </label>

                    <button type="submit">Добавить в Избранное
                        <svg class="heart" version="1.1" viewBox="0 0 512 512" width="16px" xml:space="preserve" id="wishlist"
                             stroke="#727272" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <path d="M340.8,98.4c50.7,0,91.9,41.3,91.9,92.3c0,26.2-10.9,49.8-28.3,66.6L256,407.1L105,254.6c-15.8-16.6-25.6-39.1-25.6-63.9c0-51,41.1-92.3,91.9-92.3c38.2,0,70.9,23.4,84.8,56.8C269.8,121.9,302.6,98.4,340.8,98.4 M340.8,83C307,83,276,98.8,256,124.8c-20-26-51-41.8-84.8-41.8C112.1,83,64,131.3,64,190.7c0,27.9,10.6,54.4,29.9,74.6L245.1,418l10.9,11l10.9-11l148.3-149.8c21-20.3,32.8-47.9,32.8-77.5C448,131.3,399.9,83,340.8,83L340.8,83z" stroke="#727272"/></svg>
                    </button>
                </form>
                        <label style="color: green"> <?php echo $errors['product'] ?? '';?> </label>
                </nav>


            </span>

        </div>

    <?php endforeach; ?>

</div>


<div class="twitter"><i class="fab fa-twitter"></i><a href="/logout">Logout</a></div>



<style>
    .back {
        position: fixed;
        top: 1px;
        font-size: 19px;
        margin: 10px 10px 3px 15px;

        right: 20px;
    }

    body {
        background-image: linear-gradient(120deg, #fdfbfb 0%, #ebedee 100%);
        font-family: "Josefin Slab";
        height: 100vh;
    }

    h1 {
        font-size: 2.2rem;
        margin-top: 80px;
        text-align: center;
    }


    .container {
        display: flex;
        flex-wrap: wrap;
        max-width: 1200px; /*размер каталога*/
        margin: 2vw auto;
        position: relative;
        text-align: center;
        width: 100%; /*сколько использовать места от всего доступного размера каталога*/
    }

    .product {
        flex: auto;
        font-size: 1rem;
        margin: 0 1vw calc(2vw + 80px) 1vw; /*расстояние между продуктами*/
        min-width: calc(30% - 10vw);
        position: relative;

    }

    .product:before {
        content: "";
        float: left;
        padding-top: 100%;
    }

    .content {
        background: white;
        border-radius: 20%;
        height:80%;
        margin: 8%;
        position: absolute;
        width: 80%;
        vertical-align: middle;
        z-index: 5000;
    }

    .product:hover .effect-1,
    .product:hover .effect-2 {
        display: block;
    }

    .effect-1,
    .effect-2 {
        border-radius: 30%;
        display: none;
        mix-blend-mode: multiply;
        height: 80%;
        opacity: 1;
        position: absolute;
        width: 80%;
        z-index: 3000;
    }

    .effect-1 {
        animation: rotate 1.8s linear infinite;
        background: cyan;
    }

    .effect-2 {
        animation: rotate 1.2s linear reverse infinite;
        background: #e7a9ff;
    }

    @keyframes rotate {
        0% {
            top: 0;
            left: 8%;
        }
        25% {
            top: 8%;
            left: 0%;
        }
        50% {
            top: 16%;
            left: 8%;
        }
        75% {
            top: 8%;
            left: 16%;
        }
        100% {
            top: 0;
            left: 8%;
        }
    }

    .title {
        position: relative;
        top: calc(90% + 20px); /*расстояние текста от картинки*/
    }

    .title span {
        display: block;
        font-family: Helvetica, Arial, Sans-Serif;
        font-size: 1.2rem;
        letter-spacing: 0.1rem;
        margin-top: 3px;
        text-transform: uppercase;
    }

    .card-img-top{
        border-radius: 5px;
        height: 70%;
        margin: 15%;
        width: 70%;
    }

    /*.exercise {
        !*background-image: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);*!
        border-radius: 5px;
        height: 50%;
        margin: 25%;
        width: 50%;
    }*/

    .twitter {
        background-image: linear-gradient(
                to top,
                #1e3c72 0%,
                #1e3c72 1%,
                #2a5298 100%
        );
        border-radius: 14px;
        bottom: 20px;
        color: #fff;
        font-weight: 400;
        letter-spacing: 0.1rem;
        line-height: 28px;
        padding: 0 12px;
        position: fixed;
        right: 20px;
        z-index: 5000;
    }

    .twitter i {
        margin-right: 6px;
        position: relative;
        top: 2px;
    }

    .twitter a {
        color: #fff;
        font-family: Helvetica, Arial, Sans-Serif;
        font-size: 0.7rem;
        text-decoration: none;
    }

    input {
        width:35%;
        margin: 2px 6px;
        padding:2px 2px;
    }
    button {
        text-align: center;
        font-size: 14px;

    }

    nav {
        width: 100%;
        color: #727272;
        text-align: center;
        text-transform: uppercase;
        padding: 0;
        border-bottom: 3px solid #efefef;
        font-size: 10px;

        svg.heart {

            height: 20px;
            width: 20px;
            float: right;
            margin-top: 0;
            transition: all 0.3s ease;
            cursor: pointer;

            &:hover {
                fill: red;
            }
        }
    }
</style>