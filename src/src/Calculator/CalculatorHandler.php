<?php

// require __DIR__ . '/../Interfaces/HandlerInterface.php';
// require __DIR__ . '/../Strategies/AddStrategy.php';
// require __DIR__ . '/../Strategies/SubStrategy.php';
// require __DIR__ . '/../Strategies/DivStrategy.php';
// require __DIR__ . '/../Strategies/MultStrategy.php';
namespace Test\Calculator;


use Test\Strategies\AddStrategy;
use Test\Strategies\SubStrategy;
use Test\Strategies\DivStrategy;
use Test\Strategies\MultStrategy;
use Test\DTO\CalculatorDTO;

use Test\Interfaces\HandlerInterface;


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

    private function handleStrategy($strategies, $dto, &$currentResult, &$currentStrategy): void
    {
        $currentStrategy = [];
        $currentResult = [];
        $dto->result = 0;

        foreach ($strategies as $strategy) {
            if($dto->secondNumber == 0 ||  $dto->firstNumber == 0){
                exit("Нельзя делить на ноль !!!");
            }

            if ($strategy instanceof AddStrategy && $dto->result >= 0) {
                $strategy->handle($dto);
                $currentResult[] = $dto->result;
            }

            if ($strategy instanceof SubStrategy &&  $dto->result < 1000) {
                $strategy->handle($dto);
                $currentResult[] = $dto->result;
            }

            if ($strategy instanceof DivStrategy && $dto->result > 1000) {
                $strategy->handle($dto);
                $currentResult[] = $dto->result;
            }

            if ($strategy instanceof MultStrategy && $dto->result >= 10) {
                $strategy->handle($dto);
                $currentResult[] = $dto->result;
            }
        }
    }

    private function prepapreStategies($dto)
    {
        $currentResult = [];
        $currentStrategy = [];

        while (count($currentResult) != 4) {

            $this->iteration++;

            $strategies = $this->shuffleStrategies();
            $this->handleStrategy($strategies, $dto, $currentResult, $currentStrategy);

            $failedCombination = array_map(function ($strategy) {
                return $strategy->getName();
            }, $strategies);

            $this->failedCombinations[] = $failedCombination;
        }

        $this->currentLog = $currentResult;
        $this->succesCombination = array_map(function ($strategy) {
            return $strategy->getName();
        }, $strategies);
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
