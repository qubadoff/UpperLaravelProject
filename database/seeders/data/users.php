<?php

declare(strict_types=1);

return [
    [
        'uid' => 12345678,
        'name' => 'Orkhan',
        'surname' => 'Shukurlu',
        'image' => '644ebfe487179.png',
        'birthdate' => '1997-11-04',
        'phone' => 994773339800,
        'password' => bcrypt('upper12345'),
        'type' => 1,
    ],
    [
        'uid' => 87654321,
        'name' => 'Mehdi',
        'surname' => 'Aliyev',
        'image' => null,
        'birthdate' => '2000-01-01',
        'phone' => 994708156559,
        'password' => bcrypt('upper12345'),
        'type' => 0,
    ],
];
