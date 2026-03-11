<?php

namespace App\Http\Controllers;

use App\Services\ReportApi;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function __construct(
        protected ReportApi $reports
    ) {}

    public function salesSummary(Request $request): View
    {
        $from = $request->input('from_date', now()->startOfMonth()->toDateString());
        $to = $request->input('to_date', now()->toDateString());
        $data = $this->reports->salesSummary([
            'from_date' => $from,
            'to_date' => $to,
        ]);

        return view('reports.sales-summary', [
            'data' => $data,
            'from_date' => $from,
            'to_date' => $to,
        ]);
    }

    public function orderStatus(Request $request): View
    {
        $from = $request->input('from_date', now()->startOfMonth()->toDateString());
        $to = $request->input('to_date', now()->toDateString());
        $data = $this->reports->orderStatus([
            'from_date' => $from,
            'to_date' => $to,
        ]);

        return view('reports.order-status', [
            'data' => $data,
            'from_date' => $from,
            'to_date' => $to,
        ]);
    }

    public function inventorySummary(): View
    {
        $result = $this->reports->inventorySummary();

        return view('reports.inventory-summary', [
            'data' => $result['data'],
        ]);
    }
}
