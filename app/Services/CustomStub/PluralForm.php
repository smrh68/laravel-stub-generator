<?php

namespace App\Services\CustomStub;

class PluralForm
{
    public static function make($word) {
        // Define some common rules for forming plurals
        $irregulars = array(
            'man' => 'men',
            'woman' => 'women',
            'child' => 'children',
            'person' => 'people',
            'ox' => 'oxen',
            'goose' => 'geese',
            // Add more irregular plural forms as needed
        );

        // Check if the word is in the list of irregular plurals
        if (array_key_exists($word, $irregulars)) {
            return $irregulars[$word];
        }

        // Apply general rules for forming plurals
        $lastChar = substr($word, -1);
        $secondLastChar = substr($word, -2, 1);

        if ($lastChar == 'y' && !in_array($secondLastChar, array('a', 'e', 'i', 'o', 'u'))) {
            // If the word ends with 'y' and the letter before 'y' is not a vowel, replace 'y' with 'ies'
            return substr($word, 0, -1) . 'ies';
        } elseif ($lastChar == 's' || $lastChar == 'x' || $lastChar == 'z' || $lastChar == 'o' && in_array($secondLastChar, array('a', 'e', 'i', 'o', 'u'))) {
            // If the word ends with 's', 'x', 'z', or 'o' preceded by a vowel, add 'es'
            return $word . 'es';
        } else {
            // Otherwise, just add 's' to the end of the word
            return $word . 's';
        }
    }
}
