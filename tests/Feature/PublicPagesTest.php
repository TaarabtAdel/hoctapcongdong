<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_contact_page_renders(): void
    {
        $this->get(route('front.contact.create'))->assertOk();
    }

    public function test_library_and_gallery_index_render(): void
    {
        $this->get(route('front.library.index'))->assertOk();
        $this->get(route('front.gallery.index'))->assertOk();
        $this->get(route('front.role-models.index'))->assertOk();
    }

    public function test_event_calendar_renders(): void
    {
        $this->get(route('front.events.calendar'))->assertOk();
    }
}
