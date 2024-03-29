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
            $request->input('bucket'),
            $request->input('path')
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

    public function show(Request $request): string
    {
        $path = bucket_relative_path(
            $request->input('bucket'),
            $request->input('path')
        );

        if (! Storage::fileExists($path)) {
            return response('', 404);
        }

        return Storage::get($path);
    }

    public function destroy(Request $request): JsonResponse
    {
        $path = bucket_relative_path(
            $request->input('bucket'),
            $request->input('path')
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
            $request->input('bucket'),
            $request->input('path')
        );

        return response()->json([
            'exists' => Storage::exists($path),
        ]);
    }

    public function meta(Request $request): JsonResponse
    {
        $path = bucket_relative_path(
            $request->input('bucket'),
            $request->input('path')
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

    public function move(Request $request): JsonResponse
    {
        $source = bucket_relative_path(
            $request->input('bucket'),
            $request->input('source')
        );

        $destination = bucket_relative_path(
            $request->input('bucket'),
            $request->input('destination')
        );

        return response()->json([
            'moved' => Storage::move($source, $destination),
        ]);
    }

    public function copy(Request $request): JsonResponse
    {
        $source = bucket_relative_path(
            $request->input('bucket'),
            $request->input('source')
        );

        $destination = bucket_relative_path(
            $request->input('bucket'),
            $request->input('destination')
        );

        return response()->json([
            'copied' => Storage::copy($source, $destination),
        ]);
    }
}
