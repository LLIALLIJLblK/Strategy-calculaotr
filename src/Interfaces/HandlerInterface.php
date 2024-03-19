<?php


interface HandlerInterface
{
    public function handle(CalculatorDTO $dto): void;
}