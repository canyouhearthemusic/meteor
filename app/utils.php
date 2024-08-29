<?php

declare(strict_types=1);

use Illuminate\Http\UploadedFile;

if (!function_exists('generate_filename')) {
    function generate_filename(string $prefix, UploadedFile $img): string
    {
        return $prefix . '_' . uuid_create() . '.' . strtolower($img->getClientOriginalExtension());
    }
}