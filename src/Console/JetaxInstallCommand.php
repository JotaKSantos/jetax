<?php

namespace Jetax\DesignSystem\Console;

use Illuminate\Console\Command;

class JetaxInstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'jetax:install
                            {--force : Sobrescrever arquivos já publicados}';

    /**
     * The console command description.
     */
    protected $description = 'Instala o Jetax: publica config, CSS source e configura o app.css';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Instalando Jetax...');
        $this->newLine();

        $this->publishConfig();
        $this->publishCssSource();
        $this->configureCss();

        $this->newLine();
        $this->info('Jetax instalado com sucesso!');
        $this->comment('Use componentes com o prefixo <x-jetax-*>. Exemplo: <x-jetax-button>');

        return self::SUCCESS;
    }

    /**
     * Publica o arquivo de configuração.
     */
    protected function publishConfig(): void
    {
        $params = ['--provider' => 'Jetax\DesignSystem\JetaxServiceProvider', '--tag' => 'jetax-config'];

        if ($this->option('force')) {
            $params['--force'] = true;
        }

        $this->call('vendor:publish', $params);
    }

    /**
     * Publica os arquivos CSS source.
     */
    protected function publishCssSource(): void
    {
        $params = ['--provider' => 'Jetax\DesignSystem\JetaxServiceProvider', '--tag' => 'jetax-css-source'];

        if ($this->option('force')) {
            $params['--force'] = true;
        }

        $this->call('vendor:publish', $params);
    }

    /**
     * Adiciona as diretivas @import e @source no app.css se ainda não existirem.
     */
    protected function configureCss(): void
    {
        $cssPath = resource_path('css/app.css');

        if (! file_exists($cssPath)) {
            $this->warn('Arquivo resources/css/app.css não encontrado. Adicione manualmente:');
            $this->line('  @import "../../vendor/jksantos/jetax/resources/css/jetax.css";');
            $this->line('  @source "../../vendor/jksantos/jetax/resources/views";');

            return;
        }

        $contents = file_get_contents($cssPath);
        $importLine = '@import "../../vendor/jksantos/jetax/resources/css/jetax.css";';
        $sourceLine = '@source "../../vendor/jksantos/jetax/resources/views";';
        $modified = false;

        if (! str_contains($contents, 'jksantos/jetax/resources/css/jetax.css')) {
            $contents = $importLine."\n".$contents;
            $modified = true;
        }

        if (! str_contains($contents, 'jksantos/jetax/resources/views')) {
            $contents .= "\n".$sourceLine."\n";
            $modified = true;
        }

        if ($modified) {
            file_put_contents($cssPath, $contents);
            $this->info('Diretivas @import e @source adicionadas ao resources/css/app.css');
        } else {
            $this->info('resources/css/app.css já contém as diretivas do Jetax');
        }
    }
}
