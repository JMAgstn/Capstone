<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\User;
use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class TransactionsController extends Controller
{
    public function open(User $user, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'age' => ['required'],
            'gender' => ['required'],
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $validated = $validator->validated();
        $validated['type'] = 'Barangay Clearance';
        $validated['requesting_id'] = auth()->id();
        $log = array('action' => 'opened', 'by_userId' => auth()->id(), 'by_userName' => auth()->user()->name, 'receiver_type' => 'Barangay Clearance', 'receiver_name' => $validated['name']);
        Transactions::create($validated);
        Log::create($log);
        return redirect('/home')->with('status', 'Barangay Clearance request opened successfully!');
    }

    public function deny(Transactions $transaction)
    {
        $log = array('action' => 'denied', 'by_userId' => auth()->id(), 'by_userName' => auth()->user()->name, 'receiver_type' => 'Barangay Clearance', 'receiver_name' => $transaction['name']);
        $transaction->update([
            'issuing_id' => auth()->id(),
            'is_granted' => false,
        ]);
        Log::create($log);
        return back()->with('status', 'Transaction closed with denied status');
    }
}
