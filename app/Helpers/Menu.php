<?php
namespace App\Helpers;

class Menu
{
    public static function main() 
    {
        return [
            self::library(),
            [
                'name' => 'Account',
                'sub-menu'=>[
                    ['name' => 'Help',  'route'=> 'help'],
                    ['name' => 'Upgrade','route'=> 'upgrade'],
                    ['name' => 'Settings','route'=> 'settings'],
                ]
            ],
        ];
    }
    public static function library()
    {
        return [
                'name' => 'Library',
                'sub-menu'=>[
                    ['name' => 'Projects', 'route'=> 'projects'],
                    ['name' => 'Favourites','route'=> 'favourites'],
                    ['name' => 'Shared with me','route'=> 'sharedwithme'],
                ]

                ];
    }
    public static function tile() 
    {
        return [
            self::library(),
            [
                'name' => 'Workspace',
                'sub-menu'=>[
                    [
                        'name' => 'Project Overview', 
                        'route' => 'projects',                    
                        'sub-menu'=>[
                            ['name' => 'Idea Space','route' => 'ideas'],
                            ['name' => 'Customers','route' => 'customers'],
                            ['name' => 'Problems','route' => 'problems'],
                            ['name' => 'Solutions','route' => 'solutions'],
                            ['name' => 'Prototype','route' => 'prototypes'],
                            ['name' => 'Existing Alternatives','route' => 'alternatives'],
                            ['name' => 'Business Analysis','route' => 'businesses'],
                            ['name' => 'Customer Interview','route' => 'customerinterview'],                            
                            ['name' => 'Sentiment Analysis','route' => 'audioanalyses'],
                            ['name' => 'Project Export','route' => 'projectexport'],
                        ]
                    ],
                   
                ]
            ],
        ];
    }
}