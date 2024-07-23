<?php
return [
    'barrel' => [
        'name' => 'Бочка',
        'chance' => 60,
        'loot' => [
            'exp' => ['min' => 1, 'max' => 5],
            'sewing_kit' => ['min' => 1, 'max' => 3],
            'tarp' => ['min' => 1, 'max' => 3],
            'metal_sheet' => ['min' => 1, 'max' => 3],
            'stone_axe' => ['min' => 1, 'max' => 1, 'chance' => 10],
            'mace' => ['min' => 1, 'max' => 1, 'chance' => 8],
        ]
    ],
    'crate' => [
        'name' => 'Ящик',
        'chance' => 30,
        'loot' => [
            'exp' => ['min' => 6, 'max' => 10],
            'gear' => ['min' => 1, 'max' => 3],
            'spring' => ['min' => 1, 'max' => 3],
            'wooden_bow' => ['min' => 1, 'max' => 1, 'chance' => 15],
            'crossbow' => ['min' => 1, 'max' => 1, 'chance' => 12],
            'revolver' => ['min' => 1, 'max' => 1, 'chance' => 10],
        ]
    ],
    'military_crate' => [
        'name' => 'Военный ящик',
        'chance' => 10,
        'loot' => [
            'exp' => ['min' => 10, 'max' => 20],
            'camera' => ['min' => 1, 'max' => 3],
            'laptop' => ['min' => 1, 'max' => 3],
            'pistol' => ['min' => 1, 'max' => 1, 'chance' => 20],
            'pump_shotgun' => ['min' => 1, 'max' => 1, 'chance' => 15],
            'homemade_rifle' => ['min' => 1, 'max' => 1, 'chance' => 12],
            'thompson' => ['min' => 1, 'max' => 1, 'chance' => 10],
            'smg' => ['min' => 1, 'max' => 1, 'chance' => 8],
        ]
    ],
];
