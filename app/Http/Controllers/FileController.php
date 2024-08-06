<?php
namespace App\Http\Controllers;
use App\Events\UploadStatus;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use ZipArchive;

class FileController extends Controller
{
    /**
     * retrieve files.
     */
    public function downloadIndex() {
        $files = File::where('user_id', auth()->user()->id)->get();
        return view('files.index', ['files' => $files]);
    }

    public function uploadIndex() {
        $files = File::where('user_id', auth()->user()->id)->get();
        return view('upload', ['files' => $files]);
    }
    /**
     * upload files.
     */
    public function upload(Request $request) {
        $status = 0;
        $count = 0;
        $total = count($request->file('files'));
        foreach ($request->file('files') as $file) {
            $count += 1;
            $status = (($count / $total) * 100);
            UploadStatus::dispatch($file->getClientOriginalName(), $status, Auth::id());
            sleep(3);
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
    /**
     * Get all users files.
     */
    public function getFiles(Request $request) {
        $files = File::where('user_id', auth()->user()->id)->latest()->get();
        $names = [];
        foreach ($files as $key => $item) {
            $names[$item->id] = $item->name;
        }
        return $names;
    }
    public function deleteFiles(Request $request) {
        //File::where('user_id', auth()->user()->id)->delete();
        find(auth()->user()->id);
        return response()->delete();
    }
}