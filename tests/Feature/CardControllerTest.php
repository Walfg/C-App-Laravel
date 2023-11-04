<?php

namespace Tests\Unit;

use App\Models\Card;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CardControllerTest extends TestCase
{

    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_user_can_store_contacts()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        $cardData = Card::factory()->makeOne([
            //makeOne creates one Card, but that card would exists only in memory
            "phone_number" => "123456789",
            "user_id" => $user->id,
        ]);

        $response = $this->actingAs($user)->post(route("contacts.store"), $cardData->getAttributes());
        // $response = $this->actingAs($user)->post(route("contacts.store"), $card->getAttributes());
        $response -> assertRedirect(route("home"));

        $this->assertDatabaseCount("contacts", 1);

        $createdCard = Card::first();

        foreach ($cardData->getAttributes() as $key => $value) {
            $this->assertEquals($value, $createdCard->$key);
        }

    }

    public function test_store_card_validation(){
        // $this->withoutExceptionHandling();

        $user = User::factory()->create();

        $card = Card::factory()->makeOne([
            "phone_number" => "Wrong pn",
            "email" => "Wrong email",
            "name" => null,
        ]);

        $response = $this->actingAs($user)->post(route("contacts.store"), $card->getAttributes());

        $response->assertSessionHasErrors([
            "phone_number",
            "email",
            "name"
        ]);

        $this->assertDatabaseCount("contacts", 0);
    }

    /**
     * @depends test_user_can_store_contacts
     */
    public function test_only_owner_can_update_or_delete_card(){
        // $this->withoutExceptionHandling();

        [$owner, $notOwner] = User::factory(2)->create();

        $card = Card::factory()->createOne([
            "phone_number" => "123456789",
            "user_id" => $owner->id,
        ]);

        $response = $this
            ->actingAs($notOwner)
            ->put(route("contacts.update", $card->id), $card->getAttributes());

        $response->assertForbidden();
        // $response->assertStatus(403);

        $response = $this
            ->actingAs($notOwner)
            ->put(route("contacts.destroy", $card->id), $card->getAttributes());

        $response->assertForbidden();

    }
}
