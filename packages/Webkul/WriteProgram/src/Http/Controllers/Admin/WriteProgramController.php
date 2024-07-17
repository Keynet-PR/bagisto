<?php

declare(strict_types=1);

namespace Webkul\WriteProgram\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Webkul\Notification\Repositories\NotificationRepository;
use Webkul\WriteProgram\DataGrids\WriteProgramDataGrid;
use Webkul\WriteProgram\Models\WriteProgramFile;
use Webkul\WriteProgram\Repositories\WriteProgramRepository;

class WriteProgramController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function __construct(
        protected WriteProgramRepository $writableRepository,
        protected NotificationRepository $notificationRepository
    ) {}

    public function index()
    {
        if (request()->ajax()) {
            return datagrid(WriteProgramDataGrid::class)->process();
        }
        return view('wp::admin.index');
    }

    public function view($id)
    {
        $writable = $this->writableRepository
            ->with(['files', 'subscription'])
            ->findOrFail($id);
        return view('wp::admin.view', compact('writable'));
    }

    public function store($id)
    {
        $writable = $this->writableRepository->findOrFail($id);
        $fileUploadInfo = $this->writableRepository->upload();

        if ($writable && !empty($fileUploadInfo)) {

            $writable->files()->create([
                'write_program_id' => $id,
                'admin_id' => auth()->guard('admin')->id(),
                'url' => $fileUploadInfo['file_url'],
                'file_name' => $fileUploadInfo['file_name'],
                'file' => $fileUploadInfo['file'],
                'action' => 'edit',
                'file_size' => $fileUploadInfo['file_size'],
            ]);

            $writable->update([
                'status' => "file_completed"
            ]);

            $this->notificationRepository->where([
                'notifiable_id' => $id,
                'type' => 'writable'
            ])->update(['read' => 0]);

        }

        session()->flash('success', trans('wp::app.admin.view.file-send'));
        
        return redirect()->back();

    }

    public function downloadableFile($id)
    {
        $writabe = WriteProgramFile::query()->findOrFail($id);

        $fileName = substr($writabe->url, strrpos($writabe->url, '/') + 1);

        $tempImage = tempnam(sys_get_temp_dir(), $fileName);

        return response()->download($tempImage, $fileName);

    }
}
