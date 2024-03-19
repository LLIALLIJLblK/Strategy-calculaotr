<?php

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