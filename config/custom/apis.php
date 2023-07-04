<?php


return [
    'AuthRoute' => [


        '[prefix]Tokens/' => [
            '[post]createUser',
            '[post]updateUser',
        ],

        '[prefix]Accounts/' => [
            '[post]**********',
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
