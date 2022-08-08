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
    use Exads\ABTestData;

    include_once './vendor/autoload.php';


    class AbTesting
    {
        public function getData(int $promoId): array
        {
            $abTest = new ABTestData($promoId);
            $promotion = $abTest->getPromotionName();
            $designs = $abTest->getAllDesigns();

            $item_data_array = ['id' => $promoId, 'name' => $promotion, 'designs' => $designs];
            return $item_data_array;
        }
    }

    class DisplayAbTesting extends AbTesting {
        public $rand_promo_id;
        public function __construct() {
            $this->rand_promo_id = rand(1, 3);
        }

        public function formatAbTestUrl($design_array) {
            return http_build_query($design_array);
        }
    }

    $ab_tests = new DisplayAbTesting;
    $ab_tests_data = $ab_tests->getData($ab_tests->rand_promo_id);
?>


<html>
    <body>
        <h2> Promotion name :- <?= $ab_tests_data['name'] ?></h2>

        <div>
            <ul>
                <?php foreach($ab_tests_data['designs'] as $design): ?>
                    <li><a href="test4_display_design.php?<?= $ab_tests->formatAbTestUrl($design) ?>&name=<?= $ab_tests_data['name'] ?>&promo_id=<?= $ab_tests_data['id'] ?>">Click here to view design url</a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </body>
</html>

