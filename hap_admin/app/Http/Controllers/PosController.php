<?php

namespace App\Http\Controllers;

use App\Services\HapApiService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PosController extends Controller
{
    public function __construct(
        protected HapApiService $api
    ) {}

    public function eodSummary(Request $request): View
    {
        $date = $request->input('date', now()->toDateString());
        try {
            $data = $this->api->get('pos/eod-summary', ['date' => $date]);
        } catch (\Throwable) {
            $data = [];
        }
        return view('pos.eod-summary', ['data' => $data, 'date' => $date]);
    }
}
