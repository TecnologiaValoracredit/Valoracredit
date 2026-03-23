<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Permit;
use App\Models\Requisition;

class FileController extends Controller
{
    public function showPublic(string $path){

        // NECESARIO PARA EVITAR QUE EL NAVEGADOR CACHEE LA IMAGEN Y MUESTRE CORRECTAMENTE SI HAY O NO
        return response()->file(storage_path("app/public/{$path}") ,[
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }

    public function showUserFile(string $path){
        $ableToSee = 
        (str_contains($path, auth()->id())) ||
        (auth()->user()->role->name == 'Recursos Humanos');

        if (!$ableToSee){
            return abort(403, 'No tienes permiso para ver este archivo.');
        }

        // NECESARIO PARA EVITAR QUE EL NAVEGADOR CACHEE LA IMAGEN Y MUESTRE CORRECTAMENTE SI HAY O NO
        return response()->file(storage_path("app/public/{$path}"), [
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }

    public function showPermitFile(Permit $permit, string $path){
        $ableToSee = 
        (auth()-> id() == $permit->user_id) ||
        (auth()-> id() == $permit->boss_id) ||
        (auth()->user()->role->name == 'Recursos Humanos');

        if (!$ableToSee){
            return abort(403, 'No tienes permiso para ver este archivo.');           
        }

        // NECESARIO PARA EVITAR QUE EL NAVEGADOR CACHEE LA IMAGEN Y MUESTRE CORRECTAMENTE SI HAY O NO
        return response()->file(storage_path("app/public/{$path}"), [
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }

    public function showRequisitionFile(Requisition $requisition, string $path){
        // $ableToSee = 
        // (auth()-> id() == $requisition->request_id) ||
        // (auth()-> id() == $requisition->boss_id) ||
        // (auth()->user()->role->name == 'Recursos Humanos');

        // if (!$ableToSee){
        //     return abort(403, 'No tienes permiso para ver este archivo.');           
        // }

        // NECESARIO PARA EVITAR QUE EL NAVEGADOR CACHEE LA IMAGEN Y MUESTRE CORRECTAMENTE SI HAY O NO
        return response()->file(storage_path("app/public/{$path}"), [
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }

}
