<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegistrationDocument;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class DocumentViewController extends Controller
{
    public function show(Request $request, $id)
    {
        $document = RegistrationDocument::findOrFail($id);
        
        if (empty($document->file_path)) {
            abort(404, 'Path file tidak valid');
        }
        
        $filePath = storage_path('app/public/' . $document->file_path);
        
        if (!file_exists($filePath)) {
            abort(404, 'File tidak ditemukan: ' . $document->original_name);
        }
        
        if ($request->has('download')) {
            return Response::download($filePath, $document->original_name ?? 'document');
        }
        
        return Response::file($filePath);
    }
}