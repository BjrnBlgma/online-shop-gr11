<h1>Catalog</h1>
<div class="back">
    <h1><a href="/cart " >&#128722;</a></h1>
</div>

<div class="container">
    <?php foreach ($catalog as $product): ?>
        <div class="product">

            <div class="effect-1"></div>
            <div class="effect-2"></div>
            <div class="content">
                <img class="card-img-top" src="<?php echo $product['image']; ?>">

                <!--<div class="exercise"  ></div>-->

            </div>
            <span class="title">
                <?php echo $product['name']; ?>

                <span> <?php echo "{$product['price']}$" ?> </span>
                        <form action="/add" method="POST">
            <input type="hidden" id="product_id" name="product_id" value="<?= $product['id']?>" required>
            <input type="text" placeholder="Введите кол-во" id="amount" name="amount" required>
            <label style="color: red"> <?php print_r($errors['amount'] ?? '');?> </label>


            <button type="submit">ADD to cart</button>

        </form>

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
        max-width: 1000px;
        margin: 2vw auto;
        position: relative;
        text-align: center;
        width: 90vw;
    }

    .product {
        flex: auto;
        font-size: 1.5rem;
        margin: 0 1vw calc(3vw + 100px) 1vw; /*расстояние между продуктами*/
        /*min-width: calc(33% - 2vw);*/
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
        margin-top: 4px;
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
        margin: 8px 4;
        padding:2px 3;
    }
</style>