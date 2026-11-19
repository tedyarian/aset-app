<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Asset\Models\BmnItem;
use Illuminate\Support\Facades\File;

class BmnItemSeeder extends Seeder
{
    public function run(): void
    {
        // Cari file CSV di direktori proyek
        $path = database_path('seeders/AsetBMN.csv');
        if (!File::exists($path)) {
            $path = module_path('Asset', 'database/seeders/AsetBMN.csv');
        }

        if (!File::exists($path)) {
            throw new \Exception("File AsetBMN.csv tidak ditemukan di path: " . $path);
        }

        $file = fopen($path, 'r');
        
        // Deteksi otomatis delimiter (apakah koma ',' atau titik koma ';')
        $firstLine = fgets($file);
        rewind($file);
        $delimiter = (substr_count($firstLine, ';') > substr_count($firstLine, ',')) ? ';' : ',';

        $isHeader = true;
        $batchData = [];
        $counter = 0;

        while (($row = fgetcsv($file, 2000, $delimiter)) !== false) {
            // Lewati baris judul (header)
            if ($isHeader) {
                $isHeader = false;
                continue;
            }

            // Debug baris pertama yang dibaca (buka komentar di bawah jika masih kosong untuk melihat isinya)
            /*
            if ($counter === 0) {
                dd($row); // Akan menampilkan isi kolom baris pertama di layar terminal Anda
            }
            */

            // Ambil kolom (Pastikan urutan indeks sesuai dengan file CSV Anda)
            $gol    = trim($row[0] ?? '');
            $bid    = trim($row[1] ?? '');
            $kel    = trim($row[2] ?? '');
            $subKel = trim($row[3] ?? '');
            $subSubKel = trim($row[4] ?? '');
            $sat    = trim($row[5] ?? '');
            $name   = trim($row[6] ?? '');

            // Abaikan jika baris kosong
            if (empty($name) || $name === 'URAIAN' || $gol === 'GOL') {
                continue;
            }

            // Susun format kode lengkap
            $code = sprintf(
                '%s.%s.%s.%s.%s',
                $gol !== '' ? $gol : '0',
                $bid !== '' ? $bid : '0',
                $kel !== '' ? $kel : '0',
                $subKel !== '' ? $subKel : '0',
                $subSubKel !== '' ? $subSubKel : '0'
            );

            $batchData[] = [
                'gol'         => $gol,
                'bid'         => $bid,
                'kel'         => $kel,
                'sub_kel'     => $subKel,
                'sub_sub_kel' => $subSubKel,
                'code'        => $code,
                'sat'         => $sat,
                'name'        => $name,
                'created_at'  => now(),
                'updated_at'  => now(),
            ];

            $counter++;

            // Masukkan ke database per 500 baris
            if (count($batchData) >= 500) {
                foreach ($batchData as $data) {
                    BmnItem::updateOrCreate(['code' => $data['code']], $data);
                }
                $batchData = [];
            }
        }

        fclose($file);

        // Masukkan sisa data terakhir
        if (!empty($batchData)) {
            foreach ($batchData as $data) {
                BmnItem::updateOrCreate(['code' => $data['code']], $data);
            }
        }

        $this->command->info("Berhasil mengimpor {$counter} data BMN ke database!");
    }
}