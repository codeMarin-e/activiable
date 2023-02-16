<?php
namespace Marinar\Activiable\Database\Seeders;

use Illuminate\Database\Seeder;
use Marinar\Activiable\MarinarActiviable;
use Spatie\Permission\Models\Permission;

class MarinarActiviableRemoveSeeder extends Seeder {

    use \Marinar\Marinar\Traits\MarinarSeedersTrait;

    public static function configure() {
        static::$packageName = 'marinar_activiable';
        static::$packageDir = MarinarActiviable::getPackageMainDir();
    }

    public function run() {
        if(!in_array(env('APP_ENV'), ['dev', 'local'])) return;

        $this->autoRemove();

        $this->refComponents->info("Done!");
    }
}
