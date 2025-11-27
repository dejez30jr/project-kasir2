<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    // Stream public storage files without requiring OS symlink (works on Windows/XAMPP)
    public function show(string $path)
    {
        $try = ltrim($path, '/');
        $candidates = [ $try, 'products/'.basename($try) ];
        // If extension might be wrong/changed, try common alternatives within products/
        $basename = pathinfo($try, PATHINFO_FILENAME);
        if ($basename) {
            foreach (['jpg','jpeg','png','webp'] as $ext) {
                $candidates[] = "products/{$basename}.{$ext}";
            }
        }

        foreach ($candidates as $rel) {
            if (Storage::disk('public')->exists($rel)) {
                $full = storage_path('app/public/'.$rel);
                return response()->file($full);
            }
        }

        return abort(404);
    }
}
