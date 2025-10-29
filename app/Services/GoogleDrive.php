<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Exception;
use InvalidArgumentException;
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
     * Download file from Google Drive to local storage
     *
     * @param string $fileID The ID of the file to download
     * @param string $localPath The local path to save the file
     * @return string The local file path
     * @throws RuntimeException If the download fails
     */
    public function downloadFile(string $fileID, string $localPath): string
    {
        try {
            if (empty($fileID)) {
                throw new InvalidArgumentException('File ID cannot be empty');
            }

            $filePath = $this->folderID . '/' . $fileID;

            // Check if file exists in Google Drive
            if (!Storage::disk('google')->exists($filePath)) {
                throw new RuntimeException('File not found in Google Drive');
            }

            // Get file content
            $fileContent = Storage::disk('google')->get($filePath);

            if (!$fileContent) {
                throw new RuntimeException('Failed to get file content from Google Drive');
            }

            // Ensure directory exists
            $directory = dirname($localPath);
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }

            // Save file locally
            if (!file_put_contents($localPath, $fileContent)) {
                throw new RuntimeException('Failed to save file locally');
            }

            return $localPath;

        } catch (Exception $e) {
            throw new RuntimeException('File download failed: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Get file size from Google Drive
     *
     * @param string $fileID The ID of the file
     * @return int File size in bytes
     * @throws RuntimeException If cannot get file size
     */
    public function getFileSize(string $fileID): int
    {
        try {
            if (empty($fileID)) {
                throw new InvalidArgumentException('File ID cannot be empty');
            }

            $filePath = $this->folderID . '/' . $fileID;
            $fileMetaData = Storage::disk("google")->getAdapter()->getMetadata($filePath);

            if (!$fileMetaData) {
                throw new RuntimeException('File not found in Google Drive');
            }

            return $fileMetaData['size'] ?? 0;

        } catch (Exception $e) {
            throw new RuntimeException('Failed to get file size: ' . $e->getMessage(), 0, $e);
        }
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

    /**
     * Get a shareable URL for a file in Google Drive
     *
     * @param string $fileID The ID of the file
     * @return string The shareable URL
     * @throws RuntimeException If the URL cannot be generated
     */
    public function getFileUrl(string $fileID): string
    {
        try {
            if (empty($fileID)) {
                throw new InvalidArgumentException('File ID cannot be empty');
            }

            $filePath = $this->folderID . '/' . $fileID;
            $fileMetaData = Storage::disk("google")->getAdapter()->getMetadata($filePath);

            if (!$fileMetaData) {
                throw new RuntimeException('File not found in Google Drive');
            }

            $baseUrl = 'https://drive.google.com/file/d/';

            return $baseUrl . $fileID . '/view';

        } catch (Exception $e) {
            throw new RuntimeException('Failed to get file URL: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Get Google Drive image URL in lh3.googleusercontent.com format
     *
     * @param string $fileID The ID of the file
     * @return string The image URL
     * @throws RuntimeException If the URL cannot be generated
     */
    public function getImageUrl(string $fileID): string
    {
        try {
            if (empty($fileID)) {
                throw new InvalidArgumentException('File ID cannot be empty');
            }

            $filePath = $this->folderID . '/' . $fileID;
            $fileMetaData = Storage::disk("google")->getAdapter()->getMetadata($filePath);

            if (!$fileMetaData) {
                throw new RuntimeException('File not found in Google Drive');
            }

            return "https://lh3.googleusercontent.com/d/" . $fileID;
        } catch (Exception $e) {
            throw new RuntimeException('Failed to get image URL: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Get a direct download URL for a file in Google Drive
     *
     * This method generates a direct binary access link to a file stored in Google Drive,
     * using the `uc?export=download` endpoint. The returned URL allows the file (e.g. a PDF)
     * to be downloaded or displayed directly — unlike the `/view` URL which opens
     * the Google Drive viewer.
     *
     * Example:
     *   Input:  1dKLlFgqXU5bXU7ZWvSzwVYiPPegggaLy
     *   Output: https://drive.google.com/uc?export=download&id=1dKLlFgqXU5bXU7ZWvSzwVYiPPegggaLy
     *
     * @param string $fileID The unique Google Drive file ID
     * @return string The direct binary file URL suitable for embedding or downloading
     * @throws RuntimeException If the file does not exist or URL generation fails
     */
    public function getFileDownloadUrl(string $fileID): string
    {
        try {
            if (empty($fileID)) {
                throw new InvalidArgumentException('File ID cannot be empty');
            }

            $filePath = $this->folderID . '/' . $fileID;
            $fileMetaData = Storage::disk("google")->getAdapter()->getMetadata($filePath);

            if (!$fileMetaData) {
                throw new RuntimeException('File not found in Google Drive');
            }

            return "https://drive.google.com/uc?export=download&id=" . $fileID;
        } catch (Exception $e) {
            throw new RuntimeException('Failed to get direct file URL: ' . $e->getMessage(), 0, $e);
        }
    }

}
