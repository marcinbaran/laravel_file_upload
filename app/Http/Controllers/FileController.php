<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function index()
    {
        $files = Auth::user()->files;
        return view('dashboard', compact('files'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file',
        ]);

        $filePath = $request->file('file')->store('uploads', 'public');
        $fileName = $request->file('file')->getClientOriginalName();

        File::create([
            'user_id' => Auth::id(),
            'file_name' => $fileName,
            'file_path' => $filePath,
        ]);

        return back()->with('success', 'File uploaded successfully.');
    }

    public function download(File $file)
    {
        if (Auth::id() !== $file->user_id) {
            abort(403);
        }

        return Storage::disk('public')->download($file->file_path, $file->file_name);
    }

    public function destroy(File $file)
    {
        if (Auth::id() !== $file->user_id) {
            abort(403);
        }

        Storage::disk('public')->delete($file->file_path);
        $file->delete();

        return back()->with('success', 'File deleted successfully.');
    }
}
