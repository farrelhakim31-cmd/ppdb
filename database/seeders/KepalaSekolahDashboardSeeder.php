<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\PpdbRegistration;
use App\Models\Payment;
use Carbon\Carbon;

class KepalaSekolahDashboardSeeder extends Seeder
{
    public function run()
    {
        // Create Kepala Sekolah user if not exists
        User::firstOrCreate(
            ['email' => 'kepala@sekolah.com'],
            [
                'name' => 'Kepala Sekolah',
                'password' => bcrypt('password'),
                'role' => 'kepala_sekolah'
            ]
        );

        // Create sample PPDB registrations for the last 6 months
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $registrationCount = rand(10, 50);
            
            for ($j = 0; $j < $registrationCount; $j++) {
                $user = User::factory()->create();
                
                $registration = PpdbRegistration::create([
                    'user_id' => $user->id,
                    'registration_number' => 'PPDB' . $month->format('Ym') . str_pad($j + 1, 3, '0', STR_PAD_LEFT),
                    'full_name' => $user->name,
                    'birth_place' => 'Jakarta',
                    'birth_date' => Carbon::now()->subYears(rand(15, 17)),
                    'gender' => rand(0, 1) ? 'L' : 'P',
                    'religion' => 'Islam',
                    'address' => 'Jl. Contoh No. ' . rand(1, 100),
                    'phone' => '08' . rand(1000000000, 9999999999),
                    'school_origin' => 'SMP Negeri ' . rand(1, 50),
                    'father_name' => 'Bapak ' . $user->name,
                    'mother_name' => 'Ibu ' . $user->name,
                    'parent_phone' => '08' . rand(1000000000, 9999999999),
                    'status' => $this->getRandomStatus(),
                    'created_at' => $month->addDays(rand(1, 28)),
                    'updated_at' => $month->addDays(rand(1, 28))
                ]);

                // Create payment for some registrations
                if (rand(0, 1)) {
                    Payment::create([
                        'ppdb_registration_id' => $registration->id,
                        'amount' => rand(500000, 2000000),
                        'payment_method' => 'transfer',
                        'status' => rand(0, 1) ? 'verified' : 'pending',
                        'created_at' => $registration->created_at->addDays(rand(1, 5)),
                        'updated_at' => $registration->created_at->addDays(rand(1, 5))
                    ]);
                }
            }
        }
    }

    private function getRandomStatus()
    {
        $statuses = ['pending', 'accepted', 'rejected'];
        $weights = [40, 45, 15]; // 40% pending, 45% accepted, 15% rejected
        
        $rand = rand(1, 100);
        if ($rand <= $weights[0]) return $statuses[0];
        if ($rand <= $weights[0] + $weights[1]) return $statuses[1];
        return $statuses[2];
    }
}