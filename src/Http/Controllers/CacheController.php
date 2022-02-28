<?php

namespace Twentyonetf\AjaxTableCard\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CacheController extends Controller
{
    public function show($slug)
    {
        return Cache::get($slug);
    }

    public function store(Request $request)
    {
        $timestamp = now()->format('d-m-Y H:i:s');

        Cache::put($request->slug, [
            'rows' => $request->data,
            'since' => $timestamp
        ], $request->cache);

        return $timestamp;
    }
}

