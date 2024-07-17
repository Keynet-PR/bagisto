<?php

namespace Webkul\DownloadLinks\Repository;
use Illuminate\Support\Facades\Storage;
use Webkul\Core\Eloquent\Repository;

class DownloadCustomerLinkRepository extends Repository
{
    /**
    * Specify the Model class name
    *
    * @return string
    */
    function model(): string
    {
        return 'Webkul\DownloadLinks\Contracts\DownloadCustomerLink';
    }

    public function upload()
    {
        if (! request()->hasFile('attachment')) {
            return [];
        }

        return [
            'file'      => $path = request()->file('attachment')->store('download-purchased-link/'. request()->id),
            'file_name' => request()->file('attachment')->getClientOriginalName(),
            'file_url'  => Storage::url($path),
        ];
    }
}
