<?php
/**
 * @author: RunnerLee
 * @email: runnerleer@gmail.com
 * @time: 17-2-11 10:57
 */

namespace Runner\ConsistentHash\Tests;

use Runner\ConsistentHash\ConsistentHash;
use Runner\ConsistentHash\HashAlgorithm\Crc32Algorithm;

class ConsistentHashTest extends \PHPUnit_Framework_TestCase
{
    public function testHash()
    {
        $hash = new ConsistentHash([
            [
                'node'   => 'node_1',
                'weight' => 1,
            ],
            [
                'node'   => 'node_2',
                'weight' => 3,
            ],
            [
                'node'   => 'node_3',
                'weight' => 1,
            ],
            [
                'node'   => 'node_4',
                'weight' => 1,
            ],
            [
                'node'   => 'node_5',
                'weight' => 1,
            ],
        ], new Crc32Algorithm());

        $hash->lookup('123');
    }
}
