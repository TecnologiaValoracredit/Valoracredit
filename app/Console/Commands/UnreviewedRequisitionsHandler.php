<?php

namespace App\Console\Commands;

use App\Services\RequisitionGlobalService;
use Illuminate\Console\Command;

class UnreviewedRequisitionsHandler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'requisitions:handleUnreviewed';
    
    /**
     * The console command description.
    *
    * @var string
    */
    protected $description = "Notifica a D.G. de requisiciones que no ha autorizado/denegado";

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $message = "No se encontraron globales pendientes de revisión.";
        
        $service = new RequisitionGlobalService();
        $hadUnreviewed = $service->handleUnreviewedRequisitions();
        
        if ($hadUnreviewed) {
            $message = "Se encontraron globales pendientes de revisión y se notificó a D.G.";
        }

        return $this->info($message);
    }
}
