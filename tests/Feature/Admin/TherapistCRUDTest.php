<?php

namespace Tests\Feature\Admin;

use App\Models\Therapist;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TherapistCRUDTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $customer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->customer = User::factory()->create([
            'role' => 'customer',
        ]);
    }

    public function test_guest_cannot_access_therapists()
    {
        $response = $this->get(route('admin.therapists.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_customer_cannot_access_therapists()
    {
        $response = $this->actingAs($this->customer)->get(route('admin.therapists.index'));
        $response->assertRedirect(route('home'));
    }

    public function test_admin_can_access_therapists()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.therapists.index'));
        $response->assertStatus(200);
    }

    public function test_admin_can_store_therapist_with_url()
    {
        $response = $this->actingAs($this->admin)->post(route('admin.therapists.store'), [
            'name' => 'Adelia',
            'specialization' => 'Shiatsu Massage',
            'rating' => '4.7',
            'status' => 'active',
            'image_url' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=300&q=80',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('therapists', [
            'name' => 'Adelia',
            'specialization' => 'Shiatsu Massage',
            'rating' => 4.70,
            'status' => 'active',
            'image' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=300&q=80',
        ]);
    }

    public function test_admin_can_store_therapist_with_file_upload()
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('therapist.jpg');

        $response = $this->actingAs($this->admin)->post(route('admin.therapists.store'), [
            'name' => 'Rina',
            'specialization' => 'Aromatherapy',
            'rating' => '4.9',
            'status' => 'active',
            'image_file' => $file,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $therapist = Therapist::where('name', 'Rina')->first();
        $this->assertNotNull($therapist);
        
        // Assert file exists in public storage
        Storage::disk('public')->assertExists($therapist->getRawOriginal('image'));

        $this->assertEquals('Aromatherapy', $therapist->specialization);
        $this->assertEquals(4.90, $therapist->rating);
        $this->assertEquals('active', $therapist->status);
    }

    public function test_admin_can_update_therapist_details_and_image()
    {
        Storage::fake('public');
        
        $therapist = Therapist::create([
            'name' => 'Maya',
            'specialization' => 'Traditional Massage',
            'rating' => 4.50,
            'status' => 'active',
            'image' => 'therapists/old_photo.jpg',
        ]);

        // Place a fake old photo in storage
        Storage::disk('public')->put('therapists/old_photo.jpg', 'fake content');

        $newFile = UploadedFile::fake()->image('new_therapist.jpg');

        $response = $this->actingAs($this->admin)->post(route('admin.therapists.update', $therapist->id), [
            'name' => 'Maya Updated',
            'specialization' => 'Traditional Massage & Scrub',
            'rating' => '4.8',
            'status' => 'holiday',
            'image_file' => $newFile,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $therapist->refresh();

        $this->assertEquals('Maya Updated', $therapist->name);
        $this->assertEquals('Traditional Massage & Scrub', $therapist->specialization);
        $this->assertEquals(4.80, $therapist->rating);
        $this->assertEquals('holiday', $therapist->status);

        // Assert old file deleted
        Storage::disk('public')->assertMissing('therapists/old_photo.jpg');
        // Assert new file exists
        Storage::disk('public')->assertExists($therapist->getRawOriginal('image'));
    }

    public function test_admin_can_delete_therapist()
    {
        Storage::fake('public');

        $therapist = Therapist::create([
            'name' => 'Budi',
            'specialization' => 'Deep Tissue',
            'rating' => 4.60,
            'status' => 'active',
            'image' => 'therapists/budi.jpg',
        ]);

        Storage::disk('public')->put('therapists/budi.jpg', 'fake content');

        $response = $this->actingAs($this->admin)->delete(route('admin.therapists.destroy', $therapist->id));

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('therapists', [
            'id' => $therapist->id,
        ]);

        // Assert image file is deleted from disk
        Storage::disk('public')->assertMissing('therapists/budi.jpg');
    }
}
