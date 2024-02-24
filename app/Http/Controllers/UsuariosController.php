<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use DataTables;
use Illuminate\Support\Str;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;

class UsuariosController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::select('*')->orderBy('id', 'DESC')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="/usuarios/'.$row->id.'/ver" class="edit btn btn-primary btn-sm">Ver</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('usuarios');
    }

    public function saveUser(Request $request)
    {
        //dd($request->all());
        $id = null;
        if ($request->has('id')) {
            $id = $request->input('id');
        }

        // Validation rules
        $rules = [
            'txtName' => 'required|min:5|max:100',
            'txtEmail' => 'required|email',
            'txtPassword' => 'required|min:5|max:100',
        ];

        // Custom error messages
        $messages = [
            'txtName.required' => 'Nombre de parte es requerido con al menos 5 caracteres.',
            'txtEmail.required' => 'Email es requerido.',
            'txtPassword.required' => 'Password es requerido.',
        ];

        // Aplicar reglas
        $validatedData = $request->validate($rules, $messages);

        // Asginar los valores del submit a cada campo correcpondiente
        $mapFields = [
            'txtName' => 'name',
            'txtEmail' => 'email',
            'txtPassword' => 'password',
        ];

        $mappedData = [];
        foreach ($mapFields as $requestKey => $dbField) {
            if (isset($validatedData[$requestKey])) {
                $mappedData[$dbField] = $validatedData[$requestKey];
            }
        }

        // Agregando los valores del dropdown
        $mappedData['type'] = $request->input('txtTypeUSer');

        // Crear/update pieza
        if ($id) {
            // Update an existing record
            $usuario = User::find($id);
            $usuario->update($mappedData);
        } else {
            // Create a new record
            $usuario = User::create($mappedData);
            $usuario->save();
        }

        // Update the forDecryptPassword field
        $password = $request->input('txtPassword');
        $encryptedPassw = Crypt::encryptString($request->input('txtPassword'));

        $usuario->forDecryptPassword = $encryptedPassw;
        $usuario->save();

        //Send email
        Mail::to($usuario->email)->send(new WelcomeEmail($usuario, $password));

        $msgAction = (!$id) ? 'Nuevo Usuario Creado' : 'Usuario Actualizado';
        $stringRoute = 'usuarios.index';

        toastr()->success($msgAction, 'Mensaje');
        return redirect()->route($stringRoute);
    }


    /**
     * Display the specified resource.
     */
    public function show($nId)
    {
        $usuario = User::find($nId);
        $decryptedPassw = Crypt::decryptString($usuario->forDecryptPassword);

        return view('usuarios-show', compact('usuario', 'decryptedPassw' ));
    }



    public function saveGeneratePassword()
    {
        $randomPassword = Str::random(12); // You can adjust the length of the password
        return response()->json(['password' => $randomPassword]);
    }

}
