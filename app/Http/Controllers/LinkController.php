<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Link;

class LinkController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!$this->validateRequest(
            $request,
            ['url' => 'required|min:10|url']
        )) {
            return $this->error();
        }

        $url = $request->input('url');

        if (!$this->isUrlExists($url)) {
            return $this->error('URL does not exist');
        }

        $link = $this->getLink($url);

        return $this->success($link, url('i/' . $link->code));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $code)
    {
        $link = Link::where('code', '=', $code)->first();

        if (!isset($link)) {
            return view('pages.error');
        }

        return redirect($link->url);
    }


    // OTHER

    private function isUrlExists(string $url): bool
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        return ($httpCode == 200);
    }

    private function getLink(string $url): \App\Models\Link
    {
        $link = Link::where('url', '=', $url)->first();

        if (empty($link)) {
            $code = $this->getNewCode();
            $link = Link::create(['url' => $url, 'code' => $code]);
        }

        return $link;
    }

    private function getNewCode(): string
    {
        $code = Str::random(5);

        $existedCode = Link::where('code', '=', $code)->first();
        if (isset($existedCode)) {
            $code = $this->getNewCode();
        }

        return $code;
    }
}
