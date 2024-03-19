<?php

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