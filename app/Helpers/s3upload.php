<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Str;
use Log;
use File;

class s3upload
{
    /**
     * Upload a file to S3 and return the file URL.
     *
     * @param  \Illuminate\Http\UploadedFile $file
     * @param  string $folder
     * @return string|false
     */
    public static function uploadToS3($file, $folder = 'uploads')
    {
        try {
            // Generate a unique file name
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $folder . '/' . $fileName;

            // Upload file to S3 with public visibility
            Storage::disk('s3')->put($filePath, file_get_contents($file), ['visibility' => 'public']);
            // Return the file URL
            return Storage::disk('s3')->url($filePath);
        } catch (\Exception $e) {
            return false;
        }
    }
}
