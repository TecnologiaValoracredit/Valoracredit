<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HDeviceType;
use App\Models\HBrand;
use App\Models\User;
use App\Models\HHardware;
use App\Http\Requests\HHardwareRequest;
use App\Models\PermissionModule;
use App\DataTables\HHardwareDataTable;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class HHardwareController extends Controller
{
    public function index(HHardwareDataTable $dataTable)
    {
        $allowAdd = auth()->user()->hasPermissions("h_hardwares.create");
        return $dataTable->render('h_hardwares.index', compact("allowAdd"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $h_device_types = HDeviceType::where("is_active", 1)->pluck("name", "id");
        $h_brands = HBrand::where("is_active", 1)->pluck("name", "id");
        $users = User::where("is_active", 1)->pluck("name", "id");
   
        return view('h_hardwares.create', compact('h_device_types', 'h_brands','users',));
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HHardwareRequest $request)
    {
        $status = true;
        $h_hardware = null;
    
        // Generar un número de serie personalizado
        $customSerialNumber = 'SN-' . strtoupper(uniqid('HW-'));
    
        // Inicializar variable para la imagen
        $imagePath = null;
    
        try {
           // Manejar la carga de la imagen
    if ($request->hasFile('image') && $request->file('image')->isValid()) {
    $image = $request->file('image');
    
    // Validar el archivo de imagen (opcional, según los requisitos)
    $request->validate([
        'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB máximo
    ]);

    // Almacenar la imagen en el disco 'public' y obtener la ruta
    $imagePath = $image->store('hardware_images', 'public'); // Almacenamiento en 'public'
    }

    
            // Unir los parámetros del request con el número de serie personalizado y la ruta de la imagen
            $params = array_merge($request->all(), [
                'name' => $request->name,
                'description' => $request->description,
                'is_active' => !is_null($request->is_active),
                'custom_serial_number' => $customSerialNumber,
                'image' => $imagePath, // Agregar la ruta de la imagen al registro
            ]);
    
            // Crear el hardware con los parámetros
            $h_hardware = HHardware::create($params);
            $message = "Hardware agregado correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'h_hardwares');
        }
    
        return $this->getResponse($status, $message, $h_hardware);
    }
    
        public function generateQrCode(HHardware $h_hardware)
        {
        // Generar un código QR con el enlace al hardware específico
        $qrCode = QrCode::size(200)->generate(route('h_hardwares.show', $h_hardware->id));

        // Pasar el QR generado a la vista
        return view('h_hardwares.qr_code', compact('qrCode', 'h_hardware'));
        }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(HHardware $h_hardware)
    {
        $modules = PermissionModule::all(); // Cargar todos los módulos de permisos
        $h_device_types = HDeviceType::where("is_active", 1)->pluck("name", "id");
        $h_brands = HBrand::where("is_active", 1)->pluck("name", "id");
        $users = User::where("is_active", 1)->pluck("name", "id");
    
        // Asegúrate de que el hardware está activo
        if (!$h_hardware->is_active) {
            abort(404, "El hardware no está activo o no existe.");
        }
    
        // Pasar el hardware y los módulos a la vista
        return view("h_hardwares.show", compact("h_hardware", "modules",'h_device_types', 'h_brands','users',));
    }
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(HHardware $h_hardware)
    {
        $h_device_types = HDeviceType::where("is_active", 1)->pluck("name", "id");
        $h_brands = HBrand::where("is_active", 1)->pluck("name", "id");
        $users = User::where("is_active", 1)->pluck("name", "id");
        return view('h_hardwares.edit', compact('h_hardware','h_device_types', 'h_brands','users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(HHardwareRequest $request, HHardware $h_hardware)
    {
        $status = true;
        $params = array_merge($request->all(), [
			'name' => $request->name,
            'description' => $request->description,
            'is_active' => !is_null($request->is_active),
		]);

		try {
			$h_hardware->update($params);
			$message = "Hardware modificado correctamente";
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'h_hardwares');
		}
        return $this->getResponse($status, $message, $h_hardware);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(HHardware $h_hardware)
    {
        $status = true;
        try {
            $h_hardware->update(["is_active" => false]);
            $message = "Hardware desactivada correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'h_hardwares');
        }
        return $this->getResponse($status, $message);
    }
}
