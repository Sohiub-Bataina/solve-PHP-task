<?php
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
        return "Request not handled.";
    }
}

class LevelOneSupport extends Handler {
    public function handle($request) {
        if ($request === "basic issue") {
            return "Level One Support: I can handle this.";
        } else {
            return parent::handle($request);
        }
    }
}

class LevelTwoSupport extends Handler {
    public function handle($request) {
        if ($request === "intermediate issue") {
            return "Level Two Support: I can handle this.";
        } else {
            return parent::handle($request);
        }
    }
}

class LevelThreeSupport extends Handler {
    public function handle($request) {
        if ($request === "advanced issue") {
            return "Level Three Support: I can handle this.";
        } else {
            return parent::handle($request);
        }
    }
}

$levelOne = new LevelOneSupport();
$levelTwo = new LevelTwoSupport();
$levelThree = new LevelThreeSupport();

$levelOne->setNext($levelTwo)->setNext($levelThree);

echo $levelOne->handle("basic issue") . "<br>";        
echo $levelOne->handle("intermediate issue") . "<br>";  
echo $levelOne->handle("advanced issue") . "<br>";      
echo $levelOne->handle("unknown issue") . "<br>";       
?>
