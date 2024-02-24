<?php
namespace App\Services;

use App\Models\Media;
class ImageService
{
    public function getImages($id, $collection_name = 'autos')
    {
        $storeFolder = storage_path('app/public');

        $images = Media::where('model_id', $id)->where('collection_name', $collection_name)->get()->toArray();

        //Si no hay imagenes, retornar un array vacio
        if (count($images) == 0) {
            return [];
        }

        //Crear array con los nombres de las imagenes
        $tableImages = [];
        foreach($images as $image){
            $tableImages[] =$image['id'].'/'.$image['file_name'];
        }

        return $tableImages;
    }


}

