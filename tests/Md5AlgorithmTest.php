<?php
/**
 * @author: RunnerLee
 * @email: runnerleer@gmail.com
 * @time: 17-2-11 10:55
 */
namespace Runner\ConsistentHash\Tests;

use Runner\ConsistentHash\HashAlgorithm\Md5Algorithm;

class Md5AlgorithmTest extends \PHPUnit_Framework_TestCase
{

    public function testMd5()
    {
        (new Md5Algorithm())->hash('123');
    }

}
