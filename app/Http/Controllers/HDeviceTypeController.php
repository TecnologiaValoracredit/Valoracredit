<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HDeviceType;
use App\DataTables\HDeviceTypeDataTable;
use App\Models\PermissionModule;
use App\Http\Requests\HDeviceTypeRequest;

class HDeviceTypeController extends Controller
{

        public function index(HDeviceTypeDataTable $dataTable)
        {
            $allowAdd = auth()->user()->hasPermissions("h_device_types.create");
            return $dataTable->render('h_device_types.index', compact("allowAdd"));
        }
    
        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function create()
        {
            $h_device_types = HDeviceType::where("is_active",1)->get();
             return view('h_device_types.create'); 
        }
    
        /** brand
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        public function store(HDeviceTypeRequest $request)
        {
            $status = true;
            $h_device_type = null;
    
            $params = array_merge($request->all(), [
                'name' => $request->name,
                'description' => $request->description,
                'is_active' => !is_null($request->is_active),
            ]);
    
            try {
                $h_device_type = HDeviceType::create($params);
                $message = "Marca creada correctamente";
            } catch (\Illuminate\Database\QueryException $e) {
                $status = false;
                $message = $this->getErrorMessage($e, 'h_device_types');
            }
            return $this->getResponse($status, $message, $h_device_type);
        }
    
        /**
         * Display the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function show(HDeviceType $h_device_type)
        {
            $modules = PermissionModule::all();
            return view("h_device_types.show", compact("h_device_types", "modules"));
        }
    
        /**
         * Show the form for editing the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function edit(HDeviceType $h_device_type)
        {
            return view('h_device_types.edit', compact("h_device_type"));
        }
    
        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function update(HDeviceTypeRequest $request, HDeviceType $h_device_type)
        {
            $status = true;
            $params = array_merge($request->all(), [
                'name' => $request->name,
                'description' => $request->description,
                'is_active' => !is_null($request->is_active),
            ]);
    
            try {
                $h_device_type->update($params);
                $message = "Marca modificada correctamente";
            } catch (\Illuminate\Database\QueryException $e) {
                $status = false;
                $message = $this->getErrorMessage($e, 'h_device_types');
            }
            return $this->getResponse($status, $message, $h_device_type);
        }
    
        /**
         * Remove the specified resource from storage.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function destroy(HDeviceType $h_device_types)
        {
            $status = true;
            try {
                $h_device_types->update(["is_active" => false]);
                $message = "Marca desactivada correctamente";
            } catch (\Illuminate\Database\QueryException $e) {
                $status = false;
                $message = $this->getErrorMessage($e, 'h_device_types');
            }
            return $this->getResponse($status, $message);
        }
}
