<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    use AuthorizesRequests;

    public function download(string $locale, Document $document)
    {
        $this->authorize('view', $document);

        if (config('filesystems.default') === 's3') {
            return redirect()->away(
                Storage::disk('s3')->temporaryUrl($document->path, now()->addMinutes(30))
            );
        }

        return Storage::response($document->path);
    }
}
