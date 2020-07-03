<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use App\Http\Resources\Admin\NewsResource;
use App\News;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class NewsApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('news_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new NewsResource(News::all());
    }

    public function store(StoreNewsRequest $request)
    {
        $news = News::create($request->all());

        if ($request->input('news_images', false)) {
            $news->addMedia(storage_path('tmp/uploads/' . $request->input('news_images')))->toMediaCollection('news_images');
        }

        return (new NewsResource($news))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(News $news)
    {
        abort_if(Gate::denies('news_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new NewsResource($news);
    }

    public function update(UpdateNewsRequest $request, News $news)
    {
        $news->update($request->all());

        if ($request->input('news_images', false)) {
            if (!$news->news_images || $request->input('news_images') !== $news->news_images->file_name) {
                $news->addMedia(storage_path('tmp/uploads/' . $request->input('news_images')))->toMediaCollection('news_images');
            }
        } elseif ($news->news_images) {
            $news->news_images->delete();
        }

        return (new NewsResource($news))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(News $news)
    {
        abort_if(Gate::denies('news_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $news->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
