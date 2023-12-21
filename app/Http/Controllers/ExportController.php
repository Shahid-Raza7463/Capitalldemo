<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DataTableExport;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;
use Swift_Attachment;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExportController extends Controller
{
    public function export()
    {
        	 
			$excelFile1 = 'excel_file_1.xlsx';
			$export1 = new DataTableExport('Capitall India Pvt. Ltd.');
			Excel::store($export1, $excelFile1, 'public');
			$excelFilePath1 = storage_path('app/public/' . $excelFile1);
			$spreadsheet1 = IOFactory::load($excelFilePath1);
			$rowCount1 = $spreadsheet1->getActiveSheet()->getHighestRow() - 1;


			$excelFile2 = 'excel_file_2.xlsx';
			$export2 = new DataTableExport('GVRIKSH');
			Excel::store($export2, $excelFile2, 'public');
			$excelFilePath2 = storage_path('app/public/' . $excelFile2);
			$spreadsheet2 = IOFactory::load($excelFilePath2);
			$rowCount2 = $spreadsheet2->getActiveSheet()->getHighestRow() - 1;

			$excelFile3 = 'excel_file_3.xlsx';
			$export3 = new DataTableExport('K G Somani & Co LLP');
			Excel::store($export3, $excelFile3, 'public');
			$excelFilePath3 = storage_path('app/public/' . $excelFile3);
			$spreadsheet3 = IOFactory::load($excelFilePath3);
			$rowCount3 = $spreadsheet3->getActiveSheet()->getHighestRow() - 1;

			//dd($rowCount3 );

			$excelFile4 = 'excel_file_4.xlsx';
			$export4 = new DataTableExport('KGS Advisors LLP');
			Excel::store($export4, $excelFile4, 'public');
			$excelFilePath4 = storage_path('app/public/' . $excelFile4);
			$spreadsheet4 = IOFactory::load($excelFilePath4);
			$rowCount4 = $spreadsheet4->getActiveSheet()->getHighestRow() - 1;

        // Prepare email data for each entity
        $body = '
    <html>
    <body>
        <p>Dear Team,</p>
        <p>Please find the attached file containing the NEFT transaction details for processing.</p>
        <p>Kindly proceed with the NEFT transfer as per the provided information.</p>
    </body>
    </html>
';

$emailData1 = [
    'subject' => 'Request To Process NEFT For Salary Sheet For the Month of May || Capitall India Pvt. Ltd.',
    'body' => $body,
    'attachmentPath' => storage_path('app/public/' . $excelFile1),
    'recipient' => 'accounts@kgsomani.com' // Replace with the actual recipient email address
];

$emailData2 = [
    'subject' => 'Request To Process NEFT For Salary Sheet For the Month of May || GVRIKSH',
    'body' => $body,
    'attachmentPath' => storage_path('app/public/' . $excelFile2),
    'recipient' => 'accounts@kgsomani.com' // Replace with the actual recipient email address
];

$emailData3 = [
    'subject' => 'Request To Process NEFT For Salary Sheet For the Month of May || K G Somani & Co LLP',
    'body' => $body,
    'attachmentPath' => storage_path('app/public/' . $excelFile3),
    'recipient' => 'aanchal.madaan@icicibank.com' // Replace with the actual recipient email address
];

$emailData4 = [
    'subject' => 'Request To Process NEFT For Salary Sheet For the Month of May|| KGS Advisors LLP',
    'body' => $body,
    'attachmentPath' => storage_path('app/public/' . $excelFile4),
    'recipient' => 'aanchal.madaan@icicibank.com' // Replace with the actual recipient email address
];


// ...

		if($rowCount1!=0)
{
Mail::send([], [], function ($message) use ($emailData1) {
    $message->to($emailData1['recipient'])
        ->cc('priyankasharma@kgsomani.com')
        ->subject($emailData1['subject'])
        ->setBody($emailData1['body'], 'text/html')
        ->attach(Swift_Attachment::fromPath($emailData1['attachmentPath']));
});
		}
			if($rowCount2!=0)
{
Mail::send([], [], function ($message) use ($emailData2) {
    $message->to($emailData2['recipient'])
       	->cc('priyankasharma@kgsomani.com')
        ->subject($emailData2['subject'])
        ->setBody($emailData2['body'], 'text/html')
        ->attach(Swift_Attachment::fromPath($emailData2['attachmentPath']));
});
		}
		if($rowCount3!=0)
{
Mail::send([], [], function ($message) use ($emailData3) {
    $message->to($emailData3['recipient'])
        ->cc('priyankasharma@kgsomani.com')
        ->subject($emailData3['subject'])
        ->setBody($emailData3['body'], 'text/html')
        ->attach(Swift_Attachment::fromPath($emailData3['attachmentPath']));
});
		}
		if($rowCount4!=0)
{
Mail::send([], [], function ($message) use ($emailData4) {
    $message->to($emailData4['recipient'])
     	 ->cc('priyankasharma@kgsomani.com')
        ->subject($emailData4['subject'])
        ->setBody($emailData4['body'], 'text/html')
        ->attach(Swift_Attachment::fromPath($emailData4['attachmentPath']));
});


		}
               // Delete the generated Excel files
               unlink(storage_path('app/public/' . $excelFile1));
               unlink(storage_path('app/public/' . $excelFile2));
               unlink(storage_path('app/public/' . $excelFile3));
               unlink(storage_path('app/public/' . $excelFile4));
		
				$bankmailbody = '
    <html>
    <body>
       <p>Dear Sir/Madam,</p>
    <p>Salary Sheet for the month of May has been sent to bank sucessfully.</p>
    <p>Thank you for your attention!</p>
    
    <p>Best regards,</p>
    <p>K G Somani & Co LLP</p>
    </body>
    </html>
';

$bankEmailData = [
    'subject' => 'Salary Sheet Sent to Bank',
    'body' => $bankmailbody,
    'recipient' => 'sanjiv@kgsomani.com' // Replace with the actual bank email address
];

Mail::send([], [], function ($message) use ($bankEmailData) {
    $message->to($bankEmailData['recipient'])
        
        ->cc('priyankasharma@kgsomani.com')
        ->cc('accounts@kgsomani.com')
        ->subject($bankEmailData['subject'])
        ->setBody($bankEmailData['body'], 'text/html');
});

       
		DB::table('employeepayrolls')
            ->where('level_three', 1)
            ->where('month','May')
            ->update(['send_to_bank' => 1]);


       			$output = array('msg' => 'Salary sheet Shared with Bank Sucessfully!!');
               return back()->with('success', $output);
              
            //   return 'Emails sent with Excel attachments.';
           }
       }
       