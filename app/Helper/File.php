<?php 

namespace App\Helper;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;

Trait File
{
    public $public_path = "/public/admin/banners/";
    public $storage_path = "/storage/app/public/banners/";

    public function file($file, $path, $width, $height)
    {
        if ($file) {
            $extension   = $file->getClientOriginalExtension();
            $file_name   = $path.'-'.Str::random(30).date('h-i-s').'.'.$extension;
            $url         = $file->storePubliclyAs($this->public_path, $file_name, 'local');
            $public_path = public_path($this->storage_path.$file_name);
            $img         = Image::make($public_path)->resize($width, $height);
            $url         = preg_replace("/public/", "", $url);
            
            return $img->save($public_path) ? $url : '';
        }
    }
}