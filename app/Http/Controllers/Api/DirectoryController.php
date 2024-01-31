<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DirectoryController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $path = bucket_relative_path(
            $request->input('path', ''),
            $request->input('bucket')
        );

        Storage::createDirectory($path);

        if (! Storage::directoryExists($path)) {
            return response()->json([
                'message' => 'Directory could not be created',
            ], 500);
        }

        return response()->json([
            'message' => 'Directory created successfully',
        ]);
    }

    public function destroy(Request $request): JsonResponse
    {
        $path = bucket_relative_path(
            $request->input('path', ''),
            $request->input('bucket')
        );

        if (Storage::directoryExists($path) && ! Storage::deleteDirectory($path)) {
            return response()->json([
                'message' => 'Directory could not be deleted',
            ], 500);
        }

        return response()->json([
            'message' => 'Directory deleted successfully',
        ]);
    }

    public function exists(Request $request): JsonResponse
    {
        $path = bucket_relative_path(
            $request->input('path', ''),
            $request->input('bucket')
        );

        return response()->json([
            'exists' => Storage::directoryExists($path),
        ]);
    }

    public function files(Request $request): JsonResponse
    {
        $path = bucket_relative_path(
            $request->input('path', ''),
            $request->input('bucket')
        );

        $files = Storage::files($path, $request->input('recursive', false));

        // Remove bucket path from the file names
        foreach ($files as &$file) {
            $file = Str::of($file)->after($path)->__toString();
        }

        return response()->json([
            'files' => $files,
        ]);
    }
}
