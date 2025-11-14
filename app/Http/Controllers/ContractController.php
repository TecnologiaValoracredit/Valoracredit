<?php

namespace App\Http\Controllers;

use App\DataTables\ContractsDataTable;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    public function index(ContractsDataTable $dataTable){
        //Show all contracts
        //Call a view and send all the contracts
        $allowAdd = auth()->user()->hasPermissions("users.create");
        return $dataTable->render('contracts.index', compact("allowAdd"));
    }

    public function create(){
        //Show a view and send data to create a contract
        //Contract type, etc
        dd('create');
    }

    public function store(){
        //Reached when submitting a created contract
    }

    public function edit(){
        //Show a view and send data to edit a contract
    }

    public function update(){
        //Reached when submitting an edited contract
    }

    public function show(){
        //Show a single contract upon given Id of it
    }

    public function destroy(){
        //Destroy the contract
    }
}
