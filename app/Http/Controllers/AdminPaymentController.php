<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Sales;
use App\Models\PaymentMethods;
use Illuminate\Http\Request;
use Validator;

class AdminPaymentController extends Controller
{
    public function index()
    {
        $sales = Sales::where('status', 'paid')->with(['additional', 'course'])
            ->orderBy('created_at', 'desc')->get();
        foreach ($sales as $sale) {
            $sale->isCourse = $sale->course->isNotEmpty();
        }
        return view('admin.payment.index', compact('sales'));
    }

    public function confirm(Request $request, $id)
    {

         try {
            // Validate the request
            $validator = Validator::make($request->all(), [
                'start_date' => 'required|date'
            ], [
                'start_date.required' => 'Start date is required',
                'start_date.date' => 'Start date must be a valid date',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first()
                ], 422);
            }

            // Find the sales record
            $sales = Sales::find($id);
            
            if (!$sales) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sales record not found'
                ], 404);
            }

            // Update sales with schedule dates and status
            $sales->status = 'schedule';
            $sales->start_date = $request->start_date;
            $sales->save();

            // Return success response for AJAX
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Payment confirmed and schedule set successfully',
                    'data' => [
                        'sales_id' => $sales->id,
                        'sales_no' => $sales->sales_no,
                        'status' => $sales->status,
                        'start_date' => $sales->start_date,
                    ]
                ]);
            }

            // Return redirect for non-AJAX requests
            return redirect('/admin/confirm-payment')
                ->with('success', 'Payment confirmed and schedule set successfully');

        } catch (\Exception $e) {
            \Log::error('Error confirming payment with schedule', [
                'sales_id' => $id,
                'error' => $e->getMessage()
            ]);

            if ($request->expectsJson()) {
                
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 500);
            }

            return redirect('/admin/confirm-payment')
                ->with('error', 'An error occurred while confirming the payment. Please try again.');
        }
    }

    public function course($id)
    {
        $sales = Sales::find($id);

        $sales->status = 'settlement';
        $sales->save();

        return redirect('/admin/confirm-payment')
            ->with('success', 'Course confirmed successfully');
    }

    public function deleteAll()
    {
        $deleteAll = Sales::where('status', 'pending')->delete();

        if ($deleteAll == 1) {
            $success = true;
            $message = "Sales deleted successfully";
        } else {
            $success = false;
            $message = "Sales not found";
        }

        //  Return response
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }
}
