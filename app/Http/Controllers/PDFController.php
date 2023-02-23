<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\User;
use App\Models\Transactions;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\PDF;

class PDFController extends Controller
{
    public function generatePDF(Transactions $transaction)
    {
        $transaction->update([
            'issuing_id' => auth()->id(),
            'is_granted' => true,
        ]);
        $data = [
            'transaction' => $transaction
        ];
        // dd($transaction);
        $log = array('action' => 'granted', 'by_userId' => auth()->id(), 'by_userName' => auth()->user()->name, 'receiver_type' => 'Barangay Clearance', 'receiver_name' => $transaction['name']);
        $pdf = PDF::loadView('myPDF', $data);
        Log::create($log);
        return $pdf->download('itsolutionstuff.pdf');
        // return $pdf->setPaper('a4')->stream();
    }
}
