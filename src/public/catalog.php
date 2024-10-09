<?php
session_start();
if (!isset($_SESSION['user_id'])){
    header('Location: /login');
}

require_once __DIR__ . "/classes/Catalog.php";
$catalog = new Catalog();
$products = $catalog->getCatalog();
?>

<h1>Catalog</h1>
<div class="back">
    <a href="/cart">&#128722;</a>
</div>

<div class="container">
    <?php foreach ($products as $product): ?>
        <div class="product">
            <div class="effect-1"></div>
            <div class="effect-2"></div>
            <div class="content">
                <img class="card-img-top" src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
            </div>
            <span class="title">
                <form action="/product" method="GET">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>" id="product_id">
                    <button type="submit" style="background: none; border: none; font-size: 20px; padding: 0; cursor: pointer;">
                        <?php echo $product['name']; ?>
                    </button>
                </form>
                <span><?php echo "{$product['price']}$" ?></span>
            </span>
        </div>
    <?php endforeach; ?>
</div>

<div class="twitter"><i class="fab fa-twitter"></i><a href="/logout">Logout</a></div>

<style>
    .back {
        position: fixed;
        top: 30px;
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
        max-width: 1200px;
        margin: 3vw auto;
        position: relative;
        text-align: center;
        width: 100vw;
    }

    .product {
        flex: auto;
        font-size: 1rem;
        margin: 0 1vw calc(1vw + 6%) 1vw;
        min-width: calc(34% - 8vw);
        position: relative;
    }

    .product:before {
        content: "";
        float: left;
        padding-top: 100%;
    }

    .content {
        background: white;
        border-radius: 30%;
        height: 84%;
        margin: 8%;
        position: absolute;
        width: 84%;
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
        height: 84%;
        opacity: 1;
        position: absolute;
        width: 84%;
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
        top: calc(100% + 0px);
    }

    .title span {
        display: block;
        font-family: Helvetica, Arial, Sans-Serif;
        font-size: 1.2rem;
        letter-spacing: 0.1rem;
        margin-top: 0;
        text-transform: uppercase;
    }

    .card-img-top {
        border-radius: 5px;
        height: 70%;
        margin: 15%;
        width: 70%;
    }

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
</style>