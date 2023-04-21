<?php

namespace App\Traits;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

trait ImageTrait
{
    public function uploadImage($image , $modelName)
    {
        $imageName = Str::random() . '_' . $image->getClientOriginalName();
        $image_path = $image->storeAs($modelName,$imageName,'public');
        return $imageName;
    }

    public function destroyCategoryImage($image , $modelName)
    {
        $exist = Storage::disk('public')->exists($modelName."/{$image}");
        if ($exist) {
            Storage::disk('public')->delete($modelName."/{$image}");
        }
    }


    public function destroyImage($images , $modelName)
    {
        foreach ($images->image as $img){
            if ($img) {
                $exist = Storage::disk('public')->exists($modelName."/{$img}");
                if ($exist) {
                    Storage::disk('public')->delete($modelName."/{$img}");
                }
            }
        }
    }

    public function Qr_Image($image_name)
    {
        //--QR Image..---
        $name = $image_name;
        $qr_img_type = 'png';
        $qr_image = Str::slug($name) . 'QR' .Str::random(). '.' . $qr_img_type;
        $body = 'https://www.youtube.com/';
        $qr = QrCode::format($qr_img_type);
        $qr->size('300');
        //--Store QR-Image..
        $qr->generate($body,'storage/product/'. $qr_image);
       return $qr_image;
    }

}
