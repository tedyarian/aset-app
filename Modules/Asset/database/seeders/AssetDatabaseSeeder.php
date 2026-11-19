<?php

<?php

namespace Modules\Asset\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class AssetDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Model::unguard();

        // Panggil seeder BMN di sini
        $this->call([
            BmnItemSeeder::class,
        ]);
    }
}