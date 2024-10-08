<?php
if (!isset($_SESSION['user_id'])){
    header('Location: /login');
}
session_start();
$userId = $_SESSION['user_id'];
//echo 'here is Catalog';
$pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname=mydb', 'user', 'pass');

$stmt = $pdo->prepare("SELECT * FROM products");
$stmt->execute();
$products = $stmt->fetchAll();

/*$stmt = $pdo->prepare("SELECT products.name as product_name, products.image as product_image, products.price as product_price, user_products.amount as user_products_amount FROM user_products INNER JOIN products ON products.id = user_products.product_id  WHERE user_id = :user_id");
$stmt->execute(['user_id' => $userId]);

$countProductsUnderCart = $stmt->fetchAll();
$count = count($countProductsUnderCart);*/

?>

<h1>Catalog</h1>
<div class="back">
    <a href="/cart " >&#128722;</a>
</div>

<div class="container">
    <?php foreach ($products as $product): ?>
        <div class="product">
            <div class="effect-1"></div>
            <div class="effect-2"></div>
            <div class="content">
                <img class="card-img-top" src="<?php echo $product['image']; ?>">
                <!--<div class="exercise"  ></div>-->

            </div>
            <span class="title">
                <!--<a href="/add" >  якорь для клика </a>-->
                <?php echo $product['name']; ?>
                <span> <?php echo "{$product['price']}$" ?> </span>
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
        max-width: 600px;
        margin: 1vw auto;
        position: relative;
        text-align: center;
        width: 94vw;
    }

    .product {
        flex: auto;
        font-size: 1.5rem;
        margin: 0 1vw calc(1vw + 50px) 1vw;
        min-width: calc(33% - 2vw);
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
        top: calc(100% + 16px);
    }

    .title span {
        display: block;
        font-family: Helvetica, Arial, Sans-Serif;
        font-size: 0.6rem;
        letter-spacing: 0.1rem;
        margin-top: 8px;
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
</style>



