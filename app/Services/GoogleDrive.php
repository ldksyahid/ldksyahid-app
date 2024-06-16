<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class GoogleDrive
{
    private $folderID;

    public function __construct($folderID)
    {
        $this->folderID = $folderID;
    }

    public function uploadImage($file, $fileName, $filePath)
    {
        Storage::cloud()->put($filePath, File::get($file));
        $fileMetaData = Storage::disk("google")->getAdapter()->getMetadata($filePath);
        $gdriveID = basename($fileMetaData['path']);

        return ['fileName' => $fileName, 'gdriveID' => $gdriveID];
    }

    public function deleteImage($fileID)
    {
        Storage::disk('google')->delete($this->folderID . '/' . $fileID);
    }
}
