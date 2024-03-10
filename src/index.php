<?php

class CalculatorDTO
{
    public $firstNumber;
    public $secondNumber;
    public $result;
}

interface HandlerInterface
{
    public function handle(CalculatorDTO $dto): void;
}

class AddStrategy implements HandlerInterface
{
    public function handle(CalculatorDTO $dto): void
    { 
        $dto->result = $dto->firstNumber + $dto->secondNumber;
    }

    public function getName(){
        return 'Сложение';
    }
}

class SubStrategy implements HandlerInterface
{
    public function handle(CalculatorDTO $dto): void
    {
        $dto->result = $dto->firstNumber - $dto->secondNumber;
    }

    public function getName(){
        return 'Вычитание';
    }
}

class MultStrategy implements HandlerInterface
{
    public function handle(CalculatorDTO $dto): void
    {
        $dto->result = $dto->firstNumber * $dto->secondNumber;   
    }

    public function getName(){
        return 'Умножение';
    }
    
}

class DivStrategy implements HandlerInterface{
    public function handle(CalculatorDTO $dto): void
    {
        $dto->result = $dto->firstNumber / $dto->secondNumber;
    }

    public function getName(){
        return 'Деление';
    }
}

class CalcutlatorHandler implements HandlerInterface
{
    private $strategies;
   
    public function __construct()
    {
        $this->strategies = [
          new AddStrategy(),
          new SubStrategy(),
          new MultStrategy(),
          new DivStrategy()
        ];
    }
    
    public function handle(CalculatorDTO $dto): void
    {
        $i = 0;
        $itter = 1;
        $combinations = [];
        $flag = true;
        while ($flag){
            shuffle($this->strategies);
            echo "<br>";
            foreach ($this->strategies as $strategy) {
                if ($strategy->getName() === "Сложение" && $dto->result >= 0 ) {
                    $strategy->handle($dto);
                    echo $strategy->getName(). ". Результат: " . $dto->result . "<br>";
                    $i++;
                    $combinations[] = $strategy->getName();
                }

                if ($strategy->getName() === "Умножение" && $dto->result > 10) {
                    $strategy->handle($dto);
                    echo $strategy->getName(). ". Результат: " . $dto->result . "<br>";
                    $i++;
                    $combinations[] = $strategy->getName();
                }

                if ($strategy->getName() === "Деление" && $dto->result > 1000) {
                    $strategy->handle($dto);
                    echo $strategy->getName(). ". Результат: " . $dto->result . "<br>";
                    $i++;
                    $combinations[] = $strategy->getName();
                }

                if ($strategy->getName() === "Вычитание" && $dto->result < 1000 ) {
                    $strategy->handle($dto);
                    echo $strategy->getName(). ". Результат: " . $dto->result . "<br>";
                    $i++;
                    $combinations[] = $strategy->getName();
                }
               
                if(($i == 4) &&
                    !($strategy->getName() === "Сложение" && $dto->result >= 0 ) &&
                    !($strategy->getName() === "Умножение" && $dto->result > 10)&&
                    !($strategy->getName() === "Деление" && $dto->result > 1000) &&
                    !($strategy->getName() === "Вычитание" && $dto->result < 1000))
                    {
                        echo "------↑Удачная комбинация↑------" . "<br>";
                        print_r((array_slice($combinations,-4)));
                        echo "Выполненно итераций: $itter";
                        $flag = false;
                        
                    }
                }
            if ($dto->result < 0) {
                break;
            }
            $itter++;
            $i = 0;
        }  
        
    }
    
}


echo "Найдена удачная комбинация" . "<br>";
$dto = new CalculatorDTO();
echo "Число 1 - " . ($dto->firstNumber =85) . "<br>";
echo "Число 2 - " .  ($dto->secondNumber =17) . "<br>";
echo "Текущий результат " . ($dto->result = 0) . "<br>";
echo("<br>");

$handler = new CalcutlatorHandler();
$handler->handle($dto);

echo '<br>';

