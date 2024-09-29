<?php

namespace App\Http\Controllers;

use App\Models\UrlShortener;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class UrlShortenerController extends Controller
{
    public function index()
    {
        $UrlShorteners = UrlShortener::with('user')->latest()->get();

        return view('dashboard', [
            'UrlShorteners' => $UrlShorteners
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'original_url' => 'required|string|max:255',
        ]);

        UrlShortener::create([
            'user_id' => Auth::user()->id,
            'original_url' => htmlspecialchars(strip_tags($validated['original_url'])),
            'shortener_url' => Str::random(5),
        ]);

        return redirect()->back();
    }

    public function shortenLink($shortener_url)
    {
        $find = UrlShortener::where('shortener_url', $shortener_url)->first();
        return redirect($find->original_url);
    }

    public function countLink(Request $request)
    {
        $shortener = UrlShortener::find($request->input('id'));
        // dd($shortener->click + 1);

        $shortener->update([
            'click' => $shortener->click + 1
        ]);

        return response()->json(['message' => 'Click increment successfully'], 200);

    }
}
