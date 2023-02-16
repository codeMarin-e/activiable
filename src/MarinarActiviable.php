<?php
    namespace Marinar\Activiable;

    use Marinar\Activiable\Database\Seeders\MarinarActiviableInstallSeeder;

    class MarinarActiviable {

        public static function getPackageMainDir() {
            return __DIR__;
        }

        public static function injects() {
            return MarinarActiviableInstallSeeder::class;
        }
    }
