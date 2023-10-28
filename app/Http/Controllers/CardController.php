<?php

namespace App\Http\Controllers;

use App\Models\Card;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

use function PHPUnit\Framework\isNull;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('contacts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            "name" => "required",
            "phone_number" => "required|digits:9",
            "email" => "required|email",
            "age" => "required|numeric|min:3|max:255"
        ]);
        // $request->validate([
        //     "name" => "required",
        //     "phone_number" => ["required", "digits:9"],
        //     "email" => ["required","email"],
        //     "age" => ["required", "numeric", "min:3", "max:255"]
        // ]);
        // dd($data);
        Card::create($data);

        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function show(Card $card)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function edit(Card $card)
    {
        return view('contacts.edit', compact("card"));
        // return view('contacts.edit', ["card" => $card]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Card $card)
    {
        $data = $request->validate([
            "name" => "required",
            "phone_number" => "required|digits:9",
            "email" => "required|email",
            "age" => "required|numeric|min:3|max:255"
        ]);

        $card->update($data);

        return redirect()->route("home");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function destroy(Card $card)
    {

        $card->delete();
        return redirect()->route("home");
    }
}
