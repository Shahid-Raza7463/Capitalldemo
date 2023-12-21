<?php

namespace App\Exports;


use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Events\AfterSheet;
use DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
class OutstandingExport implements FromCollection ,WithHeadings , WithEvents ,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $report_id;
    public function __construct($report_id)
{
    //dd($report_id);
    $this->request = $report_id;
  //  dd($this->request);
}

    public function headings():array{
        return[
            
            'Client Name',
            'Bill No',
            'Invoice Date',
            'Amount',
           'Days',
        ];
    } 
    public function collection()
    { 
          
        // dd($this->request);
        $result = DB::table('outstandings')
        ->leftjoin('teammembers','teammembers.id','outstandings.Partner')
        ->where('Partner',$this->request)
        ->select('outstandings.CLIENT_NAME','outstandings.BILL_NO','outstandings.DATE','outstandings.AMT','outstandings.Status as days')->get();
    //   dd($result);
        foreach($result as $res)
        {
            $current=Carbon::now();    
            $formatted_dt1=Carbon::parse($current);
                                  $pendingdays=$formatted_dt1->diffInDays($res->DATE);
            $res->DATE = date('F d,Y', strtotime($res->DATE));
            $res->days =  $pendingdays;
      }
      
       return $result;
       
    }
    public function registerEvents(): array
    {
        // $export = [];
        // array_push($export, [
        //     'Bill No' => '',
        //     'Client Name'=>'',
        //     'Amount' =>'',
        //     'Invoice Date' => '',
        //     'Status' => ''
        // ]);
        return [
            
            AfterSheet::class    => function(AfterSheet $event) {
                $event->sheet->getDelegate()->getStyle('A1:E1')
                ->getFont()
                ->setBold(true);
                // $event->sheet->getDelegate()->getRowDimension('1')->setRowHeight(20);
                // $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(40);
                // $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(40);
                // $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(40);
                // $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(40);
                // $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(40);
  //  $event->sheet->setCellValue('B'. ($event->sheet->getHighestRow()+1),'Total:', ''.''.')');
    $event->sheet->setCellValue('D'. ($event->sheet->getHighestRow()+1), '=SUM(D2:D'.$event->sheet->getHighestRow().')');
     // $event->sheet->setCellValue(array_push($export,[' ','Total:', '=SUM(C2:C'.$event->sheet->getHighestRow().')']));
    },
        ];
    }
    
    
}
