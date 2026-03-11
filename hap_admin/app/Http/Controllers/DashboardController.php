<?php

namespace App\Http\Controllers;

use App\Services\ReportApi;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        protected ReportApi $reports
    ) {}

    public function index(): View
    {
        $from = now()->startOfMonth()->toDateString();
        $to = now()->toDateString();

        $salesSummary = $this->reports->salesSummary([
            'from_date' => $from,
            'to_date' => $to,
        ]);

        $orderStatus = $this->reports->orderStatus([
            'from_date' => $from,
            'to_date' => $to,
        ]);

        return view('dashboard.index', [
            'sales_summary' => $salesSummary,
            'order_status' => $orderStatus,
        ]);
    }
}
