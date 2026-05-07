<?php

namespace Jetax\DesignSystem\Console;

use Illuminate\Console\Command;
use Symfony\Component\Finder\Finder;

class JetaxCheckCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'jetax:check';

    /**
     * The console command description.
     */
    protected $description = 'Verifica se as views publicadas estão atualizadas com as do pacote';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $publishedPath = resource_path('views/vendor/jetax');
        $packagePath = __DIR__.'/../../resources/views';

        if (! is_dir($publishedPath)) {
            $this->info('Nenhuma view publicada encontrada em '.$publishedPath);

            return self::SUCCESS;
        }

        $staleViews = [];

        $finder = Finder::create()->files()->in($publishedPath)->name('*.blade.php');

        foreach ($finder as $publishedFile) {
            $relativePath = $publishedFile->getRelativePathname();
            $originalFile = $packagePath.DIRECTORY_SEPARATOR.$relativePath;

            if (! file_exists($originalFile)) {
                continue;
            }

            if (md5_file($publishedFile->getRealPath()) !== md5_file($originalFile)) {
                $staleViews[] = $relativePath;
            }
        }

        if (empty($staleViews)) {
            $this->info('Todas as views publicadas estão atualizadas.');

            return self::SUCCESS;
        }

        $this->warn('As seguintes views publicadas estão desatualizadas:');

        foreach ($staleViews as $view) {
            $this->line('  <fg=yellow>!</> '.$view);
        }

        $this->newLine();
        $this->comment('Execute "php artisan vendor:publish --tag=jetax-views --force" para atualizar.');

        return self::FAILURE;
    }
}
