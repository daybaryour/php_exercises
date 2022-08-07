<?php

    // 3. TV Series
    // Populate a MySQL (InnoDB) database with data from at least 3 TV Series using the following structure:
    // tv_series -> (id, title, channel, gender);
    // tv_series_intervals -> (id_tv_series, week_day, show_time);
    // * Provide the SQL scripts that create and populate the DB;
    // Using OOP, write a code that tells when the next TV Series will air based on the current time-date or an
    // inputted time-date, and that can be optionally filtered by TV Series title.

    include "database/db_connect.php";
    include "sql_helpers/tvseries_sql_scripts.php";

    Class TvSeries extends DbConnect {
        public $is_db_populated;
        public $next_tv_series;

        public function __construct() {
            //checks if table exists --- Assumption if table exists then it is populated
            $sql_scripts = new SqlScripts;
            $sql_check_tables = $sql_scripts->checkTableExists();
            $run_query = $this->connect()->query($sql_check_tables)->fetchAll();

            if(count($run_query) == 2) {
                //2 Database tables are set go ahead
                $this->is_db_populated = true;
            } else {
                $this->is_db_populated = false;
            }
        }

        public function populateDatabase() {
            $sql_scripts = new SqlScripts;
            $sql_create_tv_series = $sql_scripts->createTvSeries();
            $sql_create_tv_series_intervals = $sql_scripts->createTvSeriesIntervals();
            $sql_default_populate_tv_series = $sql_scripts->defaultPopulateTvSeries();
            $sql_default_populate_tv_series_intervals = $sql_scripts->defaultPopulateTvSeriesIntervals();

            try {
                $run_query = $this->connect()->query($sql_create_tv_series . $sql_create_tv_series_intervals . $sql_default_populate_tv_series . $sql_default_populate_tv_series_intervals);
                echo ("Database populates successfully");
            } catch (Exception $e) {
                echo 'Message: ' .$e->getMessage();
            }
        }

        public function getNextTVSeries($time_date = "2022-08-09 06:35:00", $tv_series_title = "") {
            $additional_params = "";
            $execute_array = [];
            $sql_scripts = new SqlScripts;
            $sql_get_next_tv_series = $sql_scripts->getNextTvSeries();
            if (!$time_date) $time_date = date('Y-m-d h:i:s');

            if($tv_series_title) {
                $additional_params .= " WHERE tv_series.title LIKE '%".$tv_series_title."%' ";
            }

            $additional_params .= " ORDER BY FIELD (
                tv_intervals.week_day, 
                DAYOFWEEK('".$time_date."'),
                DAYOFWEEK('".$time_date."' + INTERVAL 1 DAY),
                DAYOFWEEK('".$time_date."' + INTERVAL 2 DAY),
                DAYOFWEEK('".$time_date."' + INTERVAL 3 DAY),
                DAYOFWEEK('".$time_date."' + INTERVAL 4 DAY),
                DAYOFWEEK('".$time_date."' + INTERVAL 5 DAY),
                DAYOFWEEK('".$time_date."' + INTERVAL 6 DAY)
                ) ASC,
                tv_intervals.show_time ASC
                LIMIT 1";

            $prepare_query = $this->connect()->query($sql_get_next_tv_series.$additional_params);
            $next_tv_series = $prepare_query->fetchAll();

            $this->next_tv_series = $next_tv_series;
        }
    }

    $tv_series = new TvSeries;
    //check if populate databse is true and go ahead and populate
    if (isset($_GET['populate_db'])) {
        //go ahead and populate the database
        $tv_series->populateDatabase();
        header('Location: /test3_next_tv_series.php');
    }

    if($tv_series->is_db_populated) {
        if ($_POST) {
            $tv_series_name = $_POST["series_name"];
            $tv_series_date = $_POST["series_date"];

            $tv_series->getNextTVSeries($tv_series_date, $tv_series_name);
        } else {
            $tv_series->getNextTVSeries();
        }
    }
?>


<html>
    <body>
        <?php if(!$tv_series->is_db_populated): ?>
            <div><a href="?populate_db=true">Populate database</a></div>
        <?php else: ?>
            <div>
                Next TV Series
                <?php print_r($tv_series->next_tv_series) ?>
            </div>
        <?php endif; ?>
    </body>
</html>


