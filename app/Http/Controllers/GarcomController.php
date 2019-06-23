<?php

namespace App\Http\Controllers;

use App\Models\Mesa;
use Illuminate\Http\Request;
use App\Events\ListaMesas;

class GarcomController extends Controller
{
    public function mesas(){

        $params = Mesa::orderBy('id', 'asc')->get();
        return response()->json(
            $params, 200);
    }
    public function atualizaStatusMesa(Request $request, $id){
        Mesa::where('id', $id)->update([
            'status' =>  $request['status'],
        ]);
        $params = Mesa::orderBy('id', 'asc')->get();
        event(new ListaMesas($params));
        return response()->json(
            $params, 200);
    }
}
