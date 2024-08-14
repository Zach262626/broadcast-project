<?php

namespace App\Jobs;

use App\Events\ExcelExportEvent;
use App\Models\File;
use Box\Spout\Common\Entity\Row;
use Box\Spout\Common\Entity\Style\Border;
use Box\Spout\Common\Entity\Style\CellAlignment;
use Box\Spout\Common\Entity\Style\Color;
use Box\Spout\Writer\Common\Creator\Style\BorderBuilder;
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ExportFilesJob implements ShouldQueue
{
    use Queueable, Dispatchable;

    /**
     * Create a new job instance.
     */
    public function __construct(private $user)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->writer();
    }

    public function writer()
    {    
        $time = Carbon::now()->isoFormat('Y-M-D_hh_mm_ss');
        $styles = $this->styles();
        $writer = WriterEntityFactory::createXLSXWriter();
        Storage::disk('public')->put("temp/export/Files_Export_$time.xlsx", '');
        $filePath = storage_path("app/public/temp/export/Files_Export_$time.xlsx");//'public/storage/temp/export/Files_Export_'. $time . '.xlsx';
        $writer->openToFile($filePath);
        //Header Start
        $cells = [
            WriterEntityFactory::createCell('User'),
            WriterEntityFactory::createCell('Name'),
            WriterEntityFactory::createCell('Path'),
            WriterEntityFactory::createCell('Created At'),
            WriterEntityFactory::createCell('Updated At'),
        ];
        
        $singleRow = WriterEntityFactory::createRow($cells, $styles['header']);
        $writer->addRow($singleRow);
        //Header End
        $query = File::with(['user']);
        $total = File::with(['user'])->count();
        $count = 0;
        broadcast(new ExcelExportEvent($this->user->id, 0,"Files_Export_$time.xlsx"  ,$filePath, 'all'));
        $query->chunk(500, function ($files) use (&$writer, $styles, &$count, $total, $time, $filePath) {
            $count += 500;
            $multipleRows = [];
            foreach ($files as $file) {
                $cells = [
                    WriterEntityFactory::createCell($file->user_name, $styles['header']),
                    WriterEntityFactory::createCell($file->name, $styles['content']),
                    WriterEntityFactory::createCell($file->path, $styles['content']),
                    WriterEntityFactory::createCell($file->created_at->isoFormat('Y-M-D'), $styles['content']),
                    WriterEntityFactory::createCell($file->updated_at->isoFormat('Y-M-D'), $styles['content']),
                ];
                $multipleRows[] = WriterEntityFactory::createRow($cells);
            }
            $writer->addRows($multipleRows); 
            broadcast(new ExcelExportEvent($this->user->id, number_format((($count / $total) * 99.99),2),"Files_Export_$time.xlsx"  ,$filePath, 'all'));
        });
        
        // /** Shortcut: add a row from an array of values */
        // $values = ['Carl', 'is', 'great!'];
        // $rowFromValues = WriterEntityFactory::createRowFromArray($values);
        // $writer->addRow($rowFromValues);

        $writer->close();
        $this->notifyUser($time, $filePath);
        return true;
    }
    public function styles() {  
        $border = (new BorderBuilder())
            ->setBorderBottom(Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID)
            ->setBorderLeft(Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID)
            ->setBorderRight(Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID)
            ->setBorderTop(Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID)
            ->build(); 
        $header = (new StyleBuilder())
            ->setBackgroundColor(Color::rgb(220,220,220))
            ->setFontSize(15)
            ->setBorder($border)
            ->build();
        $content = (new StyleBuilder())
            ->setFontSize(13)
            ->setBorder($border)
            ->build();
        
        return [
            'border' => $border,
            'header' => $header,
            'content' => $content,
        ];
    }
    public function notifyUser($time, $filePath) {
        broadcast(new ExcelExportEvent($this->user->id, 100,"Files_Export_$time.xlsx"  ,$filePath, 'all'));
    }
}
