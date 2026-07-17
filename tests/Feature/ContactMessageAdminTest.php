<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactMessageAdminTest extends TestCase
{
    use RefreshDatabase;

    private function seedMessages(int $count): void
    {
        foreach (range(1, $count) as $i) {
            ContactMessage::create([
                'name' => "Sender {$i}",
                'email' => "sender{$i}@example.com",
                'subject' => "Subject {$i}",
                'message' => 'A message body that is long enough to be realistic.',
            ]);
        }
    }

    public function test_guests_are_redirected_to_login(): void
    {
        $this->get('/contact-messages')->assertRedirect(route('login'));
    }

    public function test_admin_sees_paginated_messages(): void
    {
        $this->seedMessages(15);

        $admin = User::factory()->create();

        $page1 = $this->actingAs($admin)->get('/contact-messages');
        $page1->assertOk();
        $page1->assertSee('Sender 15');
        $page1->assertDontSee('Sender 5');

        $page2 = $this->actingAs($admin)->get('/contact-messages?page=2');
        $page2->assertOk();
        $page2->assertSee('Sender 5');
        $page2->assertDontSee('Sender 15');
    }

    public function test_admin_can_mark_a_message_as_read(): void
    {
        $this->seedMessages(1);

        $admin = User::factory()->create();
        $message = ContactMessage::first();

        $this->actingAs($admin)
            ->from('/contact-messages')
            ->patch("/contact-messages/{$message->id}/read")
            ->assertRedirect('/contact-messages');

        $this->assertNotNull($message->fresh()->read_at);
    }

    public function test_admin_can_delete_a_message(): void
    {
        $this->seedMessages(1);

        $admin = User::factory()->create();
        $message = ContactMessage::first();

        $this->actingAs($admin)
            ->delete("/contact-messages/{$message->id}")
            ->assertRedirect();

        $this->assertDatabaseCount('contact_messages', 0);
    }
}
