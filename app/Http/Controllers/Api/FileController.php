<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $path = bucket_relative_path(
            $request->input('path', ''),
            $request->input('bucket')
        );

        // Store file
        $stored = Storage::put($path, $request->input('contents', ''));

        // Check if file was stored
        if (! $stored) {
            return response()->json([
                'message' => 'File could not be stored',
            ], 500);
        }

        return response()->json([
            'message' => 'File uploaded successfully',
        ]);
    }

    public function show(Request $request)
    {
        $path = bucket_relative_path(
            $request->input('path', ''),
            $request->input('bucket')
        );

        if (! Storage::fileExists($path)) {
            return response('', 404);
        }

        return Storage::get($path);
    }

    public function destroy(Request $request): JsonResponse
    {
        $path = bucket_relative_path(
            $request->input('path', ''),
            $request->input('bucket')
        );

        // Check if file or folder exists
        if (! Storage::exists($path)) {
            return response()->json([
                'message' => 'File not found',
            ], 404);
        }

        // Delete file or folder
        if (Storage::directoryExists($path)) {
            $deleted = Storage::deleteDirectory($path);
        } else {
            $deleted = Storage::delete($path);
        }

        // TODO check if path folders are empty, if yes, remove them

        // Check if file was deleted
        if (! $deleted) {
            return response()->json([
                'message' => 'File could not be deleted',
            ], 500);
        }

        return response()->json([
            'message' => 'File deleted successfully',
        ]);
    }

    public function exists(Request $request): JsonResponse
    {
        $path = bucket_relative_path(
            $request->input('path', ''),
            $request->input('bucket')
        );

        return response()->json([
            'exists' => Storage::exists($path),
        ]);
    }

    public function meta(Request $request): JsonResponse
    {
        $path = bucket_relative_path(
            $request->input('path', ''),
            $request->input('bucket')
        );

        return response()->json([
            'meta' => [
                'size' => Storage::fileSize($path),
                'mime_type' => Storage::mimeType($path),
                'last_modified' => Storage::lastModified($path),
                'visibility' => Storage::getVisibility($path),
            ],
        ]);
    }
}
