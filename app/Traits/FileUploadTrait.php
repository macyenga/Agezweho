<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait FileUploadTrait
{
    public function handleFileUpload(Request $request, $fieldName, $existingFilePath = null)
    {
        if ($request->hasFile($fieldName)) {
            if ($existingFilePath) {
                Storage::delete($existingFilePath);
            }
            return $request->file($fieldName)->store('uploads');
        }
        return $existingFilePath;
    }
}
