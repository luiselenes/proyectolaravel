<?php

namespace App\Http\Controllers;

use App\Models\clientes;
use Egulias\EmailValidator\Validation\Error\RFCWarnings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ClientesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $rfc =$request->get('Search');

      
        $datos['clientest']=clientes::where('rfc','like',"%$rfc%")->paginate(5);
        return view('cliente.index',$datos);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cliente.crear');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
       $datoscliente= request()->all();
        $campos=[
            'rfc' =>'required|string|max:13|min:13|',
            'nombre' =>'required|string|max:50',
            'edad' =>'required|integer',
            'idciudad'=>'required|integer'
        ];
        $mensaje = ["required"=>'El dato :attribute es requerido'];
        $this->validate($request,$campos,$mensaje);


        $datoscliente=request()-> except('_token');

        clientes::insert($datoscliente);

        //return response()->json($datoscliente);
        return redirect('cliente')->with('Mensaje','Cliente agregado exitosamente');


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function show(clientes $clientes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $cliente=clientes::findOrFail($id);
        return view('cliente.edit',compact('cliente'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
         
        $datoscliente= request()->all();
        $campos=[
            'nombre' =>'required|string|max:50',
            'edad' =>'required|integer',
            'idciudad'=>'required|integer'
        ];
        $mensaje = ["required"=>'El dato :attribute es requerido'];
        $this->validate($request,$campos,$mensaje);

        $datoscliente=request()-> except(['_token','_method','clientes.updated_at']);
        clientes::where('id','=',$id)->update($datoscliente);

        return redirect('cliente')->with('Mensaje','Datos de cliente modificados exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        clientes::destroy($id);

        //return 'hola';
        //return redirect('cliente');
        return redirect('cliente')->with('Mensaje','Datos de cliente eliminado');

    }
}
