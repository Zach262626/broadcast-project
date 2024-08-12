<?php

namespace App\Http\Controllers;

use App\Events\CounterStatus;
use App\Jobs\CounterJob;
use App\Models\Counter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Bus;

class CounterController extends Controller
{
    /**
     * Count to max number
     * 
     * @param Request $request
     * @return array
     */
    public function startCounter(Request $request)
    {
        $max = 10;
        CounterJob::dispatch(1, $max, Auth::id());
        return back();
    }
    /**
     * Get all the number counted
     * 
     * @param Request $request
     * @return array
     */
    public function getCounter(Request $request)
    {
        return Counter::where(Auth::id())->get();
    }
    /**
     * Get latest number counted
     * 
     * @param Request $request
     * @return array
     */
    public function getLatestCounter(Request $request)
    {
        return Counter::where(Auth::id())->latest()->first();
    }
}
