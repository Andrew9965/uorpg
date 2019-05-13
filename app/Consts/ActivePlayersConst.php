<?php

namespace App\Consts;

class ActivePlayersConst {

    //Lang group: ActivePlayers
    const PARTIES = [
        0 => 'renegaty',
        1 => 'svyashchennaya_imperiya',
        2 => 'povstantsy',
        3 => 'armiya_tmy',
        4 => 'teni'
    ];

    const CLASSES = [
        1 => "knights",
        2 => "archers",
        3 => "mages",
        4 => "craftsmen",
        5 => "paladins",
        6 => "assassins",
        7 => "vampires",
        8 => "necromancers"
    ];

    public static function classes($id){
        if(!isset(self::CLASSES[$id]))
            throw new \Exception('Class ID: '.$id.', not found!');

        $key = self::CLASSES[$id];

        return trans("ActivePlayers.".$key);
    }

    public static function partie($id)
    {
        if(!isset(self::PARTIES[$id]))
            throw new \Exception('Parties ID: '.$id.', not found!');

        $key = self::PARTIES[$id];

        return [
            'title' => trans("ActivePlayers.".$key),
            'color' => config('active_player.color.'.$key)
        ];
    }

}