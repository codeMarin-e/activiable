<?php
    namespace Marinar\Activiable\Database\Seeders;

    use Illuminate\Database\Seeder;
    use Marinar\Activiable\MarinarActiviable;

    class MarinarActiviableInstallSeeder extends Seeder {

        use \Marinar\Marinar\Traits\MarinarSeedersTrait;

        public static function configure() {
            static::$packageName = 'marinar_activiable';
            static::$packageDir = MarinarActiviable::getPackageMainDir();
        }

        public function run() {
            if(!in_array(env('APP_ENV'), ['dev', 'local'])) return;

            $this->autoInstall();

            $this->refComponents->info("Done!");
        }

    }
