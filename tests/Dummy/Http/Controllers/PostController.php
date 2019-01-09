<?php

declare(strict_types=1);

namespace Sarala\Dummy\Http\Controllers;

use Sarala\Dummy\Post;
use Sarala\Http\Controllers\BaseController;
use Sarala\Dummy\Transformers\PostTransformer;
use Sarala\Dummy\Http\Requests\PostItemRequest;
use Sarala\Dummy\Http\Requests\PostCollectionRequest;

class PostController extends BaseController
{
    public function index(PostCollectionRequest $request)
    {
        $data = $request->builder()->fetch();

        return $this->responseCollection($data, new PostTransformer(), 'posts');
    }

    public function show(Post $post, PostItemRequest $request)
    {
        $data = $request->builder()->fetchFirst();

        return $this->responseItem($data, new PostTransformer(), 'posts');
    }
}
