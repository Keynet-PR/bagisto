<?php declare(strict_types=1); 

namespace Webkul\WriteProgram\Http\Controllers\Shop;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

class WriteProgramController extends Controller
{
    use DispatchesJobs, ValidatesRequests;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\Vi
     */
    public function index()
    {
        return view('writeprogram::shop.index');
    }

    public function store()
    {
        return view('writeprogram::shop.index');
    }
}
