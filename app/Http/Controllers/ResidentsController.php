<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Log;
use App\Models\User;
use App\Models\Residents;
use App\Models\Households;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class ResidentsController extends Controller
{
    public function index(Request $request)
    {
        return view('residents.residents', ['residents' => Residents::sortable(['updated_at' => 'desc'])->filter(request(['search']))->paginate(10)]);
    }

    public function seniors()
    {
        $seniorAge = Carbon::today()->subYears(65)->startOfDay();
        return view('residents.residents', ['residents' => Residents::where('b_date', '<=', $seniorAge)->paginate(10)]);
    }

    public function minors()
    {
        $minorAge = Carbon::today()->subYears(18)->startOfDay();
        return view('residents.residents', ['residents' => Residents::where('b_date', '>', $minorAge)->paginate(10)]);
    }

    public function labor()
    {
        $maxAge = 64;
        $minAge = 15;
        $minDate = Carbon::today()->subYears($maxAge);
        $maxDate = Carbon::today()->subYears($minAge)->endOfDay();
        return view('residents.residents', ['residents' => Residents::whereBetween('b_date', [$minDate, $maxDate])->paginate(10)]);
    }

    public function unemployed()
    {
        $maxAge = 64;
        $minAge = 15;
        $minDate = Carbon::today()->subYears($maxAge);
        $maxDate = Carbon::today()->subYears($minAge)->endOfDay();
        return view('residents.residents', ['residents' => Residents::whereBetween('b_date', [$minDate, $maxDate])->where('employment_status', 'Unemployed')->paginate(10)]);
    }

    public function women()
    {
        $minorAge = Carbon::today()->subYears(18)->startOfDay();
        return view('residents.residents', ['residents' => Residents::where('b_date', '<', $minorAge)->where('gender', 'Female')->paginate(10)]);
    }

    public function farmers()
    {
        return view('residents.residents', ['residents' => Residents::where('occupation', 'Farmer')->paginate(10)]);
    }

    public function ofw()
    {
        return view('residents.residents', ['residents' => Residents::where('occupation', 'OFW')->paginate(10)]);
    }

    public function businessman()
    {
        return view('residents.residents', ['residents' => Residents::where('occupation', 'Business Owner')->paginate(10)]);
    }

    public function philhealth()
    {
        return view('residents.residents', ['residents' => Residents::where('has_philhealth', true)->paginate(10)]);
    }

    public function create()
    {
        return view('residents.createresident');
    }

    public function store(Request $request)
    {
        // dd($request->file('avatar'));
        $validator = Validator::make($request->all(), [
            'last_name' => ['required'],
            'first_name' => ['required'],
            'middle_name' => ['required'],
            'suffix' => ['nullable'],
            'b_date' => ['required'],
            'b_place' => ['required'],
            'gender' => ['required'],
            'religion' => ['required'],
            'nationality' => ['required'],
            'citizenship' => ['required'],
            'civil_status' => ['required'],
            'blood_type' => ['required'],
            'has_philhealth' => ['required'],
            'occupation' => ['required'],
            'employment_status' => ['required'],
            'monthly_income' => ['required'],
            'educational_attainment' => ['required'],
            'mailing_address' => ['required'],
            'contact_email' => ['required', 'email'],
            'contact_phone' => ['required', 'min:7'],
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $validated = $validator->validated();
        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }
        $id = DB::select("SHOW TABLE STATUS LIKE 'residents'");
        $next_id = $id[0]->Auto_increment;
        // dd($next_id);
        $log = array('action' => 'created', 'by_userId' => auth()->id(), 'by_userName' => auth()->user()->name, 'receiver_type' => 'household', 'receiver_name' => $validated['last_name']);
        Residents::create($validated);
        Log::create($log);

        return redirect('/residents/' . $next_id . '/addhousehold');
    }

    public function addhousehold(Residents $resident, Request $request)
    {
        // dd($resident);
        $data = ['id' => 1, 'fullname' => 'Household Head'];
        return view('residents.createaddhousehold', ['resident' => $resident, 'households' => Households::latest()->filter(request(['search']))->paginate(50), 'data' => $data]);
    }

    public function addhouseholdsearch(Request $request)
    {
        $resident = Residents::latest()->first();
        $data = ['id' => 1, 'fullname' => 'Household Head'];
        return view('residents.createaddhousehold', ['resident' => $resident, 'households' => Households::latest()->filter(request(['search']))->paginate(50), 'data' => $data]);
    }

    public function storehousehold(Request $request, Residents $resident)
    {
        // dd($resident);

        $validator = Validator::make($request->all(), [
            'household_id' => ['required'],
            'relation_to_head' => ['required'],
        ]);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $validated = $validator->validated();
        $resident->update($validated);
        return redirect('/residents/' . $resident->id . '/adduser');
    }

    public function adduser(Residents $resident)
    {
        // dd($resident);
        $data = ['id' => 1, 'fullname' => 'Username'];
        return view('residents.createadduser', ['resident' => $resident, 'users' => User::latest()->filter(request(['search']))->paginate(50), 'data' => $data]);
    }

    public function addusersearch(Request $request)
    {
        $resident = Residents::latest()->first();
        $data = ['id' => 1, 'fullname' => 'Household Head'];
        return view('residents.createadduser', ['resident' => $resident, 'users' => User::latest()->filter(request(['search']))->paginate(50), 'data' => $data]);
    }

    public function storeuser(Request $request, Residents $resident)
    {
        // dd($resident);

        $validator = Validator::make($request->all(), [
            'user_id' => ['required'],
        ]);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $validated = $validator->validated();
        $resident->update($validated);
        return redirect('/residents')->with('status', 'Resident successfully added');
    }

    public function edit(Residents $resident)
    {
        return view('residents.editresident', ['resident' => $resident]);
    }

    public function update(Request $request, Residents $resident)
    {
        // dd($request->file('avatar'));
        $validator = Validator::make($request->all(), [
            'last_name' => ['required'],
            'first_name' => ['required'],
            'middle_name' => ['required'],
            'suffix' => ['nullable'],
            'b_date' => ['required'],
            'b_place' => ['required'],
            'gender' => ['required'],
            'religion' => ['required'],
            'nationality' => ['required'],
            'citizenship' => ['required'],
            'civil_status' => ['required'],
            'blood_type' => ['required'],
            'has_philhealth' => ['required'],
            'occupation' => ['required'],
            'employment_status' => ['required'],
            'monthly_income' => ['required'],
            'educational_attainment' => ['required'],
            'mailing_address' => ['required'],
            'contact_email' => ['required', 'email'],
            'contact_phone' => ['required', 'min:7'],
            'household_id' => ['required'],
            'relation_to_head' => ['required'],
            'user_id' => ['nullable']
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $validated = $validator->validated();
        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }
        $log = array('action' => 'updated', 'by_userId' => auth()->id(), 'by_userName' => auth()->user()->name, 'receiver_type' => 'household', 'receiver_name' => $resident->last_name);
        $resident->update($validated);
        Log::create($log);

        return redirect('/residents')->with('status', 'Resident Information updated successfully!');
    }

    public function destroy(Residents $resident)
    {
        $log = array('action' => 'deleted', 'by_userId' => auth()->id(), 'by_userName' => auth()->user()->name, 'receiver_type' => 'user profile', 'receiver_name' => $resident->last_name);
        // dd($log);
        $resident->delete();
        Log::create($log);
        return back()->with('status', 'User deleted successfully');
    }

    public function createhelper(Residents $resident)
    {

        // dd($resident);
        $data = array('id' => $resident->id, 'fullname' => ($resident->last_name . ', ' . $resident->first_name));
        return view('officials.createofficial', array('residents' => Residents::latest()->filter(request(['search']))->paginate(50), 'data' => $data));
    }

    public function export()
    {
        $residents = Residents::all();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'Avatar');
        $sheet->setCellValue('C1', 'Last Name');
        $sheet->setCellValue('D1', 'First Name');
        $sheet->setCellValue('E1', 'Middle Name');
        $sheet->setCellValue('F1', 'Suffix');
        $sheet->setCellValue('G1', 'Birthday');
        $sheet->setCellValue('H1', 'Birthplace');
        $sheet->setCellValue('I1', 'Gender');
        $sheet->setCellValue('J1', 'Religion');
        $sheet->setCellValue('K1', 'Nationality');
        $sheet->setCellValue('L1', 'Citizenship');
        $sheet->setCellValue('M1', 'Civil Status');
        $sheet->setCellValue('N1', 'Blood Type');
        $sheet->setCellValue('O1', 'Has Philhealth?');
        $sheet->setCellValue('P1', 'Occupation');
        $sheet->setCellValue('Q1', 'Employment Status');
        $sheet->setCellValue('R1', 'Monthly Income');
        $sheet->setCellValue('S1', 'Educational Attainment');
        $sheet->setCellValue('T1', 'Mailing Address');
        $sheet->setCellValue('U1', 'Household Id');
        $sheet->setCellValue('V1', 'Relation To Household Head');
        $sheet->setCellValue('W1', 'User Id');
        $sheet->setCellValue('X1', 'Email Address');
        $sheet->setCellValue('Y1', 'Phone Number');
        $sheet->setCellValue('Z1', 'Created At');
        $sheet->setCellValue('AA1', 'Updated At');
        $rows = 2;
        foreach ($residents as $resident) {
            $sheet->setCellValue('A' . $rows, $resident['id']);
            $sheet->setCellValue('B' . $rows, $resident['avatar']);
            $sheet->setCellValue('C' . $rows, $resident['last_name']);
            $sheet->setCellValue('D' . $rows, $resident['first_name']);
            $sheet->setCellValue('E' . $rows, $resident['middle_name']);
            $sheet->setCellValue('F' . $rows, $resident['suffix']);
            $sheet->setCellValue('G' . $rows, $resident['b_date']);
            $sheet->setCellValue('H' . $rows, $resident['b_place']);
            $sheet->setCellValue('I' . $rows, $resident['gender']);
            $sheet->setCellValue('J' . $rows, $resident['religion']);
            $sheet->setCellValue('K' . $rows, $resident['nationality']);
            $sheet->setCellValue('L' . $rows, $resident['citizenship']);
            $sheet->setCellValue('M' . $rows, $resident['civil_status']);
            $sheet->setCellValue('N' . $rows, $resident['blood_type']);
            $sheet->setCellValue('O' . $rows, $resident['has_philhealth']);
            $sheet->setCellValue('P' . $rows, $resident['occupation']);
            $sheet->setCellValue('Q' . $rows, $resident['employment_status']);
            $sheet->setCellValue('R' . $rows, $resident['monthly_income']);
            $sheet->setCellValue('S' . $rows, $resident['educational_attainment']);
            $sheet->setCellValue('T' . $rows, $resident['mailing_address']);
            $sheet->setCellValue('U' . $rows, $resident['household_id']);
            $sheet->setCellValue('V' . $rows, $resident['relation_to_head']);
            $sheet->setCellValue('W' . $rows, $resident['user_id']);
            $sheet->setCellValue('X' . $rows, $resident['contact_email']);
            $sheet->setCellValue('Y' . $rows, $resident['contact_phone']);
            $sheet->setCellValue('Z' . $rows, $resident['created_at']);
            $sheet->setCellValue('AA' . $rows, $resident['created_at']);
            $rows++;
        }
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="residents.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }
}
