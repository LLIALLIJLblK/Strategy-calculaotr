<?php

class CalculatorDTO
{
    public float $firstNumber;
    public float $secondNumber;
    public float $result;

    public function __construct(float $firstNumber, float $secondNumer, float $result)
    {
        $this->firstNumber = $firstNumber;
        $this->secondNumber = $secondNumer;
        $this->result = $result;
    }
}

class AddStrategy implements HandlerInterface
{
    public function handle(CalculatorDTO $dto): void
    {
        $dto->result = $dto->firstNumber + $dto->secondNumber;
    }

    public function getName()
    {
        return "сложение";
    }
}

class SubStrategy implements HandlerInterface
{
    public function handle(CalculatorDTO $dto): void
    {
        $dto->result = $dto->firstNumber - $dto->secondNumber;
    }

    public function getName()
    {
        return "вычитание";
    }
}

class DivStrategy implements HandlerInterface
{
    public function handle(CalculatorDTO $dto): void
    {
        $dto->result = $dto->firstNumber / $dto->secondNumber;
    }

    public function getName()
    {
        return "деление";
    }
}


class MultStrategy implements HandlerInterface
{
    public function handle(CalculatorDTO $dto): void
    {
        $dto->result = $dto->firstNumber * $dto->secondNumber;
    }

    public function getName()
    {
        return "умножение";
    }
}

interface HandlerInterface
{
    public function handle(CalculatorDTO $dto): void;
}

class CalculatorHandler implements HandlerInterface
{
    private $failedCombinations;
    private $succesCombination;
    private $currentLog;
    private $results;
    private $iteration;

    public function __construct()
    {
        $this->failedCombinations = [];
        $this->succesCombination = [];
        $this->results;
        $this->currentLog;
        $this->iteration;
    }

    private function checkCombination(array $results, array $strategies): bool
    {
        return (
            count($results) == 4 &&
            !($results[0] > 0 && $strategies[0] instanceof DivStrategy) &&
            !($results[0] < 0 && $strategies[0] instanceof AddStrategy) &&
            !($results[1] <= 1000 && $strategies[1] instanceof DivStrategy) &&
            !($results[2] <= 10 && $strategies[2] instanceof MultStrategy) &&
            !($results[3] >= 1000 && $strategies[3] instanceof SubStrategy)

        );
    }

    private function shuffleStrategies(): array
    {
        $strategies = [
            new AddStrategy(),
            new SubStrategy(),
            new DivStrategy(),
            new MultStrategy(),
        ];
        shuffle($strategies);

        return $strategies;
    }

    private function handleStrategy($strategies, $dto, &$results): void
    {
        foreach ($strategies as $strategy) {
           
            if ($strategy->getName() === "сложение" && $dto->result >= 0) {
                $strategy->handle($dto);
                $results[] = $dto->result;
            }
            if ($strategy->getName() === "умножение" && $dto->result > 10) {
                $strategy->handle($dto);
                $results[] = $dto->result;
            }
            if ($strategy->getName() === "вычитание" && $dto->result < 1000  ) {
                $strategy->handle($dto);
                $results[] = $dto->result;
            }
            if ($strategy->getName() === "деление" && $dto->result > 1000) {
                $strategy->handle($dto);
                $results[] = $dto->result;
            }
        }
    }

    private function prepapreStategies(CalculatorDTO $dto): void
    {

        $results = [];
        $strategies = [];
    
     
        while (!$this->checkCombination($results, $strategies)) {

            $results = [];
            
            $this->iteration++;
            $strategies = $this->shuffleStrategies();
            $this->handleStrategy($strategies, $dto, $results);

            $failedCombination = array_map(function ($strategy) {
                return $strategy->getName();
            }, $strategies);

            $this->failedCombinations[] = $failedCombination;
            
            $maxSize = 50;
            if (count($this->failedCombinations) >= $maxSize ) {
               break;
            }
            
        }
        
        $this->succesCombination = array_map(function ($strategy) {
            return $strategy->getName();
        }, $strategies);
        $this->currentLog = $results;
    }

    public function handle(CalculatorDTO $dto): void
    {
        $this->prepapreStategies($dto);
    }

    public function getResult()
    {
        $results = [
            'fail' => $this->failedCombinations,
            'good' => $this->succesCombination,
            'log' =>  $this->currentLog,
            'iter' => $this->iteration
        ];
        return $results;
    }
}
    
$firstNumber = $_GET['firstNumber'];
$secondNumber = $_GET['secondNumber'];

$f = $firstNumber;
$s =  $secondNumber;

$dto = new CalculatorDTO($f ,$s,0);
$handler = new CalculatorHandler($f ,$s,0);

echo "Найдена удачная комбинация комбинцаия: <br>";
echo "Число 1 - $dto->firstNumber <br>";
echo "Число 2 - $dto->secondNumber <br>";
$handler->handle($dto);

echo "Последовательность действий: <br>";
foreach ($handler->getResult()['good'] as $good) {
    echo $good . " ";
};

echo "<br>";

echo "Выполнено итераций: ";
echo $handler->getResult()['iter'];

echo "<br>";
echo "Лог выполнения: <br>";
echo "Текущий результат 0  <br>";

foreach ($handler->getResult()['log'] as $key => $result) {
    echo "Выполнено действие: " . $handler->getResult()['good'][$key] . ". Результат: " . $result . "<br>";
    echo "Текущий результат: " . $result . "<br>";
}

echo "неудачные комбинации : <br>";
foreach ($handler->getResult()['fail'] as $key => $fail) {
    echo implode(' ', $fail) . "<br>";
}

