<?php

namespace Tests\Feature;

use App\Models\Card;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CardShareControllerTest extends TestCase
{
    use refreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_share_card()
    {
        [$user1, $user2] = User::factory(2)->create();

        $card = Card::factory()->createOne([
            "phone_number" => "123456789",
            "user_id" => $user1->id,
        ]);

        $response = $this->actingAs($user1)->post(
            route("card-shares.store"),
            [
                "card_email" => $card->email,
                "user_email" => $user2->email,
            ]
        );

        $response->assertRedirect(route("home"));

        $this->assertDatabaseCount("card_shares", 1);

        $sharedCards = $user2->sharedContacts()->first();

        $this->assertTrue($card->is($sharedCards));
    }

    /**
     * @depends test_user_can_share_card
     */
    public function test_user_can_see_shared_card()
    {
        [$user1, $user2] = User::factory(2)->hasContacts(3)->create();

        $card = $user1->contacts()->first();

        $card->sharedWithUsers()->attach($user2->id);

        $response = $this->actingAs($user2)->get(route("contacts.show", $card->id));

        $response->assertOk();
    }

    /**
     * @depends test_user_can_see_shared_card
     */
    public function test_user_cant_share_already_shared_card()
    {

        [$user1, $user2] = User::factory(2)->hasContacts(3)->create();

        $card = $user1->contacts()->first();

        $card->sharedWithUsers()->attach($user2->id);

        $response = $this->actingAs($user1)->post(
            route("card-shares.store"),
            [
                "card_email" => $card->email,
                "user_email" => $user2->email
            ]
        );

        $response->assertSessionHasErrors(["card_email"]);

        $this->assertDatabaseCount("card_shares", 1);
    }
}
