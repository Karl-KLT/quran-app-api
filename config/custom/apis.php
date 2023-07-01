<?php


return [
    'UserRoute' => [
        '[prefix]User/' => [
            '[post]createUser',
            '[post]updateUser',
        ]
    ],

    'QuranRoute' => [
        '[prefix]Quran/' => [
            '[get]getAll',
            '[get]getSurah/{numberOfSurah}',
        ]
    ]
];
