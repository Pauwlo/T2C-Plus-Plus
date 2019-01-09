<?php

class Endpoint
{
    private const ENDPOINTS = [
        'Les Vergnes' => [
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015496260&rn=10&lineid=11821953316814895&of=xml',
            null
        ],
        'Stage G. Montpied' => [
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015496485&rn=10&lineid=11821953316814895&of=xml',
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015496486&rn=10&lineid=11821953316814895&of=xml'
        ],
        'La Plaine' => [
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015496016&rn=10&lineid=11821953316814895&of=xml',
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015496018&rn=10&lineid=11821953316814895&of=xml'
        ],
        'Champratel' => [
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015495356&rn=10&lineid=11821953316814895&of=xml',
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015496482&rn=10&lineid=11821953316814895&of=xml'
        ],
        'Croix de Neyrat' => [
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015495505&rn=10&lineid=11821953316814895&of=xml',
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015496440&rn=10&lineid=11821953316814895&of=xml'
        ],
        'Hauts de Chanturgue' => [
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015495697&rn=10&lineid=11821953316814895&of=xml',
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015495699&rn=10&lineid=11821953316814895&of=xml'
        ],
        'Collège A. Camus' => [
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015495453&rn=10&lineid=11821953316814895&of=xml',
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015495454&rn=10&lineid=11821953316814895&of=xml'
        ],
        'Les Vignes' => [
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015496269&rn=10&lineid=11821953316814895&of=xml',
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015496271&rn=10&lineid=11821953316814895&of=xml'
        ],
        'Lycée A. Brugière' => [
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015495817&rn=10&lineid=11821953316814895&of=xml',
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015495819&rn=10&lineid=11821953316814895&of=xml'
        ],
        'Les Pistes' => [
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015496012&rn=10&lineid=11821953316814895&of=xml',
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015496014&rn=10&lineid=11821953316814895&of=xml'
        ],
        'Musée d\'Art Roger Quilliot' => [
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015495921&rn=10&lineid=11821953316814895&of=xml',
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015495924&rn=10&lineid=11821953316814895&of=xml'
        ],
        'Montferrand La Fontaine' => [
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015495905&rn=10&lineid=11821953316814895&of=xml',
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015495906&rn=10&lineid=11821953316814895&of=xml'
        ],
        'Gravière' => [
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015495691&rn=10&lineid=11821953316814895&of=xml',
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015495692&rn=10&lineid=11821953316814895&of=xml'
        ],
        'Stade M. Michelin' => [
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015496210&rn=10&lineid=11821953316814895&of=xml',
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015496212&rn=10&lineid=11821953316814895&of=xml'
        ],
        '1er Mai' => [
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015496080&rn=10&lineid=11821953316814895&of=xml',
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015496082&rn=10&lineid=11821953316814895&of=xml'
        ],
        'Les Carmes' => [
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015495321&rn=10&lineid=11821953316814895&of=xml',
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015495323&rn=10&lineid=11821953316814895&of=xml'
        ],
        'Delille Montlosier' => [
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015495530&rn=10&lineid=11821953316814895&of=xml',
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015495533&rn=10&lineid=11821953316814895&of=xml'
        ],
        'Hôtel de Ville' => [
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015495709&rn=10&lineid=11821953316814895&of=xml',
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015495710&rn=10&lineid=11821953316814895&of=xml'
        ],
        'Gaillard' => [
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015495639&rn=10&lineid=11821953316814895&of=xml',
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015495642&rn=10&lineid=11821953316814895&of=xml'
        ],
        'Jaude' => [
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015495730&rn=10&lineid=11821953316814895&of=xml',
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015495732&rn=10&lineid=11821953316814895&of=xml'
        ],
        'Lagarlaye' => [
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015495762&rn=10&lineid=11821953316814895&of=xml',
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015495763&rn=10&lineid=11821953316814895&of=xml'
        ],
        'Maison de la Culture' => [
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015495836&rn=10&lineid=11821953316814895&of=xml',
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015495838&rn=10&lineid=11821953316814895&of=xml'
        ],
        'Universités' => [
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015496253&rn=10&lineid=11821953316814895&of=xml',
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015496255&rn=10&lineid=11821953316814895&of=xml'
        ],
        'St Jacques Dolet' => [
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015496192&rn=10&lineid=11821953316814895&of=xml',
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015496193&rn=10&lineid=11821953316814895&of=xml'
        ],
        'CHU G. Montpied' => [
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015495399&rn=10&lineid=11821953316814895&of=xml',
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015495401&rn=10&lineid=11821953316814895&of=xml'
        ],
        'St Jacques Loucheur' => [
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015496194&rn=10&lineid=11821953316814895&of=xml',
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015496196&rn=10&lineid=11821953316814895&of=xml'
        ],
        'Léon Blum' => [
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015495777&rn=10&lineid=11821953316814895&of=xml',
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015495778&rn=10&lineid=11821953316814895&of=xml'
        ],
        'La Chaux' => [
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015495369&rn=10&lineid=11821953316814895&of=xml',
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015495370&rn=10&lineid=11821953316814895&of=xml'
        ],
        'Cézeaux Pellez' => [
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015495338&rn=10&lineid=11821953316814895&of=xml',
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015495339&rn=10&lineid=11821953316814895&of=xml'
        ],
        'Campus' => [
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015495319&rn=10&lineid=11821953316814895&of=xml',
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015495320&rn=10&lineid=11821953316814895&of=xml'
        ],
        'Margeride' => [
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015495859&rn=10&lineid=11821953316814895&of=xml',
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015495861&rn=10&lineid=11821953316814895&of=xml'
        ],
        'Fontaine du Bac' => [
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015495608&rn=10&lineid=11821953316814895&of=xml',
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015495610&rn=10&lineid=11821953316814895&of=xml'
        ],
        'Lycée Lafayette' => [
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015495821&rn=10&lineid=11821953316814895&of=xml',
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015495823&rn=10&lineid=11821953316814895&of=xml'
        ],
        'La Pardieu Gare' => [
            null,
            'http://t2c-prod.rcsmobility.com/synthese?SERVICE=tdg&roid=3377704015495958&rn=10&lineid=11821953316814895&of=xml'
        ]
    ];

    public static function getEndpoint(string $stop, string $direction) : string
    {
        if ($direction == 'La Pardieu Gare') {
            $direction = 0;
        } elseif ($direction == 'Les Vergnes') {
            $direction = 1;
        }
        
        return self::ENDPOINTS[$stop][$direction];
    }

    public static function stopExists(string $stop) : bool
    {
        return array_key_exists($stop, self::ENDPOINTS);
    }

    public static function directionExists(string $direction) : bool
    {
        $directions = [
            'Les Vergnes',
            'La Pardieu Gare'
        ];

        return in_array($direction, $directions);
    }
}
