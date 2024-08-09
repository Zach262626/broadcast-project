<?php
namespace App\Http\Controllers;

use App\Events\DownloadStatus;
use App\Events\UploadStatus;
use App\Models\File;
use App\Models\FileLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use ZipArchive;

class FileController extends Controller
{
    /**
     * retrieve files.
     */
    public function downloadIndex()
    {
        $files = File::where('user_id', auth()->user()->id)->get();
        return view('files.index', ['files' => $files]);
    }

    public function uploadIndex()
    {
        $files = File::where('user_id', auth()->user()->id)->get();
        return view('upload', ['files' => $files]);
    }
    /**
     * upload files.
     */
    public function upload(Request $request)
    {
        $status = 0;
        $count = 0;
        $total = count($request->file('files'));
        foreach ($request->file('files') as $file) {
            $count += 1;
            $status = (($count / $total) * 100);
            UploadStatus::dispatch($file->getClientOriginalName(), $status, Auth::id());
            $path = $file->store('uploads');
            $path = 'app/' . $path;
            $file_created = File::create([
                'name' => $file->getClientOriginalName(),
                'path' => $path,
                'user_id' => auth()->user()->id,
            ]);
        }
        return back();
    }
    /**
     * download files at path.
     */
    public function download(Request $request)
    {
        return response()->download($request['path'])->deleteFileAfterSend(true);
    }
    /**
     * download multiple files.
     */
    public function downloadMultiple(Request $request)
    {
        if (!file_exists(storage_path('app/downloads/'))) {
            mkdir(storage_path('app/downloads/'));
        }
        $files_requested = $request['files'];
        $files = File::whereIn('id', $files_requested)->get();
        $zip = new ZipArchive;
        $zipFileName = 'Attachment-' . 'files' . '.zip';
        if ($zip->open(storage_path('app/downloads/' . $zipFileName), ZipArchive::CREATE) === true) {
            foreach ($files as $file) {
                $filePath = storage_path($file->path);
                $filesToZip[] = $filePath;
            }
            foreach ($filesToZip as $file) {
                $zip->addFile($file, basename('/app' . $file));
            }
            $zip->close();
            DownloadStatus::dispatch($zipFileName, storage_path('app/downloads/' . $zipFileName), Auth::id());
            return "File are zipped";
        }
    }
    /**
     * Get all users files.
     */
    public function getFilesNames(Request $request)
    {
        $files = File::where('user_id', auth()->user()->id)->latest()->get();
        $names = [];
        foreach ($files as $key => $item) {
            $names[$item->id] = $item->name;
        }
        return $names;
    }

    /**
     * Logging File.
     */
    public function logFiles(Request $request)
    {
        FileLog::create([
            'name' => $request["name"],
            'description' => $request["description"],
            'type' => $request["type"],
            'user_id' => Auth::id(),
        ]);
        return;
    }
    /**
     * Logging File.
     */
    public function getLogFiles(Request $request)
    {
        return FileLog::where('user_id', Auth::id())->get();
    }
}
