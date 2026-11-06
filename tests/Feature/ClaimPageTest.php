<?php

namespace Tests\Feature;

use App\Models\Claim;
use Database\Seeders\ClaimSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClaimPageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(ClaimSeeder::class);
    }

    public function test_halaman_klaim_masuk_menampilkan_enam_pengajuan(): void
    {
        $response = $this->get('/');

        $response->assertOk()
            ->assertSee('Klaim Masuk')
            ->assertSee('Selamat Datang, SDN 1 Dayeuhkolot')
            ->assertSee('Nasi Ayam Box')
            ->assertSee('Roti Assorted')
            ->assertSee('Paket Makan')
            ->assertSee('Sayur Capcay')
            ->assertSee('Nasi Kotak')
            ->assertSee('Roti Tawar')
            ->assertSee('Menampilkan 6 klaim dari total 18 pengajuan bulan ini')
            ->assertSee('Halaman 1 dari 10');
    }

    public function test_ringkasan_statistik_mengikuti_data_klaim(): void
    {
        $response = $this->get('/');

        $response->assertViewHas('stats', fn (array $stats) => $stats === [
            'waiting' => 2,
            'approved' => 2,
            'total' => 6,
        ]);
    }

    public function test_filter_status_menunggu_hanya_menampilkan_klaim_menunggu(): void
    {
        $response = $this->get('/?status=menunggu');

        $response->assertOk()
            ->assertSee('Nasi Ayam Box')
            ->assertSee('Roti Assorted')
            ->assertDontSee('Roti Tawar');
    }

    public function test_pencarian_mencocokkan_nama_makanan(): void
    {
        $response = $this->get('/?q=capcay');

        $response->assertOk()
            ->assertSee('Sayur Capcay')
            ->assertDontSee('Nasi Ayam Box');
    }

    public function test_filter_metode_kurir_online(): void
    {
        $response = $this->get('/?method='.Claim::METHOD_KURIR_ONLINE);

        $response->assertOk()
            ->assertSee('Roti Assorted')
            ->assertSee('Sayur Capcay')
            ->assertDontSee('Nasi Ayam Box');
    }
}
