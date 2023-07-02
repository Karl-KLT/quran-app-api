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
            '[get]getAllPersonTafir',
            '[get]getAllPersonAudio',


            '[get]getSurah/{numberOfSurah}',
            '[get]getTafsir/{numberOfSurah}/{idOfPerson}',
            '[get]getAudio/{numberOfSurah}/{idOfPerson}',

            
        ]
    ]
];
