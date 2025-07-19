<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Exception;
use RuntimeException;

class GoogleDrive
{
    private string $folderID;

    public function __construct(string $folderID)
    {
        if (empty($folderID)) {
            throw new InvalidArgumentException('Folder ID cannot be empty');
        }
        $this->folderID = $folderID;
    }

    /**
     * Upload an image file to Google Drive
     *
     * @param mixed $file The file to upload
     * @param string $fileName The desired file name
     * @param string $filePath The path where to store the file
     * @return array ['fileName' => string, 'gdriveID' => string]
     * @throws RuntimeException If the upload fails
     */
    public function uploadImage($file, string $fileName, string $filePath): array
    {
        try {
            if (!is_uploaded_file($file->getPathname())) {
                throw new RuntimeException('Invalid file upload');
            }

            if (!Storage::cloud()->put($filePath, File::get($file))) {
                throw new RuntimeException('Failed to store file in Google Drive');
            }

            $fileMetaData = Storage::disk("google")->getAdapter()->getMetadata($filePath);

            if (!$fileMetaData) {
                throw new RuntimeException('Failed to retrieve file metadata from Google Drive');
            }

            $gdriveID = basename($fileMetaData['path']);

            if (empty($gdriveID)) {
                throw new RuntimeException('Invalid Google Drive file ID');
            }

            return [
                'fileName' => $fileName,
                'gdriveID' => $gdriveID
            ];
        } catch (Exception $e) {
            throw new RuntimeException('Image upload failed: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Upload any file to Google Drive
     *
     * @param mixed $file The file to upload
     * @param string $fileName The desired file name
     * @param string $filePath The path where to store the file
     * @return array ['fileName' => string, 'gdriveID' => string]
     * @throws RuntimeException If the upload fails
     */
    public function uploadFile($file, string $fileName, string $filePath): array
    {
        try {
            if (!is_uploaded_file($file->getPathname())) {
                throw new RuntimeException('Invalid file upload');
            }

            if (!Storage::cloud()->put($filePath, File::get($file))) {
                throw new RuntimeException('Failed to store file in Google Drive');
            }

            $fileMetaData = Storage::disk("google")->getAdapter()->getMetadata($filePath);

            if (!$fileMetaData) {
                throw new RuntimeException('Failed to retrieve file metadata from Google Drive');
            }

            $gdriveID = basename($fileMetaData['path']);

            if (empty($gdriveID)) {
                throw new RuntimeException('Invalid Google Drive file ID');
            }

            return [
                'fileName' => $fileName,
                'gdriveID' => $gdriveID
            ];
        } catch (Exception $e) {
            throw new RuntimeException('File upload failed: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Delete an image file from Google Drive
     *
     * @param string $fileID The ID of the file to delete
     * @throws RuntimeException If the deletion fails
     */
    public function deleteImage(string $fileID): void
    {
        $this->deleteFile($fileID);
    }

    /**
     * Delete any file from Google Drive
     *
     * @param string $fileID The ID of the file to delete
     * @throws RuntimeException If the deletion fails
     */
    public function deleteFile(string $fileID): void
    {
        try {
            if (empty($fileID)) {
                throw new InvalidArgumentException('File ID cannot be empty');
            }

            $fullPath = $this->folderID . '/' . $fileID;

            if (!Storage::disk('google')->exists($fullPath)) {
                throw new RuntimeException('File not found in Google Drive');
            }

            if (!Storage::disk('google')->delete($fullPath)) {
                throw new RuntimeException('Failed to delete file from Google Drive');
            }
        } catch (Exception $e) {
            throw new RuntimeException('File deletion failed: ' . $e->getMessage(), 0, $e);
        }
    }
}
