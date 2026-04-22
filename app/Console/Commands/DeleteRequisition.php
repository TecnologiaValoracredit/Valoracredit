<?php

namespace App\Console\Commands;
use Illuminate\Support\Facades\DB;
use App\Models\Requisition;
use Illuminate\Console\Command;
use App\Services\RequisitionService;

class DeleteRequisition extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'requisition:delete {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Elimina una requisición y todas sus relaciones';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $id = $this->argument('id');

        $service = new RequisitionService();
        list($success, $error) = $service->deleteWithRelations($id);
        $message = "Requisición eliminada correctamente";

        if (!$success) {
            $message = $error->getMessage();
        }

        $this->info($message);
    }
}
