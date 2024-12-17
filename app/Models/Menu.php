<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'icon', 'position', 'parent_id', 'permission_id'];

    public function parent()
	{
        return $this->belongsTo('App\Models\Menu', 'parent_id');
	}

    public function submenus()
    {
        return $this->hasMany('App\Models\Menu', "parent_id", "id");
    }

    public function hasSubmenus()
    {
        return count($this->submenus) > 0;
    }

    public function permission()
    {
        return $this->belongsTo('App\Models\PermissionPermission', 'permission_id');
    }

    //Para saber si tiene submenus por mostrar (por permisos), en caso de no tener nada que mostrar tampoco mostrar el principal
    public function showSubmenus()
    {
        foreach ($this->submenus as $key => $submenu) {
            if (auth()->user()->hasPermissions($submenu->permission->permissionModule->name.".index")) {
                return true;
            }
        }
        return false;
    }

    //Esta funcion sirve para saber si hay alguno de los hijos del menú activo para que tambien se active el padre
    public function isParentActive($path)
    {
        //Usar solo la primera parte del path ej. roles/create, solo usar roles
        $path = explode('/', $path)[0];

        foreach ($this->submenus as $submenu){
            if ($path == $submenu->permission->permissionModule->name) {
                return true;
            }
        }
        return false;
    }
}
