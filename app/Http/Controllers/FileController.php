<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Media;

use App\Services\ImageService;

class FileController extends Controller
{

    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



    public function index(): View
    {
        return view('fileUpload');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $response = [];

        $path = storage_path('tmp/uploads');
        //$path = public_path($this->pathAutos);
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $files = $request->file('files');
        if (is_array($files)) {
            foreach($files as $index => $file) {
                $name = uniqid() . '_' . trim($file->getClientOriginalName());
                $file->move($path, $name);

                $response[$index]['name'] = $name;
                $response[$index]['original_name'] = $file->getClientOriginalName();
            }
        }

        return response()->json($response);
    }

    public function getImages($id, $collection_name = 'autos')
    {
        // Use the ImageService to get images
        $tableImages = $this->imageService->getImages($id, $collection_name);

        return $tableImages;
    }



    public function destroy($id)
    {
        // Find the image by ID
        $image = Media::find($id);

        // Check if the image exists
        if ($image) {
            // Delete the image from storage
            $path = storage_path("app/public/{$image->id}/{$image->file_name}");
            if (file_exists($path)) {
                unlink($path);
            }

            // Delete the image from the database
            $image->delete();

            toastr()->success('Imagen eliminada', 'Mensaje');
            return response()->json(['message' => 'Image deleted successfully']);
        } else {
            toastr()->error('Imagen no encontrada', 'Mensaje');
            return response()->json(['error' => 'Image not found'], 404);
        }
    }
}
