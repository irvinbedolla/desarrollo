<?php

namespace App\Http\Controllers;
use App\Models\User;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    public function index()
    {
        addVendors(['amcharts', 'amcharts-maps', 'amcharts-stock']);
        
        $id_usuario = auth()->user()->id;
        $user = User::find($id_usuario);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name')->all();
        $sede = $user->delegacion;
        

        if($userRole[0] == "Super Usuario" || $userRole[0] == "Administrador" || $userRole[0] == "Estadistica"){
            $sede = ["Morelia", "Zítacuaro","Uruapan", "Lázaro Cárdenas","Zamora", "Sahuayo"];
            $conciliador = User::whereHas($relacionEloquent, function ($query) {
                    return $query->where('name', '=', 'Conciliador');
                })
                ->get();
        }
        //puede ver las sede y conciliadores
        elseif($userRole[0] == "Delegado" || $userRole[0] == "Enlace"){
            if($delegacion == "Morelia"){
                $sede = ["Morelia", "Zítacuaro"];
                $conciliador = User::whereHas($relacionEloquent, function ($query) {
                    return $query->where('name', '=', 'Conciliador');
                })
                ->where('delegacion', $delegacion)
                ->get();
            }
            else if($delegacion == "Uruapan"){
                $sede = ["Uruapan", "Lázaro Cárdenas"];
                $conciliador = User::whereHas($relacionEloquent, function ($query) {
                    return $query->where('name', '=', 'Conciliador');
                })
                ->where('delegacion', $delegacion)
                ->get();
            }
            else if($delegacion == "Zamora"){
                $sede = ["Zamora", "Sahuayo"];
                $conciliador = User::whereHas($relacionEloquent, function ($query) {
                    return $query->where('name', '=', 'Conciliador');
                })
                ->where('delegacion', $delegacion)
                ->get();
            }
        }
        //puede ver unicamente las sede
        else if($userRole[0] == "Conciliador"){
            if($delegacion == "Morelia"){
                $sede = ["Morelia", "Zítacuaro"];
            }
            else if($delegacion == "Uruapan"){
                $sede = ["Uruapan", "Lázaro Cárdenas"];
            }
            else if($delegacion == "Zamora"){
                $sede = ["Zamora", "Sahuayo"];
            }
            $conciliadores = "";
        }
        

        return view('pages/dashboards.index', compact('userRole','sede','conciliador'));
    }
}
