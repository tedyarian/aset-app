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
        $path = module_path('Asset', 'database\seeders\AsetBMN.csv');
        if (!File::exists($path)) {
            $path = database_path('seeders/asetBMN.csv');
        }
        var_dump($path); die;

        if (File::exists($path)) {
            // Gunakan pembacaan baris demi baris agar aman untuk data besar
            $file = fopen($path, 'r');
            $isHeader = true;
            $batchData = [];

            while (($row = fgetcsv($file, 1000, ',')) !== false) {
                // Lewati baris judul (header) di file CSV
                if ($isHeader) {
                    $isHeader = false;
                    continue;
                }

                // Ambil kolom: [0]=GOL, [1]=BID, [2]=KEL, [3]=SUB KEL, [4]=SUB-SUB KEL, [5]=URAIAN/Nama
                $gol = trim($row[0] ?? '');
                $bid = trim($row[1] ?? '');
                $kel = trim($row[2] ?? '');
                $subKel = trim($row[3] ?? '');
                $subSubKel = trim($row[4] ?? '');
                $sat =trim($row[5] ?? '');
                $name = trim($row[6] ?? '');

                // Abaikan jika baris kosong atau judul kolom berulang
                if (empty($name) || $name === 'URAIAN' || $gol === 'GOL') {
                    continue;
                }

                // Susun format kode lengkap (Gol.Bid.Kel.Sub_Kel.Sub_Sub_Kel)
                $code = sprintf(
                    '%s.%s.%s.%s.%s',
                    $gol !== '' ? $gol : '0',
                    $bid !== '' ? $bid : '0',
                    $kel !== '' ? $kel : '0',
                    $subKel !== '' ? $subKel : '0',
                    $subSubKel !== '' ? $subSubKel : '0'
                );

                $batchData[] = [
                    'gol' => $gol,
                    'bid' => $bid,
                    'kel' => $kel,
                    'sub_kel' => $subKel,
                    'sub_sub_kel' => $subSubKel,
                    'code' => $code,
                    'sat'=>$sat,
                    'name' => $name,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                // Masukkan ke database per 500 baris agar memori efisien
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

            echo "Data BMN berhasil diimpor ke database!\n";
        } else {
            echo "File aset_bmn.csv tidak ditemukan di direktori!\n";
        }
    }
}