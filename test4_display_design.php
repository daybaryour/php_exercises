<?php
    $design_id = isset($_GET["designId"]) ? $_GET["designId"] : "";
    $design_name = isset($_GET["designName"]) ? $_GET["designName"] : "";
    $split_percent = isset($_GET["splitPercent"]) ? $_GET["splitPercent"] : "";
    $promo_name = isset($_GET["name"]) ? $_GET["name"] : "";
    $promo_id = isset($_GET["promo_id"]) ? $_GET["promo_id"] : "";
?>

<html>
    <head>
        <link rel="stylesheet" href="./assets/styles.css?v=<?php echo time(); ?>" type="text/css">
    </head>
    <body>
        <section class="wrapper">
            <div>
                <img src="https://images.g2crowd.com/uploads/product/image/social_landscape/social_landscape_05ecef678030605552627cc6ad335478/exads.png" height="100" />
            </div>
            <div>
                <a href="/test4_ab_test.php"><<< Click to Go Back </a>
            </div>
            <div>
                <h2> Promotion Name -- <?= $promo_name ?> </h2>
            </div>
            <div>
                <ul>
                    <li>Design ID -- <?= $design_id ?></li>
                    <li>Design Name -- <?= $split_percent ?></li>
                    <li>Split Percent -- <?= $split_percent ?></li>
                </ul>
            </div>
        </section>
    </body>
</html>