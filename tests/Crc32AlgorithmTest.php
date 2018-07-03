<?php
/**
 * @author: RunnerLee
 * @email: runnerleer@gmail.com
 * @time: 17-2-11 10:54
 */

namespace Runner\ConsistentHash\Tests;

use Runner\ConsistentHash\Algorithms\Crc32Algorithm;

class Crc32AlgorithmTest extends \PHPUnit_Framework_TestCase
{
    public function testHash()
    {
        $this->assertEquals(2286445522, (new Crc32Algorithm())->hash('123'));
    }
}
