<?php declare(strict_types=1);

namespace Webkul\WriteProgram\Repositories;

use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Webkul\Core\Eloquent\Repository;
use Illuminate\Support\Facades\Storage;
use Webkul\WriteProgram\Models\WpSubscription;

class WriteProgramRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'Webkul\WriteProgram\Models\WriteProgram';
    }


    public function upload()
    {
        if (!request()->hasFile('attachment')) {
            return [];
        }
        $file = request()->file('attachment');
        $fileSize = $file->getSize();
        return [
            'file' => $path = request()->file('attachment')->store('writable-file/' . request()->id),
            'file_name' => $file->getClientOriginalName(),
            'file_url' => Storage::url($path),
            'file_size' => ($fileSize / 1024)
        ];
    }

    public function subscribed_plan($order_id = null)
    {
        try {
            
             $plan = DB::table('orders AS o')
            ->join('order_items AS i', function($join) {
                $join->on('i.order_id', '=', 'o.id')->whereNotNull('i.parent_id');
            })
            ->join('wp_plans AS p', DB::raw('LOWER(i.sku)'), '=', DB::raw('LOWER(p.referent_code)'))
            ->where('i.order_id', $order_id)
            ->select(
                'p.id',
                'i.order_id',
                'o.status',
                'i.sku',
                'p.name',
                'o.created_at',
                'o.customer_id',
                DB::raw("
                    CASE
                        WHEN LOWER(p.name) = 'one-time' THEN DATE_ADD(o.created_at, INTERVAL 1 DAY)
                        WHEN LOWER(p.name) = 'monthly' THEN DATE_ADD(o.created_at, INTERVAL 1 MONTH)
                        WHEN LOWER(p.name) = 'yearly' THEN DATE_ADD(o.created_at, INTERVAL 1 YEAR)
                        ELSE o.created_at
                    END AS end_at
                ")
            )
            ->first();
            
          if($plan){
             WpSubscription::query()->create(
                [
                    'start_at' => $plan->created_at,
                    'end_at' => $plan->end_at,
                    'wp_plan_id' => $plan->id,
                    'customer_id' => $plan->customer_id,
                    'subscribed_as' => true
                ]
            );  
          }
            
        } catch (\Throwable $th) {
            session()->flash('error', $th->getMessage());
            return redirect()->back();
        }

    }
}
