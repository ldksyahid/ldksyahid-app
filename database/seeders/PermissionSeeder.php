<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // reset cahced roles and permission
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'admin']);
        Permission::create(['name' => 'admin dashboard']);

        Permission::create(['name' => 'admin user index']);
        Permission::create(['name' => 'admin user read']);
        Permission::create(['name' => 'admin user create']);
        Permission::create(['name' => 'admin user store']);
        Permission::create(['name' => 'admin user edit']);
        Permission::create(['name' => 'admin user update']);
        Permission::create(['name' => 'admin user destroy']);
        Permission::create(['name' => 'admin user preview']);

        Permission::create(['name' => 'admin about contact index']);
        Permission::create(['name' => 'admin about contact destroy']);
        Permission::create(['name' => 'admin about contact show']);

        Permission::create(['name' => 'admin jumbotron index']);
        Permission::create(['name' => 'admin jumbotron create']);
        Permission::create(['name' => 'admin jumbotron store']);
        Permission::create(['name' => 'admin jumbotron edit']);
        Permission::create(['name' => 'admin jumbotron update']);
        Permission::create(['name' => 'admin jumbotron destroy']);
        Permission::create(['name' => 'admin jumbotron preview']);

        Permission::create(['name' => 'admin testimony index']);
        Permission::create(['name' => 'admin testimony create']);
        Permission::create(['name' => 'admin testimony store']);
        Permission::create(['name' => 'admin testimony edit']);
        Permission::create(['name' => 'admin testimony update']);
        Permission::create(['name' => 'admin testimony destroy']);

        Permission::create(['name' => 'admin event index']);
        Permission::create(['name' => 'admin event create']);
        Permission::create(['name' => 'admin event store']);
        Permission::create(['name' => 'admin event edit']);
        Permission::create(['name' => 'admin event update']);
        Permission::create(['name' => 'admin event destroy']);

        Permission::create(['name' => 'admin article index']);
        Permission::create(['name' => 'admin article create']);
        Permission::create(['name' => 'admin article store']);
        Permission::create(['name' => 'admin article edit']);
        Permission::create(['name' => 'admin article update']);
        Permission::create(['name' => 'admin article destroy']);

        Permission::create(['name' => 'admin news index']);
        Permission::create(['name' => 'admin news create']);
        Permission::create(['name' => 'admin news store']);
        Permission::create(['name' => 'admin news edit']);
        Permission::create(['name' => 'admin news update']);
        Permission::create(['name' => 'admin news destroy']);

        Permission::create(['name' => 'admin schedule index']);
        Permission::create(['name' => 'admin schedule create']);
        Permission::create(['name' => 'admin schedule store']);
        Permission::create(['name' => 'admin schedule edit']);
        Permission::create(['name' => 'admin schedule update']);
        Permission::create(['name' => 'admin schedule destroy']);

        Permission::create(['name' => 'admin about gallery index']);
        Permission::create(['name' => 'admin about gallery create']);
        Permission::create(['name' => 'admin about gallery store']);
        Permission::create(['name' => 'admin about gallery edit']);
        Permission::create(['name' => 'admin about gallery update']);
        Permission::create(['name' => 'admin about gallery destroy']);

        Permission::create(['name' => 'admin about structure index']);
        Permission::create(['name' => 'admin about structure create']);
        Permission::create(['name' => 'admin about structure store']);
        Permission::create(['name' => 'admin about structure edit']);
        Permission::create(['name' => 'admin about structure update']);
        Permission::create(['name' => 'admin about structure destroy']);

        Permission::create(['name' => 'admin reqservice shortlink index']);
        Permission::create(['name' => 'admin reqservice shortlink read']);
        Permission::create(['name' => 'admin reqservice shortlink destroy']);
        Permission::create(['name' => 'admin reqservice shortlink show']);
        Permission::create(['name' => 'admin reqservice shortlink addFixCustomLinkEdit']);
        Permission::create(['name' => 'admin reqservice shortlink addFixCustomLinkUpdate']);

        Permission::create(['name' => 'admin about itsupport index']);
        Permission::create(['name' => 'admin about itsupport create']);
        Permission::create(['name' => 'admin about itsupport store']);
        Permission::create(['name' => 'admin about itsupport edit']);
        Permission::create(['name' => 'admin about itsupport update']);
        Permission::create(['name' => 'admin about itsupport destroy']);

        Permission::create(['name' => 'admin service index campaign']);
        Permission::create(['name' => 'admin service create campaign']);
        Permission::create(['name' => 'admin service store campaign']);
        Permission::create(['name' => 'admin service edit campaign']);
        Permission::create(['name' => 'admin service update campaign']);
        Permission::create(['name' => 'admin service preview campaign']);
        Permission::create(['name' => 'admin service destroy campaign']);
        Permission::create(['name' => 'dependent dropdown store kota']);

        Permission::create(['name' => 'admin service callkestari index']);
        Permission::create(['name' => 'admin service callkestari read']);
        Permission::create(['name' => 'admin service callkestari create']);
        Permission::create(['name' => 'admin service callkestari store']);
        Permission::create(['name' => 'admin service callkestari edit']);
        Permission::create(['name' => 'admin service callkestari update']);
        Permission::create(['name' => 'admin service callkestari destroy']);

        Permission::create(['name' => 'admin service index donation']);
        Permission::create(['name' => 'admin service create donation']);

        Permission::create(['name' => 'admin service shortlink index']);
        Permission::create(['name' => 'admin service shortlink shorten']);
        Permission::create(['name' => 'admin service shortlink update']);
        Permission::create(['name' => 'admin service shortlink destroy']);

        //create roles and assign existing permissions
        $superadminRole = Role::create(['name' => 'Superadmin']);
        // gets all permissions via Gate::before rule

        $helperAdminRole = Role::create(['name' => 'HelperAdmin']);
        $helperAdminRole->givePermissionTo('admin');
        $helperAdminRole->givePermissionTo('admin dashboard');
        $helperAdminRole->givePermissionTo('admin event index');
        $helperAdminRole->givePermissionTo('admin event create');
        $helperAdminRole->givePermissionTo('admin event store');
        $helperAdminRole->givePermissionTo('admin event edit');
        $helperAdminRole->givePermissionTo('admin event update');
        $helperAdminRole->givePermissionTo('admin event destroy');
        $helperAdminRole->givePermissionTo('admin jumbotron index');
        $helperAdminRole->givePermissionTo('admin jumbotron create');
        $helperAdminRole->givePermissionTo('admin jumbotron store');
        $helperAdminRole->givePermissionTo('admin jumbotron edit');
        $helperAdminRole->givePermissionTo('admin jumbotron update');
        $helperAdminRole->givePermissionTo('admin jumbotron destroy');
        $helperAdminRole->givePermissionTo('admin jumbotron preview');
        $helperAdminRole->givePermissionTo('admin testimony index');
        $helperAdminRole->givePermissionTo('admin testimony create');
        $helperAdminRole->givePermissionTo('admin testimony store');
        $helperAdminRole->givePermissionTo('admin testimony edit');
        $helperAdminRole->givePermissionTo('admin testimony update');
        $helperAdminRole->givePermissionTo('admin testimony destroy');
        $helperAdminRole->givePermissionTo('admin service shortlink index');
        $helperAdminRole->givePermissionTo('admin service shortlink shorten');
        $helperAdminRole->givePermissionTo('admin service shortlink update');
        $helperAdminRole->givePermissionTo('admin service shortlink destroy');

        $helperCelsyahidRole = Role::create(['name' => 'HelperCelsyahid']);
        $helperCelsyahidRole->givePermissionTo('admin');
        $helperCelsyahidRole->givePermissionTo('admin dashboard');
        $helperCelsyahidRole->givePermissionTo('admin jumbotron index');
        $helperCelsyahidRole->givePermissionTo('admin jumbotron create');
        $helperCelsyahidRole->givePermissionTo('admin jumbotron store');
        $helperCelsyahidRole->givePermissionTo('admin jumbotron edit');
        $helperCelsyahidRole->givePermissionTo('admin jumbotron update');
        $helperCelsyahidRole->givePermissionTo('admin jumbotron destroy');
        $helperCelsyahidRole->givePermissionTo('admin jumbotron preview');
        $helperCelsyahidRole->givePermissionTo('admin article index');
        $helperCelsyahidRole->givePermissionTo('admin article create');
        $helperCelsyahidRole->givePermissionTo('admin article store');
        $helperCelsyahidRole->givePermissionTo('admin article edit');
        $helperCelsyahidRole->givePermissionTo('admin article update');
        $helperCelsyahidRole->givePermissionTo('admin article destroy');
        $helperCelsyahidRole->givePermissionTo('admin news index');
        $helperCelsyahidRole->givePermissionTo('admin news create');
        $helperCelsyahidRole->givePermissionTo('admin news store');
        $helperCelsyahidRole->givePermissionTo('admin news edit');
        $helperCelsyahidRole->givePermissionTo('admin news update');
        $helperCelsyahidRole->givePermissionTo('admin news destroy');
        $helperCelsyahidRole->givePermissionTo('admin service index donation');
        $helperCelsyahidRole->givePermissionTo('admin service create donation');
        $helperCelsyahidRole->givePermissionTo('admin service index campaign');
        $helperCelsyahidRole->givePermissionTo('admin service create campaign');
        $helperCelsyahidRole->givePermissionTo('admin service store campaign');
        $helperCelsyahidRole->givePermissionTo('admin service edit campaign');
        $helperCelsyahidRole->givePermissionTo('admin service shortlink index');
        $helperCelsyahidRole->givePermissionTo('admin service shortlink shorten');
        $helperCelsyahidRole->givePermissionTo('admin service shortlink update');
        $helperCelsyahidRole->givePermissionTo('admin service shortlink destroy');


        $helperEventMartRole = Role::create(['name' => 'HelperEventMart']);
        $helperEventMartRole->givePermissionTo('admin');
        $helperEventMartRole->givePermissionTo('admin dashboard');
        $helperEventMartRole->givePermissionTo('admin jumbotron index');
        $helperEventMartRole->givePermissionTo('admin jumbotron create');
        $helperEventMartRole->givePermissionTo('admin jumbotron store');
        $helperEventMartRole->givePermissionTo('admin jumbotron edit');
        $helperEventMartRole->givePermissionTo('admin jumbotron update');
        $helperEventMartRole->givePermissionTo('admin jumbotron destroy');
        $helperEventMartRole->givePermissionTo('admin jumbotron preview');
        $helperEventMartRole->givePermissionTo('admin service shortlink index');
        $helperEventMartRole->givePermissionTo('admin service shortlink shorten');
        $helperEventMartRole->givePermissionTo('admin service shortlink update');
        $helperEventMartRole->givePermissionTo('admin service shortlink destroy');



        $helperSPAMRole = Role::create(['name' => 'HelperSPAM']);
        $helperSPAMRole->givePermissionTo('admin');
        $helperSPAMRole->givePermissionTo('admin dashboard');
        $helperSPAMRole->givePermissionTo('admin jumbotron index');
        $helperSPAMRole->givePermissionTo('admin jumbotron create');
        $helperSPAMRole->givePermissionTo('admin jumbotron store');
        $helperSPAMRole->givePermissionTo('admin jumbotron edit');
        $helperSPAMRole->givePermissionTo('admin jumbotron update');
        $helperSPAMRole->givePermissionTo('admin jumbotron destroy');
        $helperSPAMRole->givePermissionTo('admin jumbotron preview');
        $helperSPAMRole->givePermissionTo('admin service shortlink index');
        $helperSPAMRole->givePermissionTo('admin service shortlink shorten');
        $helperSPAMRole->givePermissionTo('admin service shortlink update');
        $helperSPAMRole->givePermissionTo('admin service shortlink destroy');
        $helperSPAMRole->givePermissionTo('admin testimony index');
        $helperSPAMRole->givePermissionTo('admin testimony create');
        $helperSPAMRole->givePermissionTo('admin testimony store');
        $helperSPAMRole->givePermissionTo('admin testimony edit');
        $helperSPAMRole->givePermissionTo('admin testimony update');
        $helperSPAMRole->givePermissionTo('admin testimony destroy');
        $helperSPAMRole->givePermissionTo('admin event index');
        $helperSPAMRole->givePermissionTo('admin event create');
        $helperSPAMRole->givePermissionTo('admin event store');
        $helperSPAMRole->givePermissionTo('admin event edit');
        $helperSPAMRole->givePermissionTo('admin event update');
        $helperSPAMRole->givePermissionTo('admin event destroy');
        $helperSPAMRole->givePermissionTo('admin schedule index');
        $helperSPAMRole->givePermissionTo('admin schedule create');
        $helperSPAMRole->givePermissionTo('admin schedule store');
        $helperSPAMRole->givePermissionTo('admin schedule edit');
        $helperSPAMRole->givePermissionTo('admin schedule update');
        $helperSPAMRole->givePermissionTo('admin schedule destroy');
        $helperSPAMRole->givePermissionTo('admin about contact index');
        $helperSPAMRole->givePermissionTo('admin about contact destroy');
        $helperSPAMRole->givePermissionTo('admin about contact show');


        $helperMediaRole = Role::create(['name' => 'HelperMedia']);
        $helperMediaRole->givePermissionTo('admin');
        $helperMediaRole->givePermissionTo('admin dashboard');
        $helperMediaRole->givePermissionTo('admin jumbotron index');
        $helperMediaRole->givePermissionTo('admin jumbotron create');
        $helperMediaRole->givePermissionTo('admin jumbotron store');
        $helperMediaRole->givePermissionTo('admin jumbotron edit');
        $helperMediaRole->givePermissionTo('admin jumbotron update');
        $helperMediaRole->givePermissionTo('admin jumbotron destroy');
        $helperMediaRole->givePermissionTo('admin jumbotron preview');
        $helperMediaRole->givePermissionTo('admin testimony index');
        $helperMediaRole->givePermissionTo('admin testimony create');
        $helperMediaRole->givePermissionTo('admin testimony store');
        $helperMediaRole->givePermissionTo('admin testimony edit');
        $helperMediaRole->givePermissionTo('admin testimony update');
        $helperMediaRole->givePermissionTo('admin testimony destroy');
        $helperMediaRole->givePermissionTo('admin event index');
        $helperMediaRole->givePermissionTo('admin event create');
        $helperMediaRole->givePermissionTo('admin event store');
        $helperMediaRole->givePermissionTo('admin event edit');
        $helperMediaRole->givePermissionTo('admin event update');
        $helperMediaRole->givePermissionTo('admin event destroy');
        $helperMediaRole->givePermissionTo('admin article index');
        $helperMediaRole->givePermissionTo('admin article create');
        $helperMediaRole->givePermissionTo('admin article store');
        $helperMediaRole->givePermissionTo('admin article edit');
        $helperMediaRole->givePermissionTo('admin article update');
        $helperMediaRole->givePermissionTo('admin article destroy');
        $helperMediaRole->givePermissionTo('admin news index');
        $helperMediaRole->givePermissionTo('admin news create');
        $helperMediaRole->givePermissionTo('admin news store');
        $helperMediaRole->givePermissionTo('admin news edit');
        $helperMediaRole->givePermissionTo('admin news update');
        $helperMediaRole->givePermissionTo('admin news destroy');
        $helperMediaRole->givePermissionTo('admin schedule index');
        $helperMediaRole->givePermissionTo('admin schedule create');
        $helperMediaRole->givePermissionTo('admin schedule store');
        $helperMediaRole->givePermissionTo('admin schedule edit');
        $helperMediaRole->givePermissionTo('admin schedule update');
        $helperMediaRole->givePermissionTo('admin schedule destroy');
        $helperMediaRole->givePermissionTo('admin about contact index');
        $helperMediaRole->givePermissionTo('admin about contact destroy');
        $helperMediaRole->givePermissionTo('admin about contact show');
        $helperMediaRole->givePermissionTo('admin about structure index');
        $helperMediaRole->givePermissionTo('admin about structure create');
        $helperMediaRole->givePermissionTo('admin about structure store');
        $helperMediaRole->givePermissionTo('admin about structure edit');
        $helperMediaRole->givePermissionTo('admin about structure update');
        $helperMediaRole->givePermissionTo('admin about structure destroy');
        $helperMediaRole->givePermissionTo('admin about gallery index');
        $helperMediaRole->givePermissionTo('admin about gallery create');
        $helperMediaRole->givePermissionTo('admin about gallery store');
        $helperMediaRole->givePermissionTo('admin about gallery edit');
        $helperMediaRole->givePermissionTo('admin about gallery update');
        $helperMediaRole->givePermissionTo('admin about gallery destroy');
        $helperMediaRole->givePermissionTo('admin service callkestari index');
        $helperMediaRole->givePermissionTo('admin service callkestari read');
        $helperMediaRole->givePermissionTo('admin service callkestari create');
        $helperMediaRole->givePermissionTo('admin service callkestari store');
        $helperMediaRole->givePermissionTo('admin service callkestari edit');
        $helperMediaRole->givePermissionTo('admin service callkestari update');
        $helperMediaRole->givePermissionTo('admin service callkestari destroy');
        $helperMediaRole->givePermissionTo('admin service shortlink index');
        $helperMediaRole->givePermissionTo('admin service shortlink shorten');
        $helperMediaRole->givePermissionTo('admin service shortlink update');
        $helperMediaRole->givePermissionTo('admin service shortlink destroy');
        $helperMediaRole->givePermissionTo('admin reqservice shortlink index');
        $helperMediaRole->givePermissionTo('admin reqservice shortlink read');
        $helperMediaRole->givePermissionTo('admin reqservice shortlink destroy');
        $helperMediaRole->givePermissionTo('admin reqservice shortlink show');
        $helperMediaRole->givePermissionTo('admin reqservice shortlink addFixCustomLinkEdit');
        $helperMediaRole->givePermissionTo('admin reqservice shortlink addFixCustomLinkUpdate');


        $helperLetterRole = Role::create(['name' => 'HelperLetter']);
        $helperLetterRole->givePermissionTo('admin');
        $helperLetterRole->givePermissionTo('admin dashboard');
        $helperLetterRole->givePermissionTo('admin service callkestari index');
        $helperLetterRole->givePermissionTo('admin service callkestari read');
        $helperLetterRole->givePermissionTo('admin service callkestari create');
        $helperLetterRole->givePermissionTo('admin service callkestari store');
        $helperLetterRole->givePermissionTo('admin service callkestari edit');
        $helperLetterRole->givePermissionTo('admin service callkestari update');
        $helperLetterRole->givePermissionTo('admin service callkestari destroy');
        $helperLetterRole->givePermissionTo('admin service shortlink index');
        $helperLetterRole->givePermissionTo('admin service shortlink shorten');
        $helperLetterRole->givePermissionTo('admin service shortlink update');
        $helperLetterRole->givePermissionTo('admin service shortlink destroy');

        $userRole = Role::create(['name' => 'User']);

        $userID1 = User::where('id', 1)->first();
        $userID1->assignRole($helperMediaRole);

        $userID2 = User::where('id', 2)->first();
        $userID2->assignRole($superadminRole);


    }
}
