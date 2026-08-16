<?php

namespace Tests\Feature;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserRolesAndPermissionsTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected Role $adminRole;
    protected Role $managerRole;
    protected Role $userRole;
    protected Permission $viewAdminDashboardPermission;
    protected Permission $administerUsersPermission;

    protected function setUp(): void
    {
        parent::setUp();

        // Create roles
        $this->adminRole = Role::create(['name' => 'admin']);
        $this->managerRole = Role::create(['name' => 'content-manager']);
        $this->userRole = Role::create(['name' => 'user']);

        // Create permissions
        $this->viewAdminDashboardPermission = Permission::create(['name' => 'view-admin-dashboard']);
        $this->administerUsersPermission = Permission::create(['name' => 'administer-users']);

        // Attach permissions to roles
        $this->adminRole->permissions()->attach([
            $this->viewAdminDashboardPermission->id,
            $this->administerUsersPermission->id
        ]);
        $this->managerRole->permissions()->attach($this->viewAdminDashboardPermission);
    }

    // Unauthorized Access Tests
    public function test_unauthorized_user_cannot_access_admin_user_management()
    {
        $response = $this->get(route('users.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_unauthenticated_user_cannot_access_admin_dashboard()
    {
        $response = $this->get(route('users.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_admin_has_correct_permissions()
    {
        $admin = User::factory()->create();
        $adminRole = Role::where('name', 'admin')->first();
        $admin->roles()->attach($adminRole);

        $this->assertTrue($admin->hasPermission('view-admin-dashboard'));
        $this->assertTrue($admin->hasPermission('administer-users'));
    }

    public function test_manager_has_correct_permissions()
    {
        $manager = User::factory()->create();
        $managerRole = Role::where('name', 'content-manager')->first();
        $manager->roles()->attach($managerRole);

        $this->assertTrue($manager->hasPermission('view-admin-dashboard'));
        $this->assertFalse($manager->hasPermission('administer-users'));
    }

    public function test_user_without_roles_has_no_permissions()
    {
        $user = User::factory()->create();

        $this->assertFalse($user->hasPermission('view-admin-dashboard'));
        $this->assertFalse($user->hasPermission('administer-users'));
    }

    public function test_admin_can_create_user()
    {
        $admin = User::factory()->create();
        $admin->roles()->attach($this->adminRole);

        $userData = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password',
            'password_confirmation' => 'password',
            'roles' => [$this->userRole->id],
        ];

        $response = $this->actingAs($admin)->post(route('users.store'), $userData);

        $response->assertRedirect(route('users.index'));
        $this->assertDatabaseHas('users', ['email' => $userData['email']]);
    }

    public function test_admin_can_update_user()
    {
        $admin = User::factory()->create();
        $admin->roles()->attach($this->adminRole);

        $user = User::factory()->create();

        $updatedData = [
            'first_name' => 'Updated',
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password',
            'password_confirmation' => 'password',
            'roles' => [$this->userRole->id],
        ];

        $response = $this->actingAs($admin)->put(route('users.update', $user->id), $updatedData);

        $response->assertRedirect(route('users.show', $user->id));
        $this->assertDatabaseHas('users', ['id' => $user->id, 'first_name' => 'Updated']);
    }

    public function test_admin_can_delete_user()
    {
        $admin = User::factory()->create();
        $admin->roles()->attach($this->adminRole);

        $user = User::factory()->create();

        $response = $this->actingAs($admin)->delete(route('users.destroy', $user->id));

        $response->assertRedirect(route('users.index'));
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_admin_can_view_dashboard()
    {
        $admin = User::factory()->create();
        $admin->roles()->attach($this->adminRole);

        $response = $this->actingAs($admin)->get(route('users.index'));

        $response->assertStatus(200);
    }

    public function test_manager_can_access_manager_dashboard()
    {
        $manager = User::factory()->create();
        $manager->roles()->attach($this->managerRole);

        $response = $this->actingAs($manager)->get(route('manager.dashboard'));

        $response->assertStatus(200);
    }

    public function test_user_cannot_access_manager_dashboard()
    {
        $user = User::factory()->create();
        $user->roles()->attach($this->userRole);

        $response = $this->actingAs($user)->get(route('manager.dashboard'));

        $response->assertStatus(403);
    }

    public function test_admin_can_access_admin_dashboard()
    {
        $admin = User::factory()->create();
        $admin->roles()->attach($this->adminRole);

        $response = $this->actingAs($admin)->get(route('users.index'));

        $response->assertStatus(200);
    }

    public function test_admin_can_access_manager_dashboard()
    {
        $admin = User::factory()->create();
        $admin->roles()->attach($this->adminRole);

        $response = $this->actingAs($admin)->get(route('manager.dashboard'));

        $response->assertStatus(200);
    }

    public function test_user_cannot_access_admin_dashboard()
    {
        $user = User::factory()->create();
        $user->roles()->attach($this->userRole);

        $response = $this->actingAs($user)->get(route('users.index'));

        $response->assertStatus(403);
    }

    public function test_invalid_user_creation_redirects_with_validation_errors()
    {
        $admin = User::factory()->create();
        $admin->roles()->attach($this->adminRole);

        $response = $this->actingAs($admin)
            ->from(route('users.create'))
            ->post(route('users.store'), []);

        $response->assertRedirect(route('users.create'));
        $response->assertSessionHasErrors([
            'first_name',
            'last_name',
            'email',
            'roles',
            'password',
        ]);
    }

    public function test_invalid_user_update_redirects_with_validation_errors()
    {
        $admin = User::factory()->create();
        $admin->roles()->attach($this->adminRole);

        $user = User::factory()->create();

        $response = $this->actingAs($admin)
            ->from(route('users.edit', $user->id))
            ->put(route('users.update', $user->id), []);

        $response->assertRedirect(route('users.edit', $user->id));
        $response->assertSessionHasErrors([
            'first_name',
            'last_name',
            'email',
            'roles',
        ]);
    }
}
