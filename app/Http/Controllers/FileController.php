<?php
namespace App\Http\Controllers;
use App\Events\FileStatus;
use App\Models\File;
use Illuminate\Http\Request;
use ZipArchive;

class FileController extends Controller
{
    /**
     * retrieve files.
     */
    public function show() {
        $files = File::where('user_id', auth()->user()->id)->get();
        return view('files.index', ['files' => $files]);
    }

    public function index() {
        return view('upload');
    }
    /**
     * upload files.
     */
    public function upload(Request $request) {
        foreach ($request->file('files') as $file) {
            sleep(1);
            FileStatus::dispatch($file->getClientOriginalName());
            $path = $file->store('uploads');
            $path = 'app/' . $path;
            File::create([
                'name' => $file->getClientOriginalName(),
                'path' => $path,
                'user_id' => auth()->user()->id,
            ]);
        }
        return back();
    }
    /**
     * download files.
     */
    public function download($id)
    {
        find($id);
        return response()->download(storage_path('app/' . $file->path));
    }
    /**
     * download multiple files.
     */
    public function downloadMultiple(Request $request)
    {   
        $files_requested = $request['files'];
        $files = File::whereIn('id', $files_requested)->get();
        $zip = new ZipArchive;
        $zipFileName =  'Attachment-' . 'files'. '.zip';
        if ($zip->open(public_path($zipFileName), ZipArchive::CREATE) === true) {
        foreach ($files as $file) {
            $filePath = storage_path($file->path);
            $filesToZip[] = $filePath;
        }
        foreach ($filesToZip as $file) {
            $zip->addFile($file, basename('/app' . $file));
        }
        $zip->close();
        return response()->download(public_path($zipFileName))->deleteFileAfterSend(true);
        }
    }
}