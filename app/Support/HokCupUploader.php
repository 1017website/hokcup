<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class HokCupUploader
{
    public static function store(?UploadedFile $file, ?string $oldValue = null, string $directory = 'hokcup'): ?string
    {
        if (!$file) {
            return $oldValue;
        }

        if ($oldValue && ! Str::startsWith($oldValue, ['http://', 'https://'])) {
            Storage::disk('public')->delete($oldValue);
        }

        return $file->store($directory, 'public');
    }
}
