<?php
    //SQL Scripts Helpers lazy methods to return sql scripts of the TV series function
    Class SqlScripts {
        public function checkTableExists() {
            return "SELECT table_name FROM information_schema.tables WHERE table_schema = 'exads' AND table_name = 'tv_series' OR table_name = 'tv_series_intervals';";
        }

        public function createTvSeries() {
            return "CREATE TABLE IF NOT EXISTS `tv_series` (
                `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `title` VARCHAR(255) NOT NULL,
                `channel` VARCHAR(255) NOT NULL,
                `genre` VARCHAR(255) NOT NULL
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE 'utf8mb4_unicode_ci' ENGINE = INNODB; ";
        }

        public function createTvSeriesIntervals() {
            return "CREATE TABLE IF NOT EXISTS `tv_series_intervals` (
                `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `id_tv_series` BIGINT UNSIGNED NOT NULL,
                `show_time` TIME NOT NULL,
                `week_day` TINYINT(1) UNSIGNED NOT NULL
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE 'utf8mb4_unicode_ci' ENGINE = INNODB;
        
            ALTER TABLE `tv_series_intervals` ADD CONSTRAINT `tv_series_intervals_tv_series_id_foreign`
            FOREIGN KEY (`id_tv_series`) REFERENCES `tv_series` (`id`); ";
        }

        public function defaultPopulateTvSeries() {
            return "INSERT INTO tv_series (title, channel, genre)
            VALUES
                ('Suits','Netflix','Legal drama'),
                ('Breaking Bad','AMC','Neo-Western crime drama '),
                ('How i met your mother','CBS','sitcom romantic comedy'),
                ('Kyle XY','ABC Family','science Fiction, teen drama'),
                ('House of Cards','Netflix','Political Drama'),
                ('Game of Thrones','HBO','fantasy drama'); ";
        }

        public function defaultPopulateTvSeriesIntervals() {
            return "INSERT INTO tv_series_intervals (id_tv_series, show_time, week_day)
            VALUES
                (1, '22:00:00', '1'),
                (1, '23:00:00', '2'),
                (2, '04:00:00', '3'),
                (3, '04:00:00', '1'),
                (4, '08:00:00', '6'),
                (6, '04:00:00', '1'),
                (2, '21:00:00', '3'),
                (5, '09:00:00', '2'),
                (6, '15:00:00', '4'),
                (3, '16:00:00', '5'); ";
        }

        public function getNextTvSeries() {
            return "SELECT tv_series.id, title, channel, genre, week_day, show_time, WEEKDAY(:date) AS curr_weekday , CONCAT(DATE_ADD(:date, INTERVAL IF(WEEKDAY(:date) >= week_day, IF(WEEKDAY(:date) - week_day = 0, 0, 7-WEEKDAY(:date) + week_day), week_day - WEEKDAY(:date)) DAY),' ', show_time) AS next_show_time FROM tv_series INNER JOIN tv_series_intervals as tv_intervals ON tv_series.id = tv_intervals.id_tv_series";
        }
    }