<?php
namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

class MediaService
{
    public static function imageIntervention($file) 
    {
        $path = $file; 

        $thumbPath = null;

        //check if the file is an image
        if(str_starts_with($file->getMimeType(), 'image/')){
            $thumbPath = 'media/images/thumbs/'.pathinfo($path, PATHINFO_FILENAME).'_thumb.jpg';
            $image = ImageManager::imagick()->read($path);
            //resize image to max width of 800px and max height of 600px
            $image->scale(800,600);
            //encode image to jpg format and save to storage
            $image->toJpeg(75)->save('storage/app/public/'.$thumbPath);
        }

        // Temporary: strip the storage path from the file path
        $temp = str_replace('/Users/hq/Developer/Em_Dash/storage/app/public/', '', $path);
        return [
            'location' => $temp,
            'thumb' => $thumbPath,
            'type' => $file->getMimeType(),
            'title' => pathinfo($path, PATHINFO_FILENAME) ?? null,
        ];
    }
}