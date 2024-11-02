<?php
$r = 3;
function g(){
     global $r;
     $r++;
     echo $r;
}
g();
echo $r;
return;
// Base handler class
abstract class Handler {
    protected $nextHandler;

    public function setNext(Handler $handler) {
        $this->nextHandler = $handler;
        return $handler;
    }

    public function handle($request) {
        if ($this->nextHandler) {
            return $this->nextHandler->handle($request);
        }
        return $request;
    }
}

// First handler: Filters even numbers
class EvenNumberHandler extends Handler {
    public function handle($request) {
        $filtered = array_filter($request, function($number) {
            return $number % 2 === 0;
        });
        return parent::handle($filtered);
    }
}

// Second handler: Limits to a max of 10 numbers
class LimitHandler extends Handler {
    private $limit;

    public function __construct($limit) {
        $this->limit = $limit;
    }

    public function handle($request) {
        $limited = array_slice($request, 0, $this->limit);
        return parent::handle($limited);
    }
}

// Third handler: Prints the result
class PrintHandler extends Handler {
    public function handle($request) {
        print_r($request);
        return parent::handle($request);
    }
}

// Create an array with numbers from 1 to 100
$numbers = range(1, 100);

// Set up the chain
$evenNumberHandler = new EvenNumberHandler();
$limitHandler = new LimitHandler(10);
$printHandler = new PrintHandler();

$evenNumberHandler->setNext($limitHandler)->setNext($printHandler);

// Process the request (array of numbers)
$evenNumberHandler->handle($numbers);
