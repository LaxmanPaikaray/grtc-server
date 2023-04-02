<?php

namespace App\Http\Controllers;

use App\Http\Resources\MediaResource;
use App\Models\MediaFile;
use App\Models\MediaFiles;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class MediaController extends Controller
{

    public function store(Request $req)
    {
        $req->validate([
            'file' => 'required|mimes:csv,txt,xlx,xls,pdf|max:2048'
        ]);
        $fileModel = new MediaFile;
        if ($req->file()) {
            $fileName = time() . '_' . $req->file->getClientOriginalName();
            $filePath = $req->file('file')->storeAs('media/' . date('mY'), $fileName);
            $fileModel->name = time() . '_' . $req->file->getClientOriginalName();
            $fileModel->file_path = '/storage/media/' . $filePath;
            $fileModel->mime_type = $req->file('file')->getMimeType();
            $fileModel->save();
            return new MediaResource($fileModel);
        }
    }

    public function bulk_store(Request $req)
    {
        $req->validate([
            'files' => 'required',
            'files.*' => 'required|mimes:pdf,xlx,csv|max:2048',
        ]);

        $files = [];
        if ($req->file('files')) {
            foreach ($req->file('files') as $key => $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('media/' . date('mY'), $fileName);
                $files[$key]['name'] = $fileName;
                $files[$key]['file_path'] = '/storage/media/' . $filePath;
                $files[$key]['mime_type'] = $file->getMimeType();;
            }
        }

        $bulk = collect($files)->map(function ($arr, $key) {
            $timestamp = Carbon::now('utc')->toDateTimeString();
            $arr['id'] = Str::uuid()->toString();
            $arr['slug'] = SlugService::createSlug(MediaFile::class, 'slug', $arr['name']);
            $arr['created_at'] = $timestamp;
            $arr['updated_at'] = $timestamp;
            return $arr;
        });
        MediaFile::insert($bulk->toArray());
        return $bulk;
    }
}
