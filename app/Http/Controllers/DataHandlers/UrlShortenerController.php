<?php

namespace App\Http\Controllers\DataHandlers;

use App\Http\Controllers\Controller;
use App\Models\Data\ShortUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class UrlShortenerController extends Controller
{
    public function index()
    {
        $shortened = ShortUrl::with('author')->get();

        return view('app.staff.urlshortener', [
            "urls" => $shortened,
        ]);
    }

    public function make(Request $request)
    {
        $shortened = ShortUrl::where('short', request('newshort'))->first();
        if (!is_null($shortened)) {
            return redirect()->back()->with('toast-error', 'Error occured: this short already exists');
        }
        if (is_null(request('newshort')) or is_null(request('newurl'))) {
            return redirect()->back()->with('toast-error', 'Error occured: missing data');
        }
        $url = new ShortUrl;
        $url->user_id = auth()->user()->id;
        $url->short = request('newshort');
        $url->url = request('newurl');
        $url->save();
        return redirect()->route('app.staff.urlshortener', app()->getLocale())->with('toast-success', 'Shortened URL created');
    }

    public function edit(Request $request)
    {
        $url = ShortUrl::where('id', request('shortid'))->first();
        if (is_null($url)) {
            return redirect()->back()->with('toast-error', 'Error occured: this short does not exist');
        }
        if (is_null(request('newshort')) or is_null(request('newurl'))) {
            return redirect()->back()->with('toast-error', 'Error occured: missing data');
        }
        $url->user_id = auth()->user()->id;
        $url->short = request('newshort');
        $url->url = request('newurl');
        $url->save();
        return redirect()->route('app.staff.urlshortener', app()->getLocale())->with('toast-success', 'Shortened URL edited');
    }

    public function delete(Request $request)
    {
        $url = ShortUrl::where('id', request('shortid'))->first();
        if (is_null($url)) {
            return redirect()->back()->with('toast-error', 'Error occured: this short does not exist');
        }
        $url->delete();
        return redirect()->route('app.staff.urlshortener', app()->getLocale())->with('toast-success', 'Shortened URL deleted');
    }

    public function fetch($short)
    {
        $url = ShortUrl::where('short', $short)->first();
        if (is_null($url)) {
            return redirect()->route('landingpage.home', app()->getLocale())->with('pop-error', 'URL could not be found');
        }
        return redirect()->away($url->url);
    }
}
