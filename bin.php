#!/usr/bin/php

<?php

require 'src/Calculator/CalculatorHandler.php';
require 'src/DTO/CalculatorDTO.php';

$command = $argv[1];
$arguments = array_slice($argv, 2);

if ($command === 'calculator:calculate-modes') {
    $dto = new CalculatorDTO($arguments[0], $arguments[1], 0);

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
}

