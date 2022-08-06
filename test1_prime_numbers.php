<?php
    // Write a PHP script that prints all integer values from 1 to 100.
    // Beside each number, print the numbers it is a multiple of (inside brackets and comma-separated). If
    // only multiple of itself then print “[PRIME]”.
    declare(strict_types=1);

    class PrintIntegersWithPrimes { //Declare class print integers with primes
        /**
         * Public function to get all integers within range and corresponding prime numbers
         * @param null
         * @return Array 
         */
        public function getIntegersAndPrimes() { 
            $all_numbers = []; //empty array to house all the numbers within range

            for ($i = 1; $i <= 100; $i++) { //for loop with the required range between 1 and 100 for all numbers
                $valid_primes = [];

                for ($j = 2; $j <= $i; $j++) { //second loop to account for divisible numbers and getting prime function
                    if ($i % $j == 0 && $i != $j) { //divisible and not equal to original number go ahead and add to the 
                        $valid_primes[] = $j;
                    }
                }

                $all_numbers[] = $valid_primes; //push numbers with their valid primes into the all numbers response
            }

            return $all_numbers;
        }

        /**
         * public method to display result of the integers and prime (not writing a global result display method maybe some todo something for my free time)
         * @param Array
         * @return String
         */
        public function displayResult($result_array) {
            foreach($result_array as $key => $array) {
                echo $key + 1 ." ";  //counting key plus one
                echo count($array) ? "[" . implode(", ", $array) . "]" : "[PRIME]"; //ternary for the validation of array values and prime
                echo "<br />"; //next line
            }
        }
    }

    $printIntegers = new PrintIntegersWithPrimes; //Instantiate the class

    $getIntegersAndPrimes = $printIntegers->getIntegersAndPrimes(); //first method trigger
    $printIntegers->displayResult($getIntegersAndPrimes); //second method trigger