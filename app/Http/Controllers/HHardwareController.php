<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HDeviceType;
use App\Models\HBrand;
use App\Models\Branch;
use App\Models\Company;
use App\Models\User;
use Spatie\Browsershot\Browsershot;
use App\Models\HHardware;
use Spatie\Image\Image;
use Spatie\Image\Manipulations;
use App\Http\Requests\HHardwareRequest;
use App\Models\PermissionModule;
use App\DataTables\HHardwareDataTable;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class HHardwareController extends Controller
{

    public function boot()
    {
    Image::useImageDriver('gd');
    }

    public function index(HHardwareDataTable $dataTable)
    {
        $allowAdd = auth()->user()->hasPermissions("h_hardwares.create");
        $users = User::where("is_active", 1)->pluck("name", "id");
        $h_device_types = HDeviceType::where("is_active", 1)->pluck("name", "id");
        $h_brands = HBrand::where("is_active", 1)->pluck("name", "id");
        $companies = Company::where("is_active", 1)->pluck("name", "id");
        $branches = Branch::where("is_active", 1)->pluck("name", "id");
        return $dataTable->render('h_hardwares.index', compact("allowAdd","users","h_device_types","h_brands","companies","branches"));
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
        $companies = Company::where("is_active", 1)->pluck("name", "id");
        $branches = Branch::where("is_active", 1)->pluck("name", "id");

   
        return view('h_hardwares.create', compact('h_device_types', 'h_brands','users','companies','branches'));
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
        $allowAdd = auth()->user()->hasPermissions("h_hardwares.generateQrCode");
    
        // Generar el código QR con el enlace
        $qrCode = QrCode::size(50)->generate(route('h_hardwares.show', $h_hardware->id));
    
        // Crear la vista HTML con el contenido del cuadro
        $view = view('h_hardwares.generateQrCode', compact('allowAdd', 'qrCode', 'h_hardware'))->render();
    
        // Ruta para guardar la imagen generada
        $imagePath = storage_path('app/public/hardware_image.png');
    
        // Generar solo el cuadro con dimensiones específicas
        Browsershot::html($view)
            ->setOption('no-sandbox', true) // Opcional según tu entorno
            ->windowSize(190, 110) // Ajusta el tamaño del área visible al cuadro
            ->clip(0, 0, 190, 110) // Captura solo el cuadro con estas dimensiones (x, y, ancho, alto)
            ->save($imagePath);
    
        // Devolver la imagen para descarga
        return response()->download($imagePath);
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
        $companies = Company::where("is_active", 1)->pluck("name", "id");
        $branches = Branch::where("is_active", 1)->pluck("name", "id");
    
        // Asegúrate de que el hardware está activo
        if (!$h_hardware->is_active) {
            abort(404, "El hardware no está activo o no existe.");
        }
    
        // Pasar el hardware y los módulos a la vista
        return view("h_hardwares.show", compact("h_hardware", "modules",'h_device_types', 'h_brands','users','companies','branches'));
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
