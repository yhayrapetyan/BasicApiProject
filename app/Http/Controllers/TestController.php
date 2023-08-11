<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class TestController extends Controller
{
    public function test(Request $request)
    {
//        $request->session()->flash('mes', 'something');
//        session()->put('foo' , 'bar');
//          session()->flush();
        return response()->json([

                'a' => Cache::get('user')

//            'message' => 'WE ARE TESTING REQUESTS',
//            'path()' => $request->path(),
//            'is(path_name{test})' => $request->path('test'),
//            'routeIs()' => $request->routeIs('test'),
//            'url()' => $request->url(),
//            'fullUrl()' => $request->fullUrl(),
//            'host()' => $request->host(),
//            'getHost()' => $request->getHost(),
//            'getHttpHost()' => $request->getHttpHost(),
//            'getSchemeAndHttpHost' => $request->getSchemeAndHttpHost(),
//            'bearerToken()' => $request->bearerToken(),
//            'ip()' => $request->ip(),
//            'method()' => $request->method(),
//            'all()' => $request->all(), //!!!!!!,
//            'collect()' => $request->collect(),
//            'query(name_not_required)' => $request->query(),
//            'only(r)' => $request->only('name'),
//            'except(r)' => $request->except('something'),
//            'has(r)' => $request->has('key'),
//            'merge(["key" => "value"])' => 'just note',
//            'cookie' => $request->cookie(),
//            'file' => 'note'


        ]);
    }
}
