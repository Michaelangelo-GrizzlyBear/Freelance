<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Item;
use App\Models\RolePages;
use App\Models\Doctor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'lastname' => 'Super',
            'firstname' => 'Admin',
            'middlename' => 'SA.',
            'birthDate' => '1969/06/06',
            'birthPlace' => 'Quezon City',
            'suffix' => 'SAdmin',
            'age' => '26',
            'sex' => 'male',
            'contact' => '091234567891',
            'emergencyNo' => '09876543210',
            'emergencyContact' => 'Admin',
            'email' => 'sa@sa.com',
            'password' => Hash::make('password'),
            'role' => 1,
            'image' => ' ',
        ]);
        User::create([
            'lastname' => 'Admin',
            'firstname' => 'Admin',
            'middlename' => 'A.',
            'birthDate' => '1969/06/06',
            'birthPlace' => 'Quezon City',
            'suffix' => 'Admin',
            'age' => '26',
            'sex' => 'male',
            'contact' => '091234567891',
            'emergencyNo' => '09876543210',
            'emergencyContact' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'role' => 2,
            'image' => ' ',
        ]);
        User::create([
            'lastname' => 'Med',
            'firstname' => 'Tech',
            'middlename' => 'MT',
            'birthDate' => '1969/06/06',
            'birthPlace' => 'Quezon City',
            'suffix' => 'MT',
            'age' => '26',
            'sex' => 'male',
            'contact' => '091234567891',
            'emergencyNo' => '09876543210',
            'emergencyContact' => 'Medtech',
            'email' => 'mt@mt.com',
            'password' => Hash::make('password'),
            'role' => 3,
            'image' => ' ',
        ]);
        User::create([
            'lastname' => 'Doctor',
            'firstname' => 'Doc',
            'middlename' => 'Doc.',
            'birthDate' => '1969/06/06',
            'birthPlace' => 'Quezon City',
            'suffix' => 'Doc',
            'age' => '26',
            'sex' => 'male',
            'contact' => '091234567891',
            'emergencyNo' => '09876543210',
            'emergencyContact' => 'Head',
            'email' => 'd@d.com',
            'password' => Hash::make('password'),
            'role' => 4,
            'image' => ' ',
        ]);
        User::create([
            'lastname' => 'Head',
            'firstname' => 'Head',
            'middlename' => 'H.',
            'birthDate' => '1969/06/06',
            'birthPlace' => 'Quezon City',
            'suffix' => 'Doc',
            'age' => '26',
            'sex' => 'male',
            'contact' => '091234567891',
            'emergencyNo' => '09876543210',
            'emergencyContact' => 'Head',
            'email' => 'h@h.com',
            'password' => Hash::make('password'),
            'role' => 5,
            'image' => ' ',
        ]);
        User::create([
            'lastname' => 'Patient',
            'firstname' => 'Patient',
            'middlename' => 'P.',
            'birthDate' => '1969/06/06',
            'birthPlace' => 'Quezon City',
            'suffix' => 'Doc',
            'age' => '26',
            'sex' => 'male',
            'contact' => '091234567891',
            'emergencyNo' => '09876543210',
            'emergencyContact' => 'Patient',
            'email' => 'p@p.com',
            'password' => Hash::make('password'),
            'role' => 6,
            'image' => ' ',
        ]);

        User::create([
            'lastname' => 'Macatangay',
            'firstname' => 'Jm',
            'middlename' => 'M.',
            'birthDate' => '1998/01/05',
            'birthPlace' => 'Quezon City',
            'suffix' => 'JM',
            'age' => '23',
            'sex' => 'Male',
            'contact' => '091234567891',
            'emergencyNo' => '09876543210',
            'emergencyContact' => 'Patient',
            'email' => 'jm@gmail.com',
            'password' => Hash::make('password'),
            'role' => 6,
            'image' => ' ',
        ]);


        $Role1 = Role::create([
            'name' => 'Super Admin'
        ]);

        $Role2 = Role::create([
            'name' => 'Admin'
        ]);
        
        $Role3 = Role::create([
            'name' => 'MedTech'
        ]);
        
        $Role4 = Role::create([
            'name' => 'Doctor'
        ]);

        $Role5 = Role::create([
            'name' => 'Lab Head'
        ]);

        $Role6 = Role::create([
            'name' => 'Patient'
        ]);

        RolePages::create([
            'name' => 'HomePatient',
            'link' => '/',
            'role_id' => $Role6->id
        ]);
        
        RolePages::create([
            'name' => 'LabTestPrep',
            'link' => '/patient/labtestprep',
            'role_id' => $Role6->id
        ]);

        RolePages::create([
            'name' => 'Doctors',
            'link' => '/patient/doctors',
            'role_id' => $Role6->id
        ]);
        
        RolePages::create([
            'name' => 'Profile',
            'link' => '/profile',
            'role_id' => $Role6->id
        ]);

        Item::create([
            'user_id' => '1',
            'name' => 'Item',
            'price' => '1',
            'itemdescription' => 'Testing Item 1',
            'activeInactive' => 'Active'
        ]);

        Item::create([
            'user_id' => '2',
            'name' => 'Item 2',
            'price' => '2',
            'itemdescription' => 'Testing Item 2',
            'activeInactive' => 'Inactive'
        ]);

        Item::create([
            'user_id' => '2',
            'name' => 'Item 2',
            'price' => '2',
            'itemdescription' => 'Testing Item 2',
            'activeInactive' => 'Inactive'
        ]);

        Item::create([
            'user_id' => '2',
            'name' => 'Item 2',
            'price' => '2',
            'itemdescription' => 'Testing Item 2',
            'activeInactive' => 'Inactive'
        ]);

        Doctor::create([
            'user_id' => '1',
            'doctorname' => 'Dr. Grizzly Bear',
            'specialization' => 'Surgery',
            'location' => 'Quezon City',
            'branch' => 'Quezon City',
            'schedule' => 'Monday: 7:00am - 10:00am, Tuesday: 9:00am - 11:00am',
            'status' => 'Active',
        ]);

        Doctor::create([
            'user_id' => '1',
            'doctorname' => 'Dr. Panda Bear',
            'specialization' => 'Ophthalmology',
            'location' => 'Quezon City',
            'branch' => 'Quezon City',
            'schedule' => 'Wednesday: 7:00am - 10:00am, Thursday: 9:00am - 11:00am',
            'status' => 'Inactive',
        ]);

    }
}
