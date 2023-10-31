<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCardRequest;
use App\Models\Card;
use Illuminate\Support\Facades\Session;

class CardController extends Controller
{
    // protected $rules = [
    //     "name" => "required",
    //     "phone_number" => "required|digits:9",
    //     "email" => "required|email",
    //     "age" => "required|numeric|min:3|max:255"
    // ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $contacts = auth()->user()->contacts()->paginate(6);
        // $contacts = auth()->user()->contacts()->orderBy('name', 'desc')->paginate(6);
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
    public function store(StoreCardRequest $request)
    {
        $data = $request-> validated();

        // $data = $request->validate($this->rules);

        // $data = $request->validate([
        //     "name" => "required",
        //     "phone_number" => "required|digits:9",
        //     "email" => "required|email",
        //     "age" => "required|numeric|min:3|max:255"
        // ]);
        // $request->validate([
        //     "name" => "required",
        //     "phone_number" => ["required", "digits:9"],
        //     "email" => ["required","email"],
        //     "age" => ["required", "numeric", "min:3", "max:255"]
        // ]);

        if ($request->hasFile("profile_picture")) {
            $path = $request->file("profile_picture")->store("profiles", "public");
            $data["profile_picture"] = $path;
        }

        $card = auth()->user()->contacts()->create($data);
        // $card = auth()->user()->contacts()->create($request->validated());
        // auth()->user()->contacts()->create($data);
        // Card::create([...$data, "user_id" => auth()->id()]);
        ////
        // $data["user_id"] = auth()->id();
        // Card::create($data);

        // Session::flash("alert", ["message" => "Contact Card for $card->name created!","type" => "success"]);

        return redirect()->route('home')->with("alert", [
            "message" => "Contact Card for $card->name created!",
            "type" => "success"
        ]);
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
    public function update(StoreCardRequest $request, Card $card)
    {

        $this->authorize("update", $card);

        $data = $request->validated();

        // $data = $request->validate($this->rules);

        // $data = $request->validate([
        //     "name" => "required",
        //     "phone_number" => "required|digits:9",
        //     "email" => "required|email",
        //     "age" => "required|numeric|min:3|max:255"
        // ]);
        if ($request->hasFile("profile_picture")) {
            $path = $request->file("profile_picture")->store("profiles", "public");
            $data["profile_picture"] = $path;
        };

        $card->update($data);

        // $card->update($data);

        // Session::flash("alert", ["message" => "$card->name Contact Card updated!", "type" => "warning"]);

        return redirect()->route("home")->with("alert", [
            "message" => "$card->name Contact Card updated!",
            "type" => "warning"
        ]);
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

        // Session::flash("alert", ["message" => "$card->name Contact Card deleted!", "type" => "danger"]);

        return back()->with("alert", [
            "message" => "$card->name Contact Card deleted!",
            "type" => "danger"
        ]);
    }
}
