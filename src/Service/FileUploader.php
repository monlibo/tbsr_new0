<?php
/**
 * Created by IntelliJ IDEA.
 * User: adolphe
 * Date: 06/12/2016
 * Time: 17:06
 */

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;



class FileUploader
{

    private $targetDir;

    public function __construct()
    {
        //$this->targetDir = $targetDir;
    }

    public function upload(UploadedFile $file, $target)
    {
        if($file->guessExtension() != "jpg" && $file->guessExtension() != "jpeg" &&  $file->guessExtension() != "png"  ) {
            $fileName = "erreur";
        }
        else{
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($target, $fileName);
        }

        return $fileName;
    }

}