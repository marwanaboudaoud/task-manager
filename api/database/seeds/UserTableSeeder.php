<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Administrator',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'admin@holygrow.nl',
            'email_verified_at' => now(),
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
            'remember_token' => str_random(10),
        ]);

        DB::table('users')->insert([
            'name' => 'Johan van Luik',
            'first_name' => 'Johan',
            'last_name' => 'van Luik',
            'email' => 'johan@fortagroep.nl',
            'email_verified_at' => now(),
            'password' => '$2y$10$Fe3TLoKK1lCAPimYCg3F6ujMpcro8t1pumUGcIcoHI6B/DOxdWR3m', // secret
            'remember_token' => str_random(10),
        ]);

        DB::table('users')->insert([
            'name' => 'Aldert Seinen',
            'first_name' => 'Aldert',
            'last_name' => 'Seinen',
            'email' => 'a.seinen@fortagroep.nl',
            'email_verified_at' => now(),
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
            'remember_token' => str_random(10),
        ]);

        DB::table('users')->insert([
            'name' => 'René Thomassen',
            'first_name' => 'René',
            'last_name' => 'Thomassen',
            'email' => 'r.thomassen@fortagroep.nl',
            'email_verified_at' => now(),
            'password' => '$2y$10$ovH7JBvG.Z0Ds9U8kDUvfeCdVqN1RwMgB8uhYIInyFsXRMUZcFoie', // secret
            'remember_token' => str_random(10),
        ]);

        DB::table('users')->insert([
            'name' => 'Vincent Karthaus',
            'first_name' => 'Vincent',
            'last_name' => 'Karthaus',
            'email' => 'v.karthaus@fortagroep.nl',
            'email_verified_at' => now(),
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
            'remember_token' => str_random(10),
        ]);

        DB::table('users')->insert([
            'name' => 'Pieter van Bokkem',
            'first_name' => 'Pieter',
            'last_name' => 'van Bokkem',
            'email' => 'p.vanbokkem@fortagroep.nl',
            'email_verified_at' => now(),
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
            'remember_token' => str_random(10),
        ]);

        DB::table('users')->insert([
            'name' => 'Arjan Stuurman',
            'first_name' => 'Arjan',
            'last_name' => 'Stuurman',
            'email' => 'a.stuurman@fortagroep.nl',
            'email_verified_at' => now(),
            'password' => '$2y$10$XZlY9NA9RYqS15rXaNTNweBpIlxv3NyJtJYAb/S75DalPF.bg01ve', // secret
            'remember_token' => str_random(10),
        ]);

        DB::table('users')->insert([
            'name' => 'Patricia Stallinga',
            'first_name' => 'Patricia',
            'last_name' => 'Stallinga',
            'email' => 'p.stallinga@fortagroep.nl',
            'email_verified_at' => now(),
            'password' => '$2y$10$BuSz/IBq2Tt7KkG5oBdpp.iQzZmj41mx9Gr7UW5CrM0Wsqzu1Z.SC', // secret
            'remember_token' => str_random(10),
        ]);

        DB::table('users')->insert([
            'name' => 'Marjon Seriese',
            'first_name' => 'Marjon',
            'last_name' => 'Seriese',
            'email' => 'm.seriese@fortagroep.nl',
            'email_verified_at' => now(),
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
            'remember_token' => str_random(10),
        ]);

        DB::table('users')->insert([
            'name' => 'Dory Touw',
            'first_name' => 'Dory',
            'last_name' => 'Touw',
            'email' => 'd.touw@fortagroep.nl',
            'email_verified_at' => now(),
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
            'remember_token' => str_random(10),
        ]);

        DB::table('users')->insert([
            'name' => 'Jeroen Thomassen',
            'first_name' => 'Jeroen',
            'last_name' => 'Thomassen',
            'email' => 'j.thomassen@fortagroep.nl',
            'email_verified_at' => now(),
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
            'remember_token' => str_random(10),
        ]);
//        factory(App\User::class, 10)->create();
    }
}
