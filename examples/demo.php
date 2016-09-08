<?php
/**
 * @author: RunnerLee
 * @email: runnerleer@gmail.com
 * @time: 16-6-3 下午5:50
 */
require __DIR__ . '/../vendor/autoload.php';

$hash = new \Runner\ConsistentHash\ConsistentHash([
    [
        'node' => 'node_1',
        'weight' => 1,
    ],
    [
        'node' => 'node_2',
        'weight' => 3,
    ],
    [
        'node' => 'node_3',
        'weight' => 1,
    ],
    [
        'node' => 'node_4',
        'weight' => 1,
    ],
    [
        'node' => 'node_5',
        'weight' => 1,
    ],
], new \Runner\ConsistentHash\HashAlgorithm\Crc32Algorithm());

$arr = [
    $hash->lookup('6d5dfe6f9e23ff6d9584360dc9ddcae0'),
    $hash->lookup('ZW1464926867RN62664'),
    $hash->lookup('ZW1464924704RN71750'),
    $hash->lookup('aca79a4cec4b26d481218050daf497c5'),
    $hash->lookup('ZW1464854344RN61319'),
    $hash->lookup('ZW1464882468RN28574'),
];

print_r($arr);