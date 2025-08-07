<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use Illuminate\Http\Request;

class AdminScheduleController extends Controller
{
    public function index()
    {
        $sales = Sales::where('status', 'schedule')->with('additional')
            ->orderBy('created_at', 'desc')->get();

        return view('admin.schedule.index', compact('sales'));
    }

    public function confirm($id)
    {
        $sales = Sales::find($id);

        $sales->status = 'settlement';
        $sales->save();

        return redirect('/admin/schedule');
    }

    public function delete($id)
    {
        $sales = Sales::find($id);

        $sales->status = 'paid';
        $sales->save();

        return redirect('/admin/schedule');
    }
}
