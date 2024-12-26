<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\PermissionModule;
use App\DataTables\BranchDataTable;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\BranchRequest;

class BranchController extends Controller
{
    public function index(BranchDataTable $dataTable)
    {
        //obtener todos los suppliers, y permisos registrados
        $allowAdd = auth()->user()->hasPermissions("branches.create");
        return $dataTable->render('branches.index', compact("allowAdd"));
    }

    public function create()
    {
        return view('branches.create');
    }

    public function store(BranchRequest $request)
    {
        $status = true;
		$branch = null;

        $params = array_merge($request->all(), [
			'name' => $request->name,
            'description' => $request->description,
            'is_active' => !is_null($request->is_active),
		]);

		try {
			$branch = Branch::create($params);
			$message = "Sucursal creada correctamente";
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'branches');
		}
        return $this->getResponse($status, $message, $branch);

    }

    public function edit(Branch $branch)
    {
        return view('branches.edit', compact("branch"));
    }

    public function update(BranchRequest $request, Branch $branch)
    {
        $status = true;
        $params = array_merge($request->all(), [
			'name' => $request->name,
            'description' => $request->description,
            'is_active' => !is_null($request->is_active),
		]);

		try {
			$branch->update($params);
			$message = "Sucursal modificada correctamente";
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'branches');
		}
        return $this->getResponse($status, $message, $branch);

    }

    public function show(Branch $branch)
    {
        $modules = PermissionModule::all();
        return view("branches.show", compact("branch", "modules"));
    }

    public function destroy(Branch $branch)
    {
        $status = true;
        try {
            $branch->update(["is_active" => false]);
            $message = "Sucursal desactivada correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'branches');
        }
        return $this->getResponse($status, $message);
    }


}

