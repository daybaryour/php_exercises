<?php
    // Exads would like to A/B test some promotional designs to see which provides the best conversion rate.
    // Write a snippet of PHP code that redirects end users to the different designs based on the data
    // provided by this library: packagist.org/exads/ab-test-data
    // The data will be structured as follows:
    // “promotion” => [
            // “id” => 1,
            // “name” => “main”,
            // “designs” => [
                    // [ “designId” => 1, “designName” => “Design 1”, “splitPercent” => 50 ],
                    // [ “designId” => 2, “designName” => “Design 2”, “splitPercent” => 25 ],
                    // [ “designId” => 3, “designName” => “Design 3”, “splitPercent” => 25 ],
            //     ]
            // ]
    // The code needs to be object-oriented and scalable. The number of designs per promotion may vary.

    namespace exadsTest4;
    use Exads\ABTestData; //using library pulled from composer

    include_once './vendor/autoload.php'; //vendor autoload


    class AbTesting
    {
        /**
         * getData as stipulated from the main forms
         */
        public function getData(int $promoId): array
        {
            $abTest = new ABTestData($promoId);
            $promotion = $abTest->getPromotionName();
            $designs = $abTest->getAllDesigns();

            $item_data_array = ['id' => $promoId, 'name' => $promotion, 'designs' => $designs];
            return $item_data_array;
        }
    }

    /**
     * Display AB testing class extends AB testing
     */
    class DisplayAbTesting extends AbTesting {
        public $rand_promo_id;
        public function __construct() {
            $this->rand_promo_id = rand(1, 3); //must be between 1 and 3
        }

        /**
         * Basicallu format the unique url for the designs
         * @param Array
         * 
         */
        public function formatAbTestUrl($design_array) {
            return http_build_query($design_array); //format url using php http_build_query
        }
    }

    $ab_tests = new DisplayAbTesting;
    $ab_tests_data = $ab_tests->getData($ab_tests->rand_promo_id);
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
                <a href="/index.php">Click to Go back to indexpage </a>
            </div>
            <div>
                <h2> Promotion name :- <?= $ab_tests_data['name'] ?></h2>
                <h4> Promotion id :- <?= $ab_tests_data['id'] ?></h4>
            </div>
            <hr />

            <div class"clearfix block">
                <table border=1>
                    <thead>
                        <tr>
                            <td>Design ID</td>
                            <td>Design Name</td>
                            <td>Split Percent</td>
                            <td>Unique URL</td>
                        </tr>
                    </thead>
                    <?php foreach($ab_tests_data['designs'] as $design): ?>
                        <tr>
                            <td><?= $design['designId'] ?></td>
                            <td><?= $design['designName'] ?></td>
                            <td><?= $design['splitPercent'] ?></td>
                            <td>
                                <a href="test4_display_design.php?<?= $ab_tests->formatAbTestUrl($design) ?>&name=<?= $ab_tests_data['name'] ?>&promo_id=<?= $ab_tests_data['id'] ?>">Click here to view design url</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </section>
    </body>
</html>

