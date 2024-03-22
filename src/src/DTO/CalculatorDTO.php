<?php

namespace Test\DTO;

class CalculatorDTO
{
    public float $firstNumber;
    public float $secondNumber;
    public float $result;

    public function __construct(float $firstNumber, float $secondNumber, float $result)
    {
        $this->firstNumber = $firstNumber;
        $this->secondNumber = $secondNumber;
        $this->result = $result;
    }
}
