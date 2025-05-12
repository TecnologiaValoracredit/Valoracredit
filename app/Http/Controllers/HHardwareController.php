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
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File; 

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Label\Font\NotoSans;

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
        // Crear la URL que deseas codificar
        $url = route('h_hardwares.show', $h_hardware->id);  // Asegúrate de que esta sea la URL que deseas

        // Crear el objeto QrCode
        $qrCode = new QrCode(
            data: $url,  // Usamos la URL generada como datos del QR
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::Low,
            size: 60,
            margin: 0,
            roundBlockSizeMode: RoundBlockSizeMode::Margin,
            foregroundColor: new Color(0, 0, 0),
            backgroundColor: new Color(255, 255, 255)
        );


        // Crear la etiqueta (opcional)
        $label = new Label(
            text: "ID: ".$h_hardware->id,  // Texto que aparecerá en la etiqueta
            textColor: new Color(0, 0, 0)  // Color del texto (negro en este caso)
        );

        $label = $label->setFont(new NotoSans(8));

        // Crear el escritor de la imagen y generar el código QR
        $writer = new PngWriter();
        $result = $writer->write($qrCode, null, $label);


        // Generar la respuesta para descargar el código QR
        return response($result->getString())
            ->header('Content-Type', 'image/png')
            ->header('Content-Disposition', 'attachment; filename="qr_con_logo.png"');
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

    // Inicializar la variable de la imagen
    $imagePath = $h_hardware->image; // Mantén la imagen actual si no se ha subido una nueva

    try {
        // Verificar si se sube una nueva imagen
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            // Eliminar la imagen anterior si existe
            if ($imagePath && File::exists(public_path('storage/' . $imagePath))) {
                File::delete(public_path('storage/' . $imagePath));
            }

            // Subir la nueva imagen
            $image = $request->file('image');
            $imagePath = $image->store('active', 'public'); // Almacenar la nueva imagen
        }

        // Unir los parámetros del request con la ruta de la imagen actualizada
        $params = array_merge($request->all(), [
            'is_active' => !is_null($request->is_active),
            'image' => $imagePath, // Usar la nueva ruta de la imagen
        ]);

        // Actualizar el hardware
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
