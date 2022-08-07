<?php
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
                ('Breaking Bad','AMC','neo-western crime drama'),
                ('The Last Dance','Netflix','sports documentary'),
                ('The Last Dance','Netflix','sports documentary'),
                ('The Last Dance','Netflix','sports documentary'),
                ('The Last Dance','Netflix','sports documentary'),
                ('Game of Thrones','HBO','fantasy drama'); ";
        }

        public function defaultPopulateTvSeriesIntervals() {
            return "INSERT INTO tv_series_intervals (id_tv_series, show_time, week_day)
            VALUES
                (1, '22:00:00', '1'),
                (1, '23:00:00', '2'),
                (2, '04:00:00', '3'),
                (2, '15:00:00', '4'),
                (3, '16:00:00', '5'); ";
        }

        public function getNextTvSeries() {
            return "SELECT * FROM tv_series INNER JOIN tv_series_intervals tv_intervals ON tv_series.id=tv_intervals.id_tv_series";
        }
    }