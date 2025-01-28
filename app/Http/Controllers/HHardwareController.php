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
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File; 



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
        $customSerialNumber = 'SN-' . strtoupper(uniqid());
    
        // Inicializar variable para la imagen
        $imagePath = null;
        try {
           // Manejar la carga de la imagen
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $image = $request->file('image');
                // Almacenar la imagen en el disco 'public' y obtener la ruta
                $imagePath = $image->store('active', 'public'); // Almacenamiento en 'public'
            }

    
            // Unir los parámetros del request con el número de serie personalizado y la ruta de la imagen
            $params = array_merge($request->all(), [
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
    try {
        // Generar la URL del QR
        $qrData = route('h_hardwares.show', $h_hardware->id);
        $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=" . urlencode($qrData);

        // Crear la vista HTML de la etiqueta
        $view = view('h_hardwares.generateQrCode', compact('qrUrl', 'h_hardware'))->render();

        // Guardar el HTML en un archivo público
        $htmlFileName = 'hardware_label_' . $h_hardware->id . '.html';
        $htmlPath = public_path($htmlFileName);

        file_put_contents($htmlPath, $view);

        // Generar la URL pública del archivo
        $publicHtmlUrl = url($htmlFileName);

        // URL de la API de ApiFlash
        $apiUrl = 'https://api.apiflash.com/v1/urltoimage';
        $accessKey = '0dc526f94420457eaf8b3b54e49d8292'; // Reemplaza con tu clave de ApiFlash

        // Crear la URL para la solicitud
        $apiRequestUrl = "$apiUrl?access_key=$accessKey&url=" . urlencode($publicHtmlUrl) . "&format=png&width=240&height=140";

        // Realizar la solicitud a la API
        $response = Http::get($apiRequestUrl);

        if ($response->successful()) {
            // Guardar la imagen generada
            $imageFileName = 'hardware_label_' . $h_hardware->id . '.png';
            $imagePath = public_path($imageFileName);
            file_put_contents($imagePath, $response->body());

            // Eliminar el archivo HTML temporal
            if (File::exists($htmlPath)) {
                File::delete($htmlPath);
            }

            // Devolver la imagen para descarga
            return response()->download($imagePath)->deleteFileAfterSend(true);
        } else {
            // Manejar el error de generación
            return response()->json([
                'error' => 'Hubo un error al generar la imagen.',
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
        }
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Se produjo un error inesperado.',
            'message' => $e->getMessage(),
        ], 500);
    }
}


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(HHardware $h_hardware)
    {
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
        return view("h_hardwares.show", compact("h_hardware",'h_device_types', 'h_brands','users','companies','branches'));
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
        $branches = Branch::where("is_active", 1)->pluck("name", "id");
        $companies = Company::where("is_active", 1)->pluck("name", "id");

        return view('h_hardwares.edit', compact('h_hardware','h_device_types', 'h_brands','users', "branches", "companies"));
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
