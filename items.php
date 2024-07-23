<?php
return [
    // Существующие ресурсы
    'exp' => ['name' => 'Очки опыта', 'type' => 'resource'],
    'sewing_kit' => ['name' => 'Швейный набор', 'type' => 'resource'],
    'tarp' => ['name' => 'Брезент', 'type' => 'resource'],
    'metal_sheet' => ['name' => 'Лист металла', 'type' => 'resource'],
    'gear' => ['name' => 'Шестеренка', 'type' => 'resource'],
    'spring' => ['name' => 'Пружина', 'type' => 'resource'],
    'camera' => ['name' => 'Камера', 'type' => 'resource'],
    'laptop' => ['name' => 'Ноутбук', 'type' => 'resource'],

    // Оружие низкого уровня
    'stone_axe' => [
        'name' => 'Каменный топор',
        'type' => 'weapon',
        'level' => 'low',
        'damage' => 5,
        'durability' => 20,
    ],
    'mace' => [
        'name' => 'Булава',
        'type' => 'weapon',
        'level' => 'low',
        'damage' => 7,
        'durability' => 25,
    ],
    'wooden_bow' => [
        'name' => 'Деревянный лук',
        'type' => 'weapon',
        'level' => 'low',
        'damage' => 8,
        'durability' => 30,
    ],
    'crossbow' => [
        'name' => 'Арбалет',
        'type' => 'weapon',
        'level' => 'low',
        'damage' => 10,
        'durability' => 35,
    ],
    'revolver' => [
        'name' => 'Револьвер',
        'type' => 'weapon',
        'level' => 'low',
        'damage' => 12,
        'durability' => 40,
    ],

    // Оружие высокого уровня
    'pistol' => [
        'name' => 'Пистолет',
        'type' => 'weapon',
        'level' => 'high',
        'damage' => 15,
        'durability' => 45,
    ],
    'pump_shotgun' => [
        'name' => 'Помповый дробовик',
        'type' => 'weapon',
        'level' => 'high',
        'damage' => 20,
        'durability' => 40,
    ],
    'homemade_rifle' => [
        'name' => 'Самодельная винтовка',
        'type' => 'weapon',
        'level' => 'high',
        'damage' => 18,
        'durability' => 35,
    ],
    'thompson' => [
        'name' => 'Автомат Томпсона',
        'type' => 'weapon',
        'level' => 'high',
        'damage' => 22,
        'durability' => 50,
    ],
    'smg' => [
        'name' => 'СМГ',
        'type' => 'weapon',
        'level' => 'high',
        'damage' => 25,
        'durability' => 55,
    ],

    // Оружие экстра уровня (недоступно при исследовании)
    'ak47' => [
        'name' => 'Автомат Калашникова',
        'type' => 'weapon',
        'level' => 'extra',
        'damage' => 30,
        'durability' => 60,
    ],
    'sniper_rifle' => [
        'name' => 'Снайперская винтовка',
        'type' => 'weapon',
        'level' => 'extra',
        'damage' => 35,
        'durability' => 50,
    ],
    'lr300' => [
        'name' => 'LR-300',
        'type' => 'weapon',
        'level' => 'extra',
        'damage' => 28,
        'durability' => 55,
    ],

    // Валюта
    'rustcoin' => ['name' => 'RustCoin', 'type' => 'currency'],
];
