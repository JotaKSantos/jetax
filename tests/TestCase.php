<?php

namespace Tests;

use Illuminate\Foundation\Application;
use Jetax\DesignSystem\JetaxServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    /**
     * Retorna os service providers do pacote para o ambiente de testes.
     *
     * @return array<int, class-string>
     */
    protected function getPackageProviders($app): array
    {
        return [
            \Livewire\LivewireServiceProvider::class,
            JetaxServiceProvider::class,
        ];
    }

    /**
     * Define as configurações do ambiente de teste.
     */
    protected function defineEnvironment($app): void
    {
        $app['config']->set('app.key', 'base64:'.base64_encode(random_bytes(32)));

        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }

    /**
     * Cria a tabela `posts` em memória usada pelas fixtures da DataTable.
     */
    protected function setUpPostsTable(?Application $app = null): void
    {
        $app ??= $this->app;

        $schema = $app['db']->connection()->getSchemaBuilder();

        if ($schema->hasTable('posts')) {
            return;
        }

        $schema->create('posts', function ($table) {
            $table->increments('id');
            $table->string('title');
            $table->text('body')->nullable();
            $table->string('status')->default('draft');
            $table->string('category')->nullable();
            $table->timestamps();
        });
    }
}
