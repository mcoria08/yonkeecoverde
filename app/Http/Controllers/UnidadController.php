<?php

namespace App\Http\Controllers;

use App\Models\Unidad;
use App\Models\Stock;
use App\Services\ImageService;
use Illuminate\Http\Request;
use DataTables;

class UnidadController extends Controller
{
    protected $imageService;
    protected $fillable = ['proviene', 'datos', 'unidad', 'marca', 'modelo', 'anio', 'detalles', 'motor', 'observaciones'];


    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $btn = '<a href="#" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Imagen</a>';
        if ($request->ajax()) {
            $data = Unidad::select('*')->orderBy('id', 'DESC')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="/unidad/'.$row->id.'/ver" class="edit btn btn-primary btn-sm">Ver</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('dashboard');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function saveUnit(Request $request)
    {
        //dd($request->all());
        $id = null;
        if ($request->has('id')) {
            $id = $request->input('id');
        }

        // Validation rules
        $rules = [
            'txtProviene' => 'required|min:5',
            'txtDatos' => 'required|min:5',
            'txtUnidad' => 'required|min:5',
            'txtMarca' => 'required|min:5',
            'txtModelo' => 'required|min:5',
            'txtAnio' => 'digits_between:2,4',
            'txtDetalles' => 'required|min:5',
            'txtMotor' => 'required|min:3',
            'txtObservaciones' => 'required|min:5'
        ];

        // Custom error messages
        $messages = [
            'txtProviene.required' => 'Proviene es requerido con al menos 5 caracteres.',
            'txtDatos.required' => 'Datos es requerido con al menos 5 caracteres.',
            'txtUnidad.required' => 'Unidad es requerido con al menos 5 caracteres.',
            'txtMarca.required' => 'Marca es requerido con al menos 5 caracteres.',
            'txtModelo.required' => 'Modelo es requerido con al menos 5 caracteres.',
            'txtAnio.required' => 'Año es requerido con al menos 4 dígitos.',
            'txtDetalles.required' => 'Detalles es requerido con al menos 5 caracteres.',
            'txtMotor.required' => 'Motor es requerido con al menos 5 caracteres.',
            'txtObservaciones.required' => 'Observaciones es requerido con al menos 5 caracteres.',
        ];

        // Aplicar reglas
        $validatedData = $request->validate($rules, $messages);

        // Map fields
        $mapFields = [
            'txtProviene' => 'proviene',
            'txtDatos' => 'datos',
            'txtUnidad' => 'unidad',
            'txtMarca' => 'marca',
            'txtModelo' => 'modelo',
            'txtAnio' => 'anio',
            'txtDetalles' => 'detalles',
            'txtMotor' => 'motor',
            'txtObservaciones' => 'observaciones',
        ];

        $mappedData = [];
        foreach ($mapFields as $requestKey => $dbField) {
            if (isset($validatedData[$requestKey])) {
                $mappedData[$dbField] = $validatedData[$requestKey];
            }
        }

        // Crear/update unidad
        if ($id) {
            // Update an existing record
            $unidad = Unidad::find($id);

            $unidad->update($mappedData);
        } else {
            // Create a new record
            $unidad = Unidad::create($mappedData);
        }

        // move gallery media
        if ($request->has('gallery')) {
            foreach ($request->input('gallery', []) as $file) {
                $unidad->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('autos');
            }
        }

        $msgAction = ($id) ? 'Nueva Unidad Creada' : 'Unidad Actualizada';
        $stringRoute = 'dashboard';

        toastr()->success($msgAction, 'Mensaje');
        return redirect()->route($stringRoute);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {

    }

    /**
     * Display the specified resource.
     */
    public function show($nId)
    {
        $unidad = Unidad::find($nId);

        //Obteniendo ls lista de imagenes de la base de datos
        $images = $this->imageService->getImages($nId, 'autos');

        $stock = Stock::where('id_unidad', $nId)->get();

        return view('car-show', compact('unidad', 'images', 'stock'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Unidad $unidad)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Unidad $unidad)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unidad $unidad)
    {
        //
    }
}
