<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyFileShareRequest;
use App\Http\Requests\StoreFileShareRequest;
use App\Http\Requests\UpdateFileShareRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use Symfony\Component\HttpFoundation\Response;
use App\FileShare;
use App\User;
use Gate;

class FileShareController extends Controller
{
    use MediaUploadingTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('file_share_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $file_shares = FileShare::all();
        return view('admin.file_shares.index', compact('file_shares'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('file_share_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.file_shares.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFileShareRequest $request)
    {
        $file_shares = FileShare::create($request->all());
        foreach ($request->input('file_shares_images', []) as $file) {
            $file_shares->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('file_shares_images');
        }

        return redirect()->route('admin.file_shares.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(FileShare $file_share)
    {
        abort_if(Gate::denies('file_share_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('admin.file_shares.show', compact('file_share'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(FileShare $file_share)
    {
        abort_if(Gate::denies('file_share_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        return view('admin.file_shares.edit', compact('users','file_share'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFileShareRequest $request, FileShare $file_share)
    {
        $file_share->update($request->all());
        if (count($file_share->file_shares_images) > 0) {
            foreach ($file_share->file_shares_images as $media) {
                if (!in_array($media->file_name, $request->input('file_shares_images', []))) {
                    $media->delete();
                }
            }
        }

        $media = $file_share->file_shares_images->pluck('file_name')->toArray();

        foreach ($request->input('file_shares_images', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $file_share->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('file_shares_images');
            }
        }
        return redirect()->route('admin.file_shares.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(FileShare $file_share)
    {
        abort_if(Gate::denies('file_share_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $file_share->delete();

        return back();
    }
    public function massDestroy(MassDestroyFileShareRequest $request)
    {
        FileShare::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
