<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getResponse($status, $message, $data = null, $route = null)
	{
		if(request()->expectsJson()) {
			$response = ["status" => $status, "message" => $message];
			if($data !== null) {
				$response["data"] = $data;
			}
			$result = response()->json($response, 200);
		} else {
			session()->flash($status ? 'message' : 'error', $message);

			if(!$route){
				$result = redirect()->route((explode(".", request()->route()->getName()))[0].".index");
			}else{
				$result = $route;
			}
		}

		return $result;
	}

	public function getErrorMessage($e, $translations)
	{
		if($e->getCode() == "23000") {
			$error = __($translations.'.delete_error_message_constraint');
		}
		else {
			$error = __($translations.'.delete_error_message');
		}
		
		return $error.'. <br>
			<a href="#" data-bs-toggle="collapse" data-bs-target="#errorDetails">'.__('Show details').':</a>
			<span id="errorDetails" class="collapse" aria-expanded="false">'.$e->getMessage().'</span>';
	}

	public function getViewDataTable($dataTable, $entity, $permissions = [], $route = null, $parameters = [])
    {
		$dataTable = $dataTable->html();
		
        $dataTable = $dataTable->ajax(route($route ?? $entity.'.index', $parameters));
        return ["view" => view('components.datatable', compact('dataTable', 'permissions','entity'))->render(),
            "scripts" => $dataTable->scripts()];
    }
}
