<?php

namespace App\Http\Controllers;

use App\Models\HBrand;
use App\Http\Requests\HBrandRequest;
use App\DataTables\HBrandDataTable;
use App\Models\PermissionModule;


use Illuminate\Http\Request; 

class HBrandController extends Controller
{
    public function index(HBrandDataTable $dataTable)
    {
        $allowAdd = auth()->user()->hasPermissions("h_brands.create");
        return $dataTable->render('h_brands.index', compact("allowAdd"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $h_brands = HBrand::where("is_active",1)->get();
         return view('h_brands.create');
    }

    /** brand
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HBrandRequest $request)
    {
        $status = true;
		$h_brand = null;

        $params = array_merge($request->all(), [
			'name' => $request->name,
            'description' => $request->description,
            'is_active' => !is_null($request->is_active),
		]);

		try {
			$h_brand = HBrand::create($params);
			$message = "Marca creada correctamente";
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'h_brands');
		}
        return $this->getResponse($status, $message, $h_brand);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Hbrand $h_brand)
    {
        $modules = PermissionModule::all();
        return view("h_brands.show", compact("h_brands", "modules"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(HBrand $h_brand)
    {
        return view('h_brands.edit', compact("h_brand"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(HBrandRequest $request, HBrand $h_brand)
    {
        $status = true;
        $params = array_merge($request->all(), [
			'name' => $request->name,
            'description' => $request->description,
            'is_active' => !is_null($request->is_active),
		]);

		try {
			$h_brand->update($params);
			$message = "Marca modificada correctamente";
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'h_brands');
		}
        return $this->getResponse($status, $message, $h_brand);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(HBrand $h_brands)
    {
        $status = true;
        try {
            $h_brands->update(["is_active" => false]);
            $message = "Marca desactivada correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'h_brands');
        }
        return $this->getResponse($status, $message);
    }
}
