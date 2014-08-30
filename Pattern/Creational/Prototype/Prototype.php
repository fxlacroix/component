<?php

namespace FXL\Component\Pattern\Creational;

abstract class BookPrototype
{
    protected $title;
    protected $topic;

    abstract function __clone();

    function getTitle()
    {
        return $this->title;
    }

    function setTitle($titleIn)
    {
        $this->title = $titleIn;
    }

    function getTopic()
    {
        return $this->topic;
    }

}

class PHPBookPrototype extends BookPrototype
{

    function __construct()
    {
        $this->topic = 'PHP';
    }

    function __clone()
    {

    }

}

class SQLBookPrototype extends BookPrototype
{

    function __construct()
    {
        $this->topic = 'SQL';
    }

    function __clone()
    {

    }

}

writeln('BEGIN TESTING PROTOTYPE PATTERN');
writeln('');

$phpProto = new PHPBookPrototype();
$sqlProto = new SQLBookPrototype();

$book1 = clone $sqlProto;
$book1->setTitle('SQL For Cats');
writeln('Book 1 topic: ' . $book1->getTopic());
writeln('Book 1 title: ' . $book1->getTitle());
writeln('');

$book2 = clone $phpProto;
$book2->setTitle('OReilly Learning PHP 5');
writeln('Book 2 topic: ' . $book2->getTopic());
writeln('Book 2 title: ' . $book2->getTitle());
writeln('');

$book3 = clone $sqlProto;
$book3->setTitle('OReilly Learning SQL');
writeln('Book 3 topic: ' . $book3->getTopic());
writeln('Book 3 title: ' . $book3->getTitle());
writeln('');

writeln('END TESTING PROTOTYPE PATTERN');

function writeln($line_in)
{
    echo $line_in . "<br/>";
}

class SubObject
{
    static $instances = 0;
    public $instance;

    public function __construct()
    {
        $this->instance = ++self::$instances;
    }

    public function __clone()
    {
        $this->instance = ++self::$instances;
    }

}

class MyCloneable
{
    public $object1;
    public $object2;

    function __clone()
    {
        // Force a copy of this->object, otherwise it will point to same object.
        $this->object1 = clone $this->object1;
    }

}

$obj = new MyCloneable();

$obj->object1 = new SubObject();
$obj->object2 = new SubObject();

$obj2 = clone $obj;

print("Original Object:\n");
print_r($obj);

print("Cloned Object:\n");
print_r($obj2);
