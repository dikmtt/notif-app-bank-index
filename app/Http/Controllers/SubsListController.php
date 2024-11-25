<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscriber;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SubExport;

class SubsListController extends Controller
{
    public function view() {
        $subs = Subscriber::select('*')->get();
        return view('subslist', ['subs' => $subs]);
    }

    public function deletesub($sub_id) {
        $sub = Subscriber::select('*')->where('id', $sub_id)->delete();
        return redirect()->route('subslist');
    }

    public function addsubmail($sub_id) {
        $sub = Subscriber::select('*')->where('id', $sub_id)->get();
        return view('registersubemail', ['subscriber' => $sub]);
    }
    
    public function registeremail(Request $request) {
        $user = Subscriber::select('*')->where('subscriber_id', $request->sub_id)
                ->update(['email' => $request->email]);
        return redirect()->route('subslist');
    }

    public function filtersubs(Request $request) {
        $now = Carbon::now();
        if($request->filterby == "month") {
            $subs = Subscriber::select('*')->whereMonth('created_at', '=', $now->month)->get();
        } else if($request->filterby == "year") {
            $subs = Subscriber::select('*')->whereYear('created_at', '=', $now->year)->get();
        } else {
            $subs = Subscriber::select('*')->get();
        }
        return view('subslist', ['subs' => $subs]);
    }

    public function sortsubs(Request $request) {
        if($request->sort_what == "name") {
            $col = 'name';
        } else {
            $col = 'created_at';
        }
        if($request->sort_how == "asc") {
            $method = 'asc';
        } else {
            $method = 'desc';
        }
        $subs = Subscriber::select('*')->orderBy($col, $method)->get();
        //dd($subs);
        return view('subslist', ['subs' => $subs]);
    }

    public function exportexcel() {
        return Excel::download(new SubExport, 'subs.xlsx');
    }
}
