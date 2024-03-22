<?php

namespace Test\Interfaces;

use Test\DTO\CalculatorDTO;

interface HandlerInterface
{
    public function handle(CalculatorDTO $dto): void;
}
