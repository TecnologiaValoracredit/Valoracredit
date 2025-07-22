<?php

namespace App\Http\Controllers;
use App\Models\Commission;
use App\Models\Ssale;
use App\Models\CommissionSale;
use App\DataTables\CommissionDataTable;
use App\Exports\CommissionExport;
use Maatwebsite\Excel\Facades\Excel;

use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\CommissionRequest;
use Illuminate\Http\Request;

class CommissionController extends Controller
{
    public function index(CommissionDataTable $dataTable)
    {
        //obtener todos los commissions, y permisos registrados
        $allowAdd = auth()->user()->hasPermissions("commissions.create");
        return $dataTable->render('commissions.index', compact("allowAdd"));
    }

    public function create()
    {
        //Obtener todas las ventas del día
        $date = Carbon::now()->subMonths(3)->format('Y-m-d'); 
        // $date = Carbon::today(); 
        $s_sales = Ssale::where("created_at", ">=", $date)
                        ->where("is_active", true)
                        ->get();
        // Ssale::where("created_at", "=", Carbon::today())->get();

        // dd($s_sales);

        // Agrupar por coordinador
        $salesGroupedByCoordinator = $s_sales->groupBy('s_coordinator_id');

        dd($salesGroupedByCoordinator);
         try {
            foreach ($salesGroupedByCoordinator as $coordinatorId => $sales) {
                // Calcular total de ventas y monto vendido
                $totalSales = $sales->count();
                $totalAmount = $sales->sum('total_amount');

                // Obtener usuario asociado al coordinador 
                //Esto debe cambiar, no es coordinador, sino usuario para el promotor y coordinador!!!!!
                $coordinator = $sales->first()->coordinator; 
                $userId = $coordinator?->user_id;

                // Calcular la formula para obtener el importe
                $amountToRecieveCoordinator = 0;

                $salesGroupedByPromotor = $sales->groupBy('s_promotor_id');

                //Si la institucion tiene una comision especial con usuario, se usa esa
                foreach($salesGroupedByPromotor as $key => $sale) {
                    
                }
                

                // Crear la comisión
                $commission = Commission::create([
                    'total_sales'       => $totalSales,
                    'total_amount_sold' => $totalAmount,
                    'beneficiary_type'  => 'coordinator', 
                    'amount_received'   => 0, 
                    'user_id'           => $userId,
                    'is_active'         => true,
                    'created_by'        => auth()->id(),
                    'updated_by'        => auth()->id(),
                ]);

                // Asociar ventas a la comisión
                foreach ($sales as $sale) {
                    CommissionSale::create([
                        's_sales_id'  => $sale->id,
                        'commission_id' => $commission->id,
                        'is_active'   => true,
                        'created_by'  => auth()->id(),
                        'updated_by'  => auth()->id(),
                    ]);
                }
            }
            return redirect()->route('commissions.index')->with('success', 'Comisiones generadas correctamente.');

        } catch (\Exception $e) {

            return back()->withErrors(['error' => 'Error al generar comisiones: ' . $e->getMessage()]);
        }

        // return view('commissions.create');
    }

    public function store(CommissionRequest $request)
    {
        $status = true;
		$commission = null;

        $params = array_merge($request->all(), [
			'name' => $request->name,
            'descriptiom' => $request->description,
            'is_active' => !is_null($request->is_active),
		]);

		try {
			$commission = Commission::create($params);
			$message = "Commission creado correctamente";
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'commissions');
		}
        return $this->getResponse($status, $message, $commission);

    }

    public function edit(Commission $commission)
    {
        return view('commissions.edit', compact("commission"));
    }

    public function update(CommissionRequest $request, Commission $commission)
    {
        $status = true;
        $params = array_merge($request->all(), [
			'name' => $request->name,
            'descriptiom' => $request->description,
            'is_active' => !is_null($request->is_active),
		]);

		try {
			$commission->update($params);
			$message = "Commission modificado correctamente";
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'commissions');
		}
        return $this->getResponse($status, $message, $commission);

    }

    public function show(Commission $commission)
    {
        $modules = PermissionModule::all();
        return view("commissions.show", compact("commission", "modules"));
    }

    public function destroy(Commission $commission)
    {
        $status = true;
        try {
            $commission->update(["is_active" => false]);
            $message = "Commission desactivado correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'commissions');
        }
        return $this->getResponse($status, $message);
    }

    public function exportReport(){
        return Excel::download(new CommissionExport, 'users.xlsx');
    }
}
