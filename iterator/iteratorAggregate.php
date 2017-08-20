<?php

class Vowel implements IteratorAggregate
{
    private $vowel;

    public function __construct()
    {
        $this->vowel = ["a","e","i","o","u"];
    }

    public function getIterator()
    {
        return new ArrayIterator($this->vowel);
    }
}

class Properties implements IteratorAggregate
{
    private $property1 = "1";
    protected $property2 = "2";
    public $property3 = "3";

    public function __construct() {
        $this->property4 = "4";
    }

    public function getIterator()
    {
        return new ArrayIterator($this);
    }
}

$vowels = new Vowel();

foreach($vowels as $vowel) {
    echo $vowel;
}

$properties = new Properties();

foreach($properties as $key => $property) {
    echo $key . ":" . $property;
}