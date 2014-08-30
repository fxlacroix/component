<?php

namespace FXL\Component\Literacy\Sentence;

class Sentence
{
    /**
     * @var string
     */
    var $sentence;

    /**
     * @var array
     */
    var $silentE = array(
        "end" => array(
            'e'
        ),
        "begin" => array(
            'a', 'à', 'â', 'ä', 'á', 'ã', 'å',
            'i', 'î', 'ï', 'ì', 'í',
            'o', 'ô', 'ö', 'ò', 'ó', 'õ', 'ø',
            'u', 'ù', 'û', 'ü', 'ú',
            'e', 'é', 'è', 'ê', 'ë',
            'y', 'ÿ',
        )
    );


    var $letters = array(
        "v" => array("a", "e", "i", "o", "u", "y"),
        "c" => array("b", "c", "d", "f", "g", "h",
            "j", "k", "l", "m", "n", "p",
            "q", "r", "s", "t", "v", "w", "x", "z")
    );

    /**
     * @var array
     */
    var $ponctuation = array(".", "!", "?", ",", ";", ":", "'", "\"", "-");

    public function __construct($sentence = "")
    {
        $this->sentence = $sentence;
    }


    public function getStringFeet()
    {
        $words = $this->cutByWord();

        $syllables = array();

        foreach ($words as $word) {

            $o = new \FXL\Component\Literacy\Word\Syllable($word);

            $syllables = $this->concatArray($syllables, $o->getArraySyllables());

            unset($o);
        }

        $syllables = $this->concatSilentE($syllables);

        return implode($syllables, "/");
    }

    public function getArrayFeet()
    {
        $words = $this->cutByWord();

        $syllables = array();

        foreach ($words as $word) {

            $o = new \FXL\Component\Literacy\Word\Syllable($word);

            $syllables = $this->concatArray($syllables, $o->getArraySyllables());

            unset($o);
        }

        $syllables = $this->concatSilentE($syllables);

        return $syllables;
    }

    public function countFeet()
    {
        $feet = $this->getArrayFeet();

        return count($feet);

    }

    public function concatSilentE($syllables)
    {
        $total = count($syllables) - 1;

        $pattern = "/[^" . implode($this->letters['v']) . "][" . implode($this->silentE['end']) . "]#[" . implode($this->silentE['begin']) . "]/";

        $patternEnd = "/[" . implode($this->silentE['end']) . "]s?$/";

        // $syllables[$key - 1][strlen($syllables[$key - 1]);

        foreach ($syllables as $key => $syllable) {

            if (!isset($syllables[$key - 1])) {
                // apostrophe

            } elseif (!isset($syllables[$key + 1])) {

                if (preg_match($patternEnd, $syllable)) {

                    $syllables[$key - 1] .= $syllable;

                    unset($syllables[$key]);
                }


            } elseif (preg_match($pattern, $syllables[$key - 1] . "#" . $syllable)) {

                $syllables[$key - 1] .= $syllable;

                unset($syllables[$key]);
            }
        }

        return $syllables;
    }

    public function cutByWord()
    {
        $sentence = $this->format($this->sentence);
        $words = preg_split("/ /", $this->format($sentence));

        return $words;
    }

    public function format()
    {
        return strtolower(str_replace($this->ponctuation, array(" "), $this->sentence));
    }

    function concatArray($array1, $array2)
    {
        $out = array();
        foreach ($array1 as $key => $value) {
            $out[] = $value;
        }

        foreach ($array2 as $key => $value) {
            $out[] = $value;
        }

        return $out;
    }

}
