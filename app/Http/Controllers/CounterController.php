<?php

namespace App\Http\Controllers;

use App\Events\CounterStatus;
use App\Jobs\CounterJob;
use App\Models\Counter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        return 0;
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
        return Counter::where("user_id", Auth::id())->latest()->first();
    }
    /**
     * Delete Counter in database
     *
     * @param Request $request
     * @return array
     */
    public function deleteCounter(Request $request)
    {
        Counter::where("user_id", $request["user_id"])->delete();
        broadcast(new CounterStatus(0, 0, $request["user_id"]));
        return true;
    }
}
