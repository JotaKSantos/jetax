<?php

namespace Jetax\DesignSystem\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Jetax\DesignSystem\Docs\Playground\Cliente;

class JetaxSeedPlaygroundCommand extends Command
{
    protected $signature = 'jetax:seed-playground {--count=1800 : Quantidade de clientes a gerar} {--fresh : Apaga registros existentes antes de inserir}';

    protected $description = 'Popula a tabela jetax_playground_clientes com registros fake para a documentação da DataTable.';

    private const NOMES = [
        'Ana Lima', 'João Silva', 'Maria Santos', 'Carlos Mendes', 'Beatriz Costa',
        'Ricardo Augusto', 'Patrícia Oliveira', 'Fernanda Rocha', 'Eduardo Ramos', 'Camila Duarte',
        'Tiago Almeida', 'Larissa Cunha', 'Rafael Moreira', 'Júlia Barbosa', 'Bruno Pereira',
        'Aline Fernandes', 'Daniel Castro', 'Vanessa Pinto', 'Gustavo Dias', 'Renata Vieira',
    ];

    private const RAZOES = [
        'TechNova Soluções Digitais', 'Luminex Group International', 'Global Logistics Corp',
        'Cliente Avulso', 'Mercatto Distribuidora', 'Atalho Sistemas', 'Verde Norte Agronegócio',
        'Estúdio Norte Design', 'Construtora Vértice', 'Pixel Studio Criativo',
    ];

    private const CIDADES_UF = [
        ['São Paulo', 'SP'], ['Rio de Janeiro', 'RJ'], ['Belo Horizonte', 'MG'],
        ['Curitiba', 'PR'], ['Porto Alegre', 'RS'], ['Salvador', 'BA'],
        ['Fortaleza', 'CE'], ['Recife', 'PE'], ['Itajaí', 'SC'], ['Brasília', 'DF'],
    ];

    private const STATUS = ['ativo', 'inativo', 'pendente', 'bloqueado'];

    private const CATEGORIAS = ['bronze', 'prata', 'ouro', 'diamante'];

    public function handle(): int
    {
        if (! Schema::hasTable('jetax_playground_clientes')) {
            $this->error('Tabela jetax_playground_clientes não existe. Rode "php artisan migrate" antes.');

            return self::FAILURE;
        }

        if ($this->option('fresh')) {
            $this->info('Removendo registros antigos...');
            Cliente::query()->delete();
        }

        $count = (int) $this->option('count');
        $now = Carbon::now();
        $batch = [];

        $this->info("Gerando {$count} clientes fake...");
        $bar = $this->output->createProgressBar($count);
        $bar->start();

        for ($i = 1; $i <= $count; $i++) {
            $cidadeUf = self::CIDADES_UF[array_rand(self::CIDADES_UF)];
            $createdAt = $now->copy()->subDays(random_int(0, 365))->subMinutes(random_int(0, 1440));

            $batch[] = [
                'nome'         => self::NOMES[array_rand(self::NOMES)].' '.($i),
                'razao_social' => self::RAZOES[array_rand(self::RAZOES)],
                'documento'    => $this->fakeDocumento(),
                'cidade'       => $cidadeUf[0],
                'estado'       => $cidadeUf[1],
                'status'       => self::STATUS[array_rand(self::STATUS)],
                'categoria'    => self::CATEGORIAS[array_rand(self::CATEGORIAS)],
                'created_at'   => $createdAt,
                'updated_at'   => $createdAt,
            ];

            if (count($batch) >= 200) {
                DB::table('jetax_playground_clientes')->insert($batch);
                $bar->advance(count($batch));
                $batch = [];
            }
        }

        if (! empty($batch)) {
            DB::table('jetax_playground_clientes')->insert($batch);
            $bar->advance(count($batch));
        }

        $bar->finish();
        $this->newLine(2);
        $this->info('Pronto! '.Cliente::count().' clientes na tabela.');

        return self::SUCCESS;
    }

    private function fakeDocumento(): string
    {
        if (random_int(0, 1) === 0) {
            return sprintf(
                '%03d.%03d.%03d-%02d',
                random_int(0, 999), random_int(0, 999), random_int(0, 999), random_int(0, 99),
            );
        }

        return sprintf(
            '%02d.%03d.%03d/0001-%02d',
            random_int(0, 99), random_int(0, 999), random_int(0, 999), random_int(0, 99),
        );
    }
}
