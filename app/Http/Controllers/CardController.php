<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;


class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $contacts = auth()->user()->contacts;
        // $contacts = auth()->user()->contacts()->get();
        // $contacts = Card::query()->where('user_id', auth()->id())->get();
        return view('contacts.index', compact('contacts'));
        // return view('contacts.index', ["contacts" => Card::all()]);
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

        auth()->user()->contacts()->create($data);
        // Card::create([...$data, "user_id" => auth()->id()]);
        ////
        // $data["user_id"] = auth()->id();
        // Card::create($data);

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
        return view("contacts.show", compact('card'));
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
