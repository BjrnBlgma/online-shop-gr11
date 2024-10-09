<?php
session_start();
if (!isset($_SESSION['user_id'])){
    header('Location: /login');
    exit;
}

$userId = $_SESSION['user_id'];
$pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname=mydb', 'user', 'pass');

$stmt = $pdo->prepare("SELECT * FROM products");
$stmt->execute();
$products = $stmt->fetchAll();
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
                <img class="card-img-top" src="<?php echo htmlspecialchars($product['image']); ?>" alt="Product Image">
            </div>
            <span class="title">
                <a href="/product.php?id=<?php echo $product['id']; ?>">
                    <?php echo htmlspecialchars($product['name']); ?>
                </a>
                <span><?php echo htmlspecialchars($product['price']) . "$"; ?></span>
            </span>
        </div>
    <?php endforeach; ?>
</div>

<!--<div class="twitter"><i class="fab fa-twitter"></i><a href="/logout">Logout</a></div>
<div class="card">
    <nav>
        <a href="/catalog">
        <svg class="arrow" version="1.1" viewBox="0 0 512 512" width="512px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><polygon points="352,115.4 331.3,96 160,256 331.3,416 352,396.7 201.5,256 " stroke="#727272"/></svg>
        Back to catalog</a>
        <svg class="heart" version="1.1" viewBox="0 0 512 512" width="512px" xml:space="preserve" stroke="#727272" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M340.8,98.4c50.7,0,91.9,41.3,91.9,92.3c0,26.2-10.9,49.8-28.3,66.6L256,407.1L105,254.6c-15.8-16.6-25.6-39.1-25.6-63.9  c0-51,41.1-92.3,91.9-92.3c38.2,0,70.9,23.4,84.8,56.8C269.8,121.9,302.6,98.4,340.8,98.4 M340.8,83C307,83,276,98.8,256,124.8  c-20-26-51-41.8-84.8-41.8C112.1,83,64,131.3,64,190.7c0,27.9,10.6,54.4,29.9,74.6L245.1,418l10.9,11l10.9-11l148.3-149.8  c21-20.3,32.8-47.9,32.8-77.5C448,131.3,399.9,83,340.8,83L340.8,83z" stroke="#727272"/></svg>
    </nav>
    <div class="photo">
        <img src="<?php /*echo $product['image']; */?>" alt="<?php /*echo $product['name']; */?>">
    </div>
    <div class="description">
        <h2><?php /*echo $product['name']; */?></h2>
        <!--<h4>Popular House Plant</h4>-->
        <h1><?php /*echo "{$product['price']}$" */?></h1>
        <p><?php /*echo $product['description']; */?></p>
        <button>Add to Cart</button>
        <button>Wishlist</button>
    </div>
</div>-->

<style>
    @import url(https://fonts.googleapis.com/css?family=Raleway:400,300,500,700);
    * { box-sizing: border-box; }

    body {

        background: #aedaa6;
        font-family: "Raleway";

        .card {

            width: 650px;
        // height: 375px;
            position: absolute;
            background: white;
            margin: 0 auto;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            box-shadow: 0 2px 5px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12);
            transition: all 0.3s;

            &:hover {

                box-shadow: 0 8px 17px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);

            }

            nav {

                width: 100%;
                color: #727272;
                text-transform: uppercase;
                padding: 20px;
                border-bottom: 2px solid #efefef;
                font-size: 12px;

                svg.heart {

                    height: 24px;
                    width: 24px;
                    float: right;
                    margin-top: -3px;
                    transition: all 0.3s ease;
                    cursor: pointer;

                    &:hover {

                        fill: red;

                    }

                }
                svg.arrow {

                    float: left;
                    height: 15px;
                    width: 15px;
                    margin-right: 10px;

                }

            }

            .photo {

                padding: 30px;
                width: 45%;
                text-align: center;
                float: left;

                img {
                    height: 100%;
                    width: 100%;
                }

            }

            .description {

                padding: 30px;
                float: left;
                width: 55%;
                border-left: 2px solid #efefef;

                h1 {
                    color: #515151;
                    font-weight: 300;
                    padding-top: 15px;
                    margin: 0;
                    font-size: 30px;
                    font-weight: 300;
                }

                h2 {
                    color: #515151;
                    margin: 0;
                    text-transform: uppercase;
                    font-weight: 500;
                }

                h4 {
                    margin: 0;
                    color: #727272;
                    text-transform: uppercase;
                    font-weight: 500;
                    font-size: 12px
                }

                p {
                    font-size: 12px;
                    line-height: 20px;
                    color: #727272;
                    padding: 20px 0;
                    margin: 0;
                }

                button {

                    outline: 0;
                    border: 0;
                    background: none;
                    border: 1px solid #d9d9d9;
                    padding: 8px 10px;
                    margin-bottom: 30px;
                    color: #515151;
                    text-transform: uppercase;
                    width: 125px;
                    font-family: inherit;
                    margin-right: 5px;
                    transition: all 0.3s ease;
                    font-weight: 500;

                    &:hover {

                    // background: darken(white, 2%);
                        border: 1px solid #aedaa6;
                        color: #aedaa6;
                        cursor: pointer;

                    }

                }

            }

        }

    }
</style>