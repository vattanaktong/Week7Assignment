<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <?php
    /* Advantages and disadvantages of multiple inheritence    
        /*Advantages:*/
        trait Lion {
            private $foodLion = "meat";
            public function getFoodLion(){
                return $this -> foodLion;
            }

            public function flag1(){
                echo " trait's flag1 called";
                echo "\n";
            }

            public function flag2(){
                echo " trait's flag2 called";
                echo "\n";
            }
        }

        trait vegetables {
            private $foodVegetable = "vegetables";
            public function getFoodVegetable(){
                return $this -> foodVegetable;
            }

            public function flag3(){
                echo "vegetables's trait's flag3 called";
                echo "\n";
            }
        }

        class Deer{
            use Lion;
            use vegetables;

            private $Deer_food;

            public function __construct(){
                //we can use both functions from different classes
                $this -> Deer_food  = ($this -> getFoodLion())."+".($this -> getFoodVegetable()); 
            }

            public function getDeerFood(){
                return $this -> Deer_food;
            }

            public function flag4(){
                echo "Deer flag4 is called";
                echo "\n";
            }

            public function flag5(){
                echo "Deer flag 5 is called";
                echo "\n";
            }
        }

        $person1 = new Deer();
        $person1 -> flag1();
        $person1 -> flag3();
        $person1 -> getDeerFood();
        echo $person1-> getFoodLion();
        echo "\n"; 
        echo $person1 -> getFoodVegetable();
        echo "\n";
        echo $person1 -> getDeerFood();
        echo "\n";
        $person1 -> flag2(); 
        
        /*Disadvantages*/

        trait Hi{
            public function welcome(){
                echo "Hi";
                echo "\n";
            }
        }

        trait Hello{
            public function welcome(){
                echo "Hello";
                echo "\n";
            }
        }

        class Person{
            use Hi;
            use Hello;
        }
        $person2 = new Person();
        $person2 -> greet();
    ?>
</body>
</html>