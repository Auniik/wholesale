<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;

trait FileUploadTrait
{
    /**
     * @param $imageName
     * @param array $size
     * @param null $folderName
     * @param null $year
     * @return null|string
     */
    protected function uploadImage($imageName, array $size, $folderName = null, $year = null)
    {
        if ($this->hasFile($imageName)){
            $toUploadName = $this->file($imageName)->hashName();
            $path = '';
            if ($folderName){
                $path = 'uploads/' . $folderName;
            } else {
                $path = 'uploads' . ($year ?? date('Y'));
            }
            File::makeDirectory($path, $mode = 0777, true, true);
            Image::make($this->file($imageName)->getRealPath())->resize($size[0], $size[1])->save("$path/$toUploadName");
            return $path.'/'.$toUploadName;
        }

        return null;
    }

    /**
     * @param $imageName
     * @param array $size
     * @param null $folderName
     * @return null|string
     */
    protected function uploadImageDateWise($imageName, array $size, $folderName = null)
    {
        if ($this->hasFile($imageName)){
            $toUploadName = $this->file($imageName)->hashName();
            $path = 'uploads/';
            if ($folderName){
                $path = $path . $folderName . '/';
            }
            $path = $path . date('Y') . '/' . date('F');

            File::makeDirectory($path, $mode = 0777, true, true);
            Image::make($this->file($imageName)->getRealPath())->resize($size[0], $size[1])->save("$path/$toUploadName");
            return $path.'/'.$toUploadName;
        }

        return null;
    }

    /**
     * @param $imageName
     * @param null $folderName
     * @return null|string
     */
    protected function uploadImageWithoutResize($imageName, $folderName = null)
    {
        if ($this->hasFile($imageName))
        {
            $toUploadName = $this->file($imageName)->hashName();
            $path = 'uploads/';
            if ($folderName){
                $path = $path . $folderName . '/';
            }
            $path = $path . date('Y') . '/' . date('F');

            File::makeDirectory($path, $mode = 0777, true, true);
            Image::make($this->file($imageName)->getRealPath())->save("$path/$toUploadName");
            return $path.'/'.$toUploadName;
        }
        return null;
    }

    /**
     * @param $imageName
     * @param array $size
     * @param null $oldName
     * @param null $folderName
     * @param null $year
     * @return null|string
     */
    protected function updateImage($imageName, array $size, $oldName = null, $folderName = null, $year = null)
    {
        if ($this->hasFile($imageName)){
            $toUploadName = $oldName ?? $this->file($imageName)->hashName();
            $path = '';
            if ($folderName){
                $path = 'uploads/' . $folderName;
            } else {
                $path = 'uploads' . ($year ?? date('Y'));
            }

            File::makeDirectory($path, $mode = 0777, true, true);
            Image::make($this->file($imageName)->getRealPath())->resize($size[0], $size[1])->save($oldName ?? "$path/$toUploadName");
            return $oldName ?? "$path/$toUploadName";
        }

        return $oldName;
    }

    protected function updateImageFromController($imageName, array $size, $oldName = null, $folderName = null, $year = null)
    {
        if (request()->hasFile($imageName)){
            $toUploadName = $oldName ?? request()->file($imageName)->hashName();
            $path = '';
            if ($folderName){
                $path = 'uploads/' . $folderName;
            } else {
                $path = 'uploads' . ($year ?? date('Y'));
            }

            File::makeDirectory($path, $mode = 0777, true, true);
            Image::make(request()->file($imageName)->getRealPath())->resize($size[0], $size[1])->save($oldName ?? "$path/$toUploadName");
            return $oldName ?? "$path/$toUploadName";
        }

        return $oldName;
    }


    /**
     * @param $imageName
     * @param array $size
     * @param null $oldName
     * @param null $folderName
     * @param null $year
     * @return null|string
     */
    protected function updateImageDateWise($imageName, array $size, $oldName = null, $folderName = null, $year = null)
    {
        if ($this->hasFile($imageName)){
            $toUploadName = $oldName ?? $this->file($imageName)->hashName();
            $path = '';
            if ($folderName){
                $path = 'uploads/' . $folderName;
            } else {
                $path = 'uploads' . ($year ?? date('Y')) . '/' . date('F');
            }

            File::makeDirectory($path, $mode = 0777, true, true);
            Image::make($this->file($imageName)->getRealPath())->resize($size[0], $size[1])->save($oldName ?? "$path/$toUploadName");
            return $oldName ?? "$path/$toUploadName";
        }

        return $oldName;
    }

    protected function uploadMultipleImage($image, array $size, $folderName = null, $year = null)
    {
        $toUploadName = $image->hashName();
        $path = '';
        if ($folderName){
            $path = 'uploads/' . $folderName;
        } else {
            $path = 'uploads' . ($year ?? date('Y'));
        }
        File::makeDirectory($path, $mode = 0777, true, true);
        Image::make($image->getRealPath())->resize($size[0], $size[1])->save("$path/$toUploadName");

        return $path.'/'.$toUploadName;
    }

    protected function deleteFile($file)
    {
        if (File::delete($file)){
            return true;
        }
    }
}