<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

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

        $this->authorize("view", $card);
        // if (! Gate::allows('update-post', $card)) {
        //     abort(403);
        // }
        // abort_if($card->user_id !== auth()->id(), 403);

        // if ($card->user_id !== auth()->id()){
        //     // dd($card->name, "card", auth()->id(),"user");
        //     abort(Response::HTTP_FORBIDDEN);
        //     // abort(403, "Not owning or existing");
        // };
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
        $this->authorize("update", $card);

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

        $this->authorize("update", $card);

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

        $this->authorize("delete", $card);

        $card->delete();
        return redirect()->route("home");
    }
}
