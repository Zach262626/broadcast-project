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
     * Display a list of available downloads
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function downloadIndex(Request $request)
    {
        $files = File::where('user_id', auth()->user()->id)->get();
        return view('files.index', ['files' => $files]);
    }
    /**
     * Display a upload page
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function uploadIndex()
    {
        $files = File::where('user_id', auth()->user()->id)->get();
        return view('upload', ['files' => $files]);
    }
    /**
     * Upload a list of file to the local storage
     *
     * @param Request $request
     * @return void
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
            sleep(1);
        }
        sleep(2);
        return back();
    }
    /**
     * Download file from path requested
     *
     * @param Request $request
     * @return void
     */
    public function download(Request $request)
    {
        return response()->download($request['path'])->deleteFileAfterSend(true);
    }
    /**
     * Zip a list of files and stored in local storage
     *
     * @param Request $request
     * @return string
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
        $count = 0;
        $status = 0;
        DownloadStatus::dispatch('start', $zipFileName, 0, Auth::id());//Broadcast the start
        sleep(1);
        if ($zip->open(storage_path('app/downloads/' . $zipFileName), ZipArchive::CREATE) === true) {
            foreach ($files as $file) {
                $filePath = storage_path($file->path);
                $filesToZip[$file->name] = $filePath;
            }
            foreach ($filesToZip as $name => $file) {
                $zip->addFile($file, basename('/app' . $file));
                $count += 1;
                $status = (integer) (($count / count($files)) * 100);
                if ($status == 100) {
                    $status = 99;
                }
                DownloadStatus::dispatch($name, basename('/app' . $file), $status, Auth::id());//Broadcast the progress
                sleep(1);
            }
            $zip->close();
            sleep(1);
            DownloadStatus::dispatch($zipFileName, storage_path('app/downloads/' . $zipFileName), 100, Auth::id());//Broadcast the end
            return "File are zipped";
        }
    }
    /**
     * Gey the names of all the available files
     *
     * @param Request $request
     * @return array $name
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
     * 
     * @param Request $request
     * @return void
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
     * 
     * @param Request $request
     * @return array
     */
    public function getLogFiles(Request $request)
    {
        return FileLog::where('user_id', Auth::id())->latest()->get();
    }
}
