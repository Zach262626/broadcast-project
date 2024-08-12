<?php

namespace App\Jobs;

use App\Events\CounterStatus;
use App\Models\Counter;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class CounterJob implements ShouldQueue
{
    use Queueable, Dispatchable;
    private $counter;
    /**
     * Create a new job instance.
     */
    public function __construct(private $min, private $max, private $user_id)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $status = 0;
        for($i = $this->min; $i <= $this->max; ++$i) {
            $status = (integer) (($i/$this->max) * 100);
            if ($i == $this->min) {
                Counter::updateOrInsert(
                    ['user_id' => $this->user_id],
                    fn ($exists) => $exists ? [
                        'status' => $status,
                        'count' => 0,
                    ] : [
                        'status' => $status,
                        'count' => 0,
                    ]);
                $this->counter = Counter::where("user_id", $this->user_id)->first();
            }else {
                $this->counter->update([
                    'count' => $i,
                    'status' => $status,
                ]);
            }
            broadcast(new CounterStatus($i,$status, $this->user_id));
            sleep(1);
        }
    }
}
