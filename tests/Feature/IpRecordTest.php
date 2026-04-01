<?php

namespace Tests\Feature;

use App\Models\IpRecord;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IpRecordTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_index_if_shows_record(){
        IpRecord::factory()->count(5)->create(['user_id' => $this->user->id]);

        $response = $this->actingAs($this->user)->get(route('ip-record.index'));

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => 
            $page->component('IpRecord/Index')
                 ->has('records', 5)
        );
    }

    public function test_user_can_create_ip(){
        $data = [
            'ip_address' => '192.168.1.1',
            'label' => 'test - 1',
            'comment' => 'lorem ipsum'
        ];

        $response = $this->actingAs($this->user)->post(route('ip-record.store'), $data);

        $response->assertRedirect(route('ip-record.index'));
        $this->assertDatabaseHas('ip_records', [
            'ip_address' => '192.168.1.1',
            'label' => 'test - 1',
            'user_id' => $this->user->id
        ]);
        $this->assertDatabaseHas('audit_logs', [
            'event_type' => 'create_ip'
        ]);
    }

    public function test_user_can_update_ip(){
        $record = IpRecord::factory()->create([
            'user_id' => $this->user->id,
            'label' => 'Label - 1'
        ]);

        $response = $this->actingAs($this->user)->put(route('ip-record.update', $record->id), [
            'label' => 'Label - 2'
        ]);

        $response->assertRedirect(route('ip-record.index'));
        $this->assertDatabaseHas('ip_records', [
            'id' => $record->id,
            'label' => 'Label - 2'
        ]);
        $this->assertDatabaseHas('audit_logs', [
            'event_type' => 'update_label',
            'ip_address_id' => $record->id
        ]);
    }

    public function test_superadmin_can_delete_ip(){
        $superadmin = User::factory()->create(['role' => 'superadmin']);
        $record = IpRecord::factory()->create(['user_id' => $superadmin->id]);
        $response = $this->actingAs($superadmin)->delete(route('ip-record.destroy', $record->id));

        $response->assertRedirect(route('ip-record.index'));
        
        $this->assertDatabaseMissing('ip_records', [
            'id' => $record->id
        ]);

        $this->assertDatabaseHas('audit_logs', [
            'event_type' => 'delete_ip',
            'ip_address_id' => $record->id
        ]);
    }

    public function test_admin_cant_delete_ip(){
        $admin = User::factory()->create(['role' => 'admin']);
        $record = IpRecord::factory()->create();
        $response = $this->actingAs($admin)->delete(route('ip-record.destroy', $record->id));

        $response->assertStatus(403);

        $this->assertDatabaseHas('ip_records', [
            'id' => $record->id
        ]);
    }
}