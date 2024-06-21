<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Exception;

use App\Exports\OrdersExport;

class MonthlyReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:monthlyreport';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Monthly Report';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $dateNow = Carbon::now()->format('YmdHis');
        Excel::store(new OrdersExport, $dateNow.'_orders.xlsx');
        $file = Storage::path($dateNow.'_orders.xlsx');

        // Draft email prerequisites
        $email = env('MAIL_DEV_ADDRESS');
        $emailSubject = 'FHC Monthly Report - '.Carbon::now()->format('d F Y');
        $emailData = array(
            'subject'       => $emailSubject,
            'from'          => array(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME')),
            'to'            => array($email),
            'title'         => $emailSubject,
        );

        // Ready to send
        try {
            $xMail = Mail::send('email/template-2', ['data' => $emailData], function ($message) use ($emailData, $file) {
                $message->subject($emailData['subject']);
                $message->from($emailData['from'][0],$emailData['from'][1]);
                foreach($emailData['to'] as $val){
                    $message->to($val);
                }
                $message->attach($file, ['mime' => 'application/vnd.ms-excel']);
                $message->bcc(env('MAIL_BUSINESS_PORTAL_DEV_ADDRESS'));
            });
        } catch (Exception $e) {
            // Do nothing if throw error
            dump($e->getMessage());
        }

        return 0;
    }
}
