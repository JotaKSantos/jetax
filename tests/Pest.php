<?php

use Tests\TestCase;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| Define o TestCase padrão para todos os testes do pacote Jetax.
| Utiliza Orchestra Testbench para simular o ambiente Laravel.
|
*/

uses(TestCase::class)->in('Feature', 'Unit');
