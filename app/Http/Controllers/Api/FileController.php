<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        // Check if file already exists
//        if (Storage::exists($path.'/'.$fileName)) {
//            return response()->json([
//                'message' => 'File already exists'
//            ], 409);
//        }

        $path = bucket_path($request->input('path', ''));

        // Store file
        $stored = Storage::put($path, $request->input('contents', ''));

        // Check if file was stored
        if (! $stored) {
            return response()->json([
                'message' => 'File could not be stored'
            ], 500);
        }

        return response()->json([
            'message' => 'File uploaded successfully'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $path = bucket_path($request->input('path', ''));

        if (! Storage::fileExists($path)) {
            return response('', 404);
        }

        return Storage::get($path);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request): JsonResponse
    {
        $path = bucket_path($request->input('path', ''));

        // Check if file or folder exists
        if (! Storage::exists($path)) {
            return response()->json([
                'message' => 'File not found'
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
                'message' => 'File could not be deleted'
            ], 500);
        }

        return response()->json([
            'message' => 'File deleted successfully'
        ]);
    }

    public function exists(Request $request): JsonResponse
    {
        $path = bucket_path($request->input('path', ''));

        return response()->json([
            'exists' => Storage::exists($path)
        ]);
    }

    public function meta(Request $request): JsonResponse
    {
        $path = bucket_path($request->input('path', ''));

        return response()->json([
            'meta' => [
                'size' => Storage::fileSize($path),
            ],
        ]);
    }
}
