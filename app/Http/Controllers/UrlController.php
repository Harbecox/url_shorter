<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Http\Request;

class UrlController extends Controller
{
    function redirect(Request $request, $short_code)
    {
        $url = Url::query()->where('short_code', $short_code)->firstOrFail();
        $url->clicks()->create([
            'ip_address' => $request->ip(),
        ]);
        return redirect($url->original_url);
    }
}
