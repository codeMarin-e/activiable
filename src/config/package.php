<?php
	return [
		'install' => [
            'php artisan db:seed --class="\Marinar\Activiable\Database\Seeders\MarinarActiviableInstallSeeder"',
		],
        'remove' => [
            'php artisan db:seed --class="\Marinar\Activiable\Database\Seeders\MarinarActiviableRemoveSeeder"',
        ]
	];
