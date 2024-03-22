<?php


require_once 'vendor/autoload.php';

use Test\DTO\CalculatorDTO;
use Test\Calculator\CalculatorHandler;

$dto = new CalculatorDTO(300, 700, 0);
$handler = new CalculatorHandler($dto);

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
