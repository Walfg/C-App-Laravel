<?php

namespace App\Http\Controllers;

use App\Mail\CardShared;
use App\Models\Card;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class CardShareController extends Controller
{

    public function index(Card $card)
    {
        $contactsSharedWithActualUser = auth()->user()->sharedContacts()->with("user")->paginate(6);
        $contactsYouHaveShared = auth()
            ->user()
            ?->contacts()
            ->with(["sharedWithUsers" => fn ($query) => $query->withPivot("id")])
            ->get()
            ->filter(fn ($card) => $card->sharedWithUsers->isNotEmpty());


        return view("card-shares.index", compact('contactsSharedWithActualUser'), compact('contactsYouHaveShared'));
    }

    public function create()
    {
        return view("card-shares.create");
    }
    public function store(Request $request)
    {

        $data = $request->validate(
            [
                "user_email" => "exists:users,email|not_in:{$request->user()->email}",
                "card_email" => Rule::exists("contacts", "email")
                    ->where("user_id", auth()->id())
            ],
            [
                "user_email.not_in" => "You can't share your own Contact Card to yourself.",
                "card_email.exists" => "You are not holding this Contact Card or not exists"
            ]
        );

        $user = User::where("email", $data["user_email"])->first(["id", "email"]);
        $card = Card::where("email", $data["card_email"])->first(["id", "email"]);
        //["id"] ask just for one value: More efficience, less work

        // DB::statement("INSERT INTO card_shares")...

        $shareExists = $card->SharedWithUsers()->wherePivot("user_id", $user->id)->first();

        if ($shareExists) {
            return back()->withInput()->withErrors([
                "card_email" => "This contact was already shared with user $user->email"
            ]);
        }

        $card->SharedWithUsers()->attach($user->id);

        Mail::to($user)->send(new CardShared(auth()->user()->email, $card->email));

        return redirect()->route('home')
            ->with('alert', [
                "message" => "Contact Card $card->email succefully delivered to $user->email",
                "type" => "success"
            ]);
        // return view("card-shares.store");

        // auth()->user()->card()->create($data);

    }

    public function destroy(int $relId, Request $request) {
        //Shorter way: But makes difficult to handle further cases or verifications
        $cardShare = DB::selectOne("SELECT * FROM card_shares WHERE id = ?", [$relId]);

        $card = Card::findOrFail($cardShare->card_id);

        abort_if($card->user_id !== auth()->id(), 403);

        $card->sharedWithUsers()->detach($cardShare->user_id);

        //Verificates all in one, but is way too monolithic)
        // $card = auth()->user()
        // ?->contacts()
        // ->with(["sharedWithUsers" => fn ($query) => $query->where("card_shares.id", $relId)])
        // ->get()->firstWhere(fn ($card) => $card->sharedWithUsers->isNotEmpty());

        // abort_if($card->user_id !== auth()->id(), 403);


        return redirect()->route('card-shares.index')
        ->with('alert', [
            "message" => "Contact Card $card->email succefully unlinked!",
            "type" => "danger"
        ]);
    }
}
