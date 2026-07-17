<?php

namespace Tests\Feature;

use App\Mail\ContactMessageReceived;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactMessageTest extends TestCase
{
    use RefreshDatabase;

    private function payload(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Jane Doe',
            'email' => 'jane@gmail.com',
            'phone' => '+1 555 0100',
            'subject' => 'Website redesign',
            'message' => 'We would like to discuss a full website redesign project.',
        ], $overrides);
    }

    public function test_web_form_stores_message_and_queues_email(): void
    {
        Mail::fake();

        $response = $this->post(route('contact.store'), $this->payload());

        $response->assertRedirect(route('contact'));
        $response->assertSessionHas('status');

        $this->assertDatabaseCount('contact_messages', 1);
        $this->assertDatabaseHas('contact_messages', ['email' => 'jane@gmail.com']);

        Mail::assertQueued(ContactMessageReceived::class, function (ContactMessageReceived $mail) {
            return $mail->hasTo(config('mail.contact.to'));
        });
    }

    public function test_api_stores_message_and_returns_201(): void
    {
        Mail::fake();

        $response = $this->postJson('/api/contact-messages', $this->payload());

        $response->assertCreated()
            ->assertJsonStructure(['message', 'data' => ['id', 'created_at']]);

        $this->assertDatabaseCount('contact_messages', 1);
        Mail::assertQueued(ContactMessageReceived::class);
    }

    public function test_fourth_successful_submission_within_an_hour_is_blocked(): void
    {
        Mail::fake();

        foreach (range(1, 3) as $i) {
            $this->post(route('contact.store'), $this->payload(['subject' => "Message {$i}"]))
                ->assertRedirect(route('contact'));
        }

        $this->post(route('contact.store'), $this->payload(['subject' => 'Message 4']))
            ->assertSessionHasErrors('message');

        $this->assertDatabaseCount('contact_messages', 3);
    }

    public function test_api_rate_limit_returns_429_with_retry_after(): void
    {
        Mail::fake();

        foreach (range(1, 3) as $i) {
            $this->postJson('/api/contact-messages', $this->payload())->assertCreated();
        }

        $response = $this->postJson('/api/contact-messages', $this->payload());

        $response->assertStatus(429);
        $this->assertNotNull($response->headers->get('Retry-After'));
        $this->assertDatabaseCount('contact_messages', 3);
    }

    public function test_invalid_attempts_do_not_consume_the_rate_limit(): void
    {
        Mail::fake();

        foreach (range(1, 3) as $i) {
            $this->postJson('/api/contact-messages', $this->payload(['email' => 'not-an-email']))
                ->assertStatus(422);
        }

        $this->postJson('/api/contact-messages', $this->payload())->assertCreated();
    }
}
