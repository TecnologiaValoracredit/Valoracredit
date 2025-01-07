<?php

namespace App\Http\Controllers;

use App\Models\ChkChecklist;
use App\Models\Institution;
use App\Http\Requests\ChkChecklistRequest;
use App\DataTables\ChkChecklistDataTable;
use App\Models\ChkCreditType;
use App\Models\ChkList;
use App\Models\ExpType;
use App\Models\PermissionModule;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ChkChecklistController extends Controller
{

    public function index(ChkChecklistDataTable $dataTable)
    {
        
        $allowAdd = auth()->user()->hasPermissions("chk_checklists.create");
        
        
        return $dataTable->render('chk_checklists.index', compact("allowAdd"));
    }

    public function create()
    {
        $chk_lists = ChkList::where("is_active",1)->get();
        $exp_types = ExpType::where("is_active",1)->pluck("name","id");
        $institutions = Institution::where("is_active", 1)->pluck("name", "id");
        $chk_credit_types = ChkCreditType::where("is_active", 1)->pluck("name", "id");
    
        
        return view('chk_checklists.create', compact('institutions', 'chk_credit_types','exp_types','chk_lists'));
    }
    


    public function store(ChkChecklistRequest $request)
    {
      
        $status = true;
		$chk_checklist = null;
        
        
        $params = array_merge($request->all(), [
			
            'is_active' => !is_null($request->is_active),
		]); 
		try {   
			$chk_checklist = ChkChecklist::create($params);
            
            if ($request->has('chk_lists')) {
                $chk_checklist->chkLists()->sync($request->chk_lists);
            }

			$message = "Checklist creada correctamente";
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'chk_checklists');
		}
        return $this->getResponse($status, $message, $chk_checklist);

    }

    public function edit(ChkChecklist $chk_checklist)
    {
        $chk_checklist->chk_lists = json_decode($chk_checklist->chk_lists, true);
        $chk_lists = ChkList::where("is_active",1)->get();
        $exp_types = ExpType::where("is_active",1)->pluck("name","id");
        $institutions = Institution::where("is_active", 1)->pluck("name", "id");
        $chk_credit_types = ChkCreditType::where("is_active", 1)->pluck("name", "id");
    
        
        return view('chk_checklists.edit', compact('chk_checklist','institutions', 'chk_credit_types','exp_types','chk_lists'));
    }

    public function update(ChkChecklistRequest $request, ChkChecklist $chk_checklist)
    {
        $status = true;
        $params = array_merge($request->all(), [
			'name' => $request->name,
            'description' => $request->description,
            'is_active' => !is_null($request->is_active),
		]);

		try {
			$chk_checklist->update($params);
			$message = "Checklist modificada correctamente";
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'chk_checklists');
		}
        return $this->getResponse($status, $message, $chk_checklist);

    }

    public function show(ChkChecklist $chk_checklist)
    {
        $modules = PermissionModule::all();
        return view("chk_checklists.show", compact("chk_checklists", "modules"));
    }

    public function destroy(ChkChecklist $chk_checklist)
    {
        $status = true;
        try {
            $chk_checklist->update(["is_active" => false]);
            $message = "Checklist desactivada correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'chk_checklists');
        }
        return $this->getResponse($status, $message);
    }
    

   
    }









