<?php

namespace Test\Strategies;

use Test\DTO\CalculatorDTO;
use Test\Interfaces\HandlerInterface;

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
