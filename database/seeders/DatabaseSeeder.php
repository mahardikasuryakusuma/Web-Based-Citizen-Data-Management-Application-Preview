<?php

namespace Database\Seeders;

use App\Models\Alamat;
use App\Models\AlamatTinggal;
use App\Models\AnggotaKeluarga;
use App\Models\Bantuan;
use App\Models\BatasBidangTanah;
use App\Models\JenisBantuan;
use App\Models\KepalaKeluarga;
use App\Models\Nomor;
use App\Models\RT;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            PengurusSeeder::class,
        ]);
        $faker = Faker::create();
        $jenisBantuan = [
            ['nama' => 'PKH'],
            ['nama' => 'BPNT'],
            ['nama' => 'BLT'],
        ];

        foreach ($jenisBantuan as $bantuan) {
            JenisBantuan::create([
                'nama_bantuan' => $bantuan['nama'], // Akses nama jenis bantuan
                'keterangan_bantuan' => 'Bansos'
            ]);
        }
        // Buat 10 RT
        $rts = [];
        for ($i = 1; $i <= 10; $i++) {
            // Buat user untuk setiap RT
            $user = User::create([
                'name' => 'User RT ' . $i,
                'email' => 'user_rt' . $i . '@gmail.com',
                'password' => bcrypt('11111111'), // atau pakai Hash::make('password')
                'role' => 'rt',
            ]);

            $rt = RT::create([
                'nama' => 'RT ' . $i,
                'user_id' => $user->id,
            ]);

            $rts[] = $rt->id;
        }

        // Buat 3000 Kepala Keluarga yang terbagi di 10 RT
        for ($i = 1; $i <= 1000; $i++) {
            // Misalnya 1 untuk Warga Tetap, 0 untuk Pendatang
            $statusWarga = $faker->randomElement([0, 1]);

            $kepalaKeluarga = KepalaKeluarga::create([
                'nama' => $faker->name,
                'r_t_id' => $faker->randomElement($rts),
                'tanggal_lahir' => $faker->date(),
                'tempat_lahir' => $faker->city,
                'status' => $faker->randomElement([
                    'Suami',
                    'Istri',
                    'Lajang',
                    'Duda',
                    'Janda',
                    'Anak',
                ]),
                'jenis_pekerjaan' => $faker->randomElement(['Tetap', 'Tidak Tetap', 'Tidak Bekerja']),
                'pekerjaan' => $faker->company,
                'agama' => $faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha', 'Khonghucu']),
                'jenis_kelamin' => $faker->randomElement(['Laki-Laki', 'Perempuan']),
                'status_warga' => $statusWarga,
                'no_kk' => $faker->numerify('33##############'),
                'no_ktp' => $faker->numerify('33##############'),
                'no_hp' => $faker->phoneNumber,
            ]);
            // Buat Alamat
            Alamat::create([
                'kepala_keluarga_id' => $kepalaKeluarga->id,
                'provinsi' => 'Jawa Tengah',
                'kota' => 'Semarang',
                'kecamatan' => 'Semarang Barat',
                'kelurahan' => 'Kembangarum',
                'rw' => '11',
                'rt' => $kepalaKeluarga->r_t_id, // Mengambil nomor RT dari kepala keluarga
                'jalan' => $faker->streetAddress,
            ]);

            // Buat Alamat Tinggal
            AlamatTinggal::create([
                'kepala_keluarga_id' => $kepalaKeluarga->id,
                'provinsi' => 'Jawa Tengah',
                'kota' => 'Semarang',
                'kecamatan' => 'Semarang Barat',
                'kelurahan' => 'Kembangarum',
                'rw' => '11',
                'rt' => $kepalaKeluarga->r_t_id,
                'jalan' => $faker->streetAddress,
                'keadaan_tanah' => $faker->randomElement(['Datar', 'Miring']),
            ]);

            // Buat Anggota Keluarga
            for ($j = 1; $j <= $faker->numberBetween(1, 5); $j++) {
                AnggotaKeluarga::create([
                    'kepala_keluarga_id' => $kepalaKeluarga->id,
                    'nama' => $faker->name,
                    'jenis_kelamin' => $faker->randomElement(['Laki-Laki', 'Perempuan']),
                    'tempat_lahir' => $faker->city,
                    'tanggal_lahir' => $faker->date(),
                    'no_ktp' => $faker->numerify('################'),
                    'status' => $faker->randomElement([
                        'Suami',
                        'Istri',
                        'Lajang',
                        'Duda',
                        'Janda',
                        'Anak',
                        'Family-Lain'
                    ]),
                    'agama' => $faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha', 'Khonghucu']),
                    'pekerjaan' => $faker->jobTitle,
                ]);
            }

            // Buat Nomor Identifikasi
            Nomor::create([
                'kepala_keluarga_id' => $kepalaKeluarga->id,
                'no_pbb' => $faker->numerify('##########'),
                'no_su' => $faker->numerify('##########'),
                'nib' => $faker->numerify('##########'),
            ]);

            // Buat Bantuan
            for ($j = 1; $j <= $faker->numberBetween(1, 3); $j++) {
                Bantuan::create([
                    'kepala_keluarga_id' => $kepalaKeluarga->id,
                    'jenis_bantuan_id' => JenisBantuan::inRandomOrder()->first()->id,
                    'tanggal_diterima' => $faker->date(),
                ]);
            }

            // Buat Batas Bidang Tanah
            BatasBidangTanah::create([
                'kepala_keluarga_id' => $kepalaKeluarga->id,
                'utara' => $faker->randomElement(['Jalan', 'Rumah Tetangga', 'Kebun']),
                'timur' => $faker->randomElement(['Jalan', 'Rumah Tetangga', 'Kebun']),
                'selatan' => $faker->randomElement(['Jalan', 'Rumah Tetangga', 'Kebun']),
                'barat' => $faker->randomElement(['Jalan', 'Rumah Tetangga', 'Kebun']),
            ]);
        }
    }
}
