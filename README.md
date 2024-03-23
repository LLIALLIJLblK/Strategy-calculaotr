# Тестовое задание

Краткое Описание: Реализовать логику калькулятора, у которого итого должно пройти по всем 4 режимам.

## Ход работы

1) Установка и настройка докера
2) Реализация DTO
3) Реализация стратегий
4) Продумывания алогритма 

## Мини-отчёт о проделанной работе 

Сделал конкретный путь для консольного вывода результата, поменял порты чтоб не сбрасывать вебсервер на своём компьютере.

## Команды

Для докера

    docker-compose up -d 

Для вывода результата в терминале

    ./bin calculator:calculate-modes 300 700

Для вывода результата в адресной строке

    http://localhost:8081/calculator/calculate-modes?firstNumber=300&secondNumber=700


