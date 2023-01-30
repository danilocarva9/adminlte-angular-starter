<?php
namespace App\Services;

class UploadService
{
    private $uploadPath;

    public function __construct()
    {
        $this->uploadPath = 'public/uploads';
    }
   
    /**
     * Simple image upload
     *
     * @return string
     */
    public function uploadPicture($picture): String
    {
        $pictureOriginalName = $picture->getClientOriginalName();
        $pictureOriginalName_arr = explode('.', $pictureOriginalName);
        $fileExt = end($pictureOriginalName_arr);
        $pictureName = 'U-' . time() . '.' . $fileExt;
        if($picture->move($this->uploadPath, $pictureName)) {
           return $this->mountUrl($this->uploadPath.'/'.$pictureName);
        }
    }

    private function mountUrl($path)
    {
        return url().'/'.$path;
    }
   
}