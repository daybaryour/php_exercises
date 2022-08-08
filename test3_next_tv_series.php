<?php

    // 3. TV Series
    // Populate a MySQL (InnoDB) database with data from at least 3 TV Series using the following structure:
    // tv_series -> (id, title, channel, gender);
    // tv_series_intervals -> (id_tv_series, week_day, show_time);
    // * Provide the SQL scripts that create and populate the DB;
    // Using OOP, write a code that tells when the next TV Series will air based on the current time-date or an
    // inputted time-date, and that can be optionally filtered by TV Series title.

    include "database/db_connect.php"; //Including database connection here , using PDO to access our database
    include "sql_helpers/tvseries_sql_scripts.php"; //created SQL helper functions, I feel this scripts could be better optimized but for this tests purpose we move

    /**
     * TV series for populating an getting the next tv series
     * Class implements the Database Connection Class (Some cases if it's to be used everywhere can be autoloaded)
     */
    Class TvSeries extends DbConnect {
        public $is_db_populated; //our variable flag to check if database table has been created
        public $next_tv_series; //Our variable flag (where we assign the next tv series)
        public $weekdays = [
            0 => 'Monday', 1 => 'Tuesday', 2 => 'Wednesday', 3 => 'Thursday', 4 => 'Friday', 5 => 'Saturday', 6 => 'Sunday'
        ];
        /**
         * Constructor does 2 things
         * 1. Checks if table has been created
         * 2. updates the db populated variable based on 1 above
         */
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

        /**
         * populates the database with initial (default data)
         * Here we created a trigger in the view to populate the database
         * @param null
         * @return String
         */
        public function populateDatabase() {
            $sql_scripts = new SqlScripts; //get sql scripts class
            $sql_create_tv_series = $sql_scripts->createTvSeries();
            $sql_create_tv_series_intervals = $sql_scripts->createTvSeriesIntervals();
            $sql_default_populate_tv_series = $sql_scripts->defaultPopulateTvSeries();
            $sql_default_populate_tv_series_intervals = $sql_scripts->defaultPopulateTvSeriesIntervals();

            //Exception handling for the table run error
            try {
                $run_query = $this->connect()->query($sql_create_tv_series . $sql_create_tv_series_intervals . $sql_default_populate_tv_series . $sql_default_populate_tv_series_intervals);
                echo ("Database exads populated successfully");
            } catch (Exception $e) {
                echo 'Message: ' .$e->getMessage();
            }
        }

        /**
         * get next tv series based on passed time or current time and/or an optional series title
         * @param Date $time_date defaulted to null 
         * @param String $tv_series_title defaulted to an empty string
         */
        public function getNextTVSeries($time_date = null, $tv_series_title = "") {
            $additional_params = "";
            $execute_array = [];
            $sql_scripts = new SqlScripts;
            
            if (!$time_date) { //if there is no time set default to current time
                $date = date('Y-m-d'); 
                $time_date = date('Y-m-d h:i:s'); 
            } else {
                $date = date('Y-m-d', strtotime($time_date));
                $time_date = date('Y-m-d h:i:s', strtotime($time_date));
            } 
            $execute_array = ['date' => $date, 'datetime' => $time_date];

            $sql_get_next_tv_series = $sql_scripts->getNextTvSeries();

            if($tv_series_title) {
                $additional_params .= " WHERE tv_series.title LIKE '%".$tv_series_title."%' ";
            }

            //sql params for ordering by field (Dirty hack should have kept it in the sql helpers function, also using the inbuilt mysql day of week function)
            $additional_params .= " ORDER BY next_show_time ASC, tv_intervals.week_day ASC,
                tv_intervals.show_time ASC LIMIT 1";

            
            $prepare_query = $this->connect()->prepare($sql_get_next_tv_series.$additional_params); //prepare statement
            $prepare_query->execute($execute_array); //Execute prepared statement



            $next_tv_series = $prepare_query->fetchAll();

            $this->next_tv_series = $next_tv_series;
        }
    }

    $tv_series = new TvSeries;

    //check if populate databse is true and go ahead and populate
    if (isset($_GET['populate_db'])) {
        //go ahead and populate the database
        $tv_series->populateDatabase();
        header('Location: /test3_next_tv_series.php'); //redirect back to original page
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
    <head>
        <link re
    </head>
    <body>
        <?php if(!$tv_series->is_db_populated): ?>
            <div><a href="?populate_db=true">Populate database</a></div>
        <?php else: ?>
            <div>
                
                <form action="" method="POST">
                    <input type="text" name="series_name" placeholder="filter by name or a part of the name" /> <br/>
                    <input type="datetime-local" name="series_date" /> <br />

                    <input type="submit" />
                </form>
                <div>
                    <h2>Next TV Series </h2>
                    <ul>
                        <?php foreach($tv_series->next_tv_series as $curr_series): ?>
                            <li><?= $curr_series['title'] ?></li>
                            <li><?= $curr_series['channel'] ?></li>
                            <li><?= $curr_series['genre'] ?></li>
                            <li><?= $curr_series['show_time'] ?></li>
                            <li><?= $tv_series->weekdays[$curr_series['week_day']] ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        <?php endif; ?>
    </body>
</html>


