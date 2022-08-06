<?php

    // 2. ASCII Array
    // Write a PHP script to generate a random array containing all the ASCII characters from comma (“,”) to
    // pipe (“|”). Then randomly remove and discard an arbitrary element from this newly generated array.
    // Write the code to efficiently determine the missing character.

    // Class to Generate Ascii Array
    // Class includes method to allow for randomization of array 
    class GenerateRandomAsciiArray {
        const ascii_start = 44; //declaring start ascii character ","
        const ascii_end = 124; //declaring end ascii character "|"
        public $ascii_array; // Class variable we will populate this with the ascii array start and end here

        /**
         * Constructor to populate the ascii characters into an array
         * @param null
         * @return Array  ascii array
         */
        public function __construct() {
            for ($i=44; $i <= 124; $i++) 
            { 
                $ascii_array[] = utf8_encode(chr($i));
            }
            $this->ascii_array = $ascii_array;
        }

        /**
         * Function to randomize Any array using the shuffle function (other methods can be used here no special reason to shuffle)
         * @param Array array to be randomized
         * @return Array randomized array
         */
        public function randomizeArray() { //passing the unshuffled array here instead of instantiation the object again to prevent repeat looping of the constructor
            shuffle($this->ascii_array); //php inbuilt shuffle
            return $this->ascii_array;
        }
    }

    /**
     * Class to Discard random element from any array (In this case our random array)
     * @extends Generate Random Ascii Array
     */
    class DiscardArbitraryElement extends GenerateRandomAsciiArray {
        /**
         * Remove random element from array
         * @param Array shuffled array
         * @return Array array without one element
         */
        public function discardRandomElement($shuffled_array) {
            //generate a random number between 0 and length of the array // added a quick check for an empty array to default to 1
            $array_length = count($shuffled_array) ? count($shuffled_array) : 1;
            $key = rand(0, $array_length - 1);

            array_splice($shuffled_array, $key, 1); //using php splice to remove one element from the array
            return $shuffled_array;
        }
    }

    /**
     * Compares Missings Arrays and retuens the difference
     * Wanted to place the ascii solution method outside of the class but then ...
     */
    class DifferentiateMissingCharacter extends DiscardArbitraryElement {
        /**
         * Return an array with the intersection of what is in one array and missing in the other one
         * @param Array randomized array
         * @param Array Array with one random Element removed
         * @return Array with the intersection of both arrays
         */
        public function arrayDiffMissingCharacter($randomized_array, $discardedArray) {
            $difference = array_diff($randomized_array, $discardedArray); //using php array diff to intersect both arrays

            return $difference;
        }

        /**
         * FUnction that solves the whole thing
         * @param null
         * @return Array
         */
        public function AsciiArraySolution() {
            $randomized_array = $this->randomizeArray(); //This triggers the new array and randomizes it
            
            $discardedAsciiArray = $this->discardRandomElement($randomized_array); //Elimitates the single element from the randomized array          
            $getMissingCharacterArray = $this->arrayDiffMissingCharacter($randomized_array, $discardedAsciiArray); //intersects both arrays

            return $getMissingCharacterArray;
        }
    }

    $differentiateMissingCharacter = new DifferentiateMissingCharacter; //Initiating Class which extends other classes
    $missingCharArray = $differentiateMissingCharacter->AsciiArraySolution(); //Solves the problem for us

    //join the missing character array
    $missingCharacter = join('', $missingCharArray);

    print($missingCharacter);


