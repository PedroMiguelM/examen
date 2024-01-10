<?php

namespace App\Http\Controllers;
use App\Models\Tareas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class TareasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tareas = Tareas::all();        
        return view('tarea.index', ['tareas' => $tareas]);    
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tarea.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validar los datos del formulario
            $validatedData = $request->validate([
                'nombre' => '',
                'estado' => '',
                'descripcion' => ''
            ]);
            $tareas = new Tareas();

            $tareas->nombre = $validatedData['nombre'];
            $tareas->estado = $validatedData['estado'];
            $tareas->descripcion = $validatedData['descripcion'];
            $tareas->save();
            return view("tarea.message_ok",['msg'=>"registro ok"]);    
        } catch (\Exception $save_insertar) {
            return view("tarea.message_ko",['msg'=>"registro fallido"]).$save_insertar->getMessage();            
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Tareas $tareas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {   
        $tarea = Tareas::find($id);
        return view('tarea.edit', compact('tarea'));
        
    }

    public function update(Request $request, Tareas $tarea)
    {
        try {
            // Validar los datos del formulario
            $validatedData = $request->validate([
                'nombre' => '',
                'estado' => '',
                'descripcion' => ''
            ]);
            
            // Actualizar los datos de la tarea existente
            $tarea->nombre = $validatedData['nombre'];
            $tarea->estado = $validatedData['estado'];
            $tarea->descripcion = $validatedData['descripcion'];
            $tarea->save();
    
            return view("tarea.message_ok", ['msg' => "Registro actualizado correctamente"]);    
        } catch (\Exception $exception) {
            return view("tarea.message_ko", ['msg' => "Error al actualizar el registro: " . $exception->getMessage()]);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    //Elimina un objeto especifico del store.
    public function destroy($id){
        try {            
            $factura = Tareas::find($id); //Buscará el objeto a eliminar o el dato
            $factura->delete();//Este metodo sera el que elimine el objeto de dicha tabla
            //Retornamos un valor para que nos muestre si el registro ha sido eliminado
            return view("tarea.message_ok",['msg'=>"El registro eliminado correctamente"]);            
        } catch (\Exception $destroy) {
            //Retornamos un valor para que nos muestre si el registro ha sido eliminado            
            return view("tarea.message_ko",['msg'=>"La eliminación del registro ha fallado"]).$destroy->getMessage();            
        }
    }
}
