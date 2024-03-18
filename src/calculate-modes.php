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

$dto = new CalculatorDTO($argv[1], $argv[2], 0);

echo "\033[01;32mНайдена удачная комбинация: \033[0m" .  PHP_EOL;
echo "Число 1 - $dto->firstNumber " . PHP_EOL;
echo "Число 2 - $dto->secondNumber " . PHP_EOL;

$handler = new CalculatorHandler();
$handler->handle($dto);

echo "\033[01;32mПоследовательность действий: \033[0m" .  PHP_EOL;
foreach ($handler->getResult()['good'] as $good) {
    echo "\033[01;33m$good\033[0m" . " ";
};
echo PHP_EOL;

$iters  = $handler->getResult()['iter'];
echo "\033[01;34mВыполнено итераций:  $iters\033[0m";
echo  PHP_EOL;
echo "Лог выполнения: " .  PHP_EOL;
echo "Текущий результат 0"  .  PHP_EOL;

foreach ($handler->getResult()['log'] as $key => $result) {
    echo "Выполнено действие: " . $handler->getResult()['good'][$key] . ". Результат: " . $result .  PHP_EOL;
    echo "Текущий результат: " . $result .  PHP_EOL;
}

echo "неудачные комбинации : " .  PHP_EOL;
$fails = [];
foreach ($handler->getResult()['fail'] as $key => $fail) {
    echo "\033[01;31m" . implode(' ', $fail) . "\033[0m" . PHP_EOL;
    
}
