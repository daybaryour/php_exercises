# php_exercises

Here is the EXADs Test Question

1. Prime Numbers
Write a PHP script that prints all integer values from 1 to 100.
Beside each number, print the numbers it is a multiple of (inside brackets and comma-separated). If
only multiple of itself then print “[PRIME]”.
2. ASCII Array
Write a PHP script to generate a random array containing all the ASCII characters from comma (“,”) to
pipe (“|”). Then randomly remove and discard an arbitrary element from this newly generated array.
Write the code to efficiently determine the missing character.
3. TV Series
Populate a MySQL (InnoDB) database with data from at least 3 TV Series using the following structure:
tv_series -> (id, title, channel, gender);
tv_series_intervals -> (id_tv_series, week_day, show_time);
* Provide the SQL scripts that create and populate the DB;
Using OOP, write a code that tells when the next TV Series will air based on the current time-date or an
inputted time-date, and that can be optionally filtered by TV Series title.
4. A/B Testing
Exads would like to A/B test some promotional designs to see which provides the best conversion rate.
Write a snippet of PHP code that redirects end users to the different designs based on the data
provided by this library: packagist.org/exads/ab-test-data

# Installation
1. Clone or Download repository
2. Create / Setup MySQL Database called 'exads'  Important that the name of the db
3. Run Composer Install
4. Start Simple php server using php -S localhost:8001
5. run your application from http://localhost:8001


# Minimum php Config 7.13, 
Solution was done on php 8.12 and MySQL 
No linting tools were used 
No Unit tests written 


# Dependencies
Conposer


#SQL files are in sql_helpers/tvseries_sql_helpers.php