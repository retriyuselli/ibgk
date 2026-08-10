<?php

namespace Database\Seeders;

use App\Models\OrganizationProfile;
use Illuminate\Database\Seeder;

class OrganizationProfileSeeder extends Seeder
{
    public function run(): void
    {
        OrganizationProfile::query()->updateOrCreate(
            ['short_name' => 'IBGK Sumsel'],
            [
                'name' => 'Ikatan Bujang Gadis Kampus Sumatera Selatan',
                'founded_at' => '1999-08-14',
                'founder' => 'Romi Febriansyah',
                'short_description' => 'Ikatan Bujang Gadis Kampus Sumatera Selatan merupakan wadah pemersatu para alumni dan finalis Pemilihan Bujang Gadis Kampus Sumatera Selatan.',
                'description' => '<p>Ikatan Bujang Gadis Kampus Sumatera Selatan (IBGK Sumsel) didirikan oleh Romi Febriansyah pada tanggal 14 Agustus 1999. Organisasi ini lahir sebagai wadah kebanggaan bagi generasi muda kampus di Sumatera Selatan.</p><p>IBGK Sumsel menjadi pemersatu para alumni dan finalis Pemilihan Bujang Gadis Kampus Sumatera Selatan. Melalui pemilihan, pembinaan, dan jejaring alumni, IBGK Sumsel menumbuhkan semangat muda, berbudaya, berprestasi, dan menginspirasi.</p><p>Dari masa ke masa, IBGK Sumsel terus berkembang bersama mitra pemerintah, perguruan tinggi, dunia usaha, serta masyarakat dalam memperkuat kontribusi generasi muda bagi Sumatera Selatan.</p>',
                'vision' => '<p>Menjadi organisasi pemuda kampus terdepan di Sumatera Selatan yang berbudaya, berprestasi, dan menginspirasi.</p>',
                'mission' => '<ul><li>Menyelenggarakan Pemilihan Bujang Gadis Kampus sebagai ajang pembinaan generasi muda.</li><li>Memperkuat jejaring alumni dan kolaborasi lintas angkatan.</li><li>Melestarikan budaya serta nilai-nilai kearifan lokal Sumatera Selatan.</li><li>Memberikan kontribusi sosial yang bermanfaat bagi masyarakat.</li></ul>',
                'address' => 'Jl. Demang Lebar Daun No. 2845, Palembang, Sumatera Selatan, Indonesia 30137',
                'phone' => '+62 811-7878-2226 / (0711) 573-0123',
                'email' => 'info@ibgksumsel.or.id',
                'website' => 'https://www.ibgksumsel.or.id',
                'instagram' => 'https://instagram.com/ibgksumsel',
                'tiktok' => 'https://tiktok.com/@ibgksumsel',
                'youtube' => 'https://youtube.com/@ibgksumsel',
                'facebook' => 'https://facebook.com/ibgksumsel',
            ]
        );
    }
}
