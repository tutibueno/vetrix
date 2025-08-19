<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Config\Database;

class SessionCleanup extends BaseCommand
{
    protected $group       = 'Sessions';
    protected $name        = 'session:cleanup';
    protected $description = 'Remove sessões antigas da tabela de sessões do banco.';

    public function run(array $params)
    {
        $db = Database::connect();

        // Nome da tabela de sessão (mude se necessário)
        $table = 'ci_sessions';

        // Defina o prazo para manter (exemplo: 30 dias)
        $dias = $params[0] ?? 30;

        $limitTimestamp = time() - ($dias * 24 * 60 * 60);

        $builder = $db->table($table);
        $builder->where('timestamp <', $limitTimestamp);
        $deleted = $builder->delete();

        if ($deleted) {
            CLI::write("✅ Sessões mais antigas que {$dias} dias foram removidas.", 'green');
        } else {
            CLI::write("ℹ️ Nenhuma sessão antiga encontrada para excluir.", 'yellow');
        }
    }
}
