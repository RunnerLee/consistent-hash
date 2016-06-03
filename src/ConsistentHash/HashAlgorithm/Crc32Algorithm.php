<?php
/**
 * @author: RunnerLee
 * @email: runnerleer@gmail.com
 * @time: 16-6-3 下午5:54
 */
namespace Runner\ConsistentHash\HashAlgorithm;

/**
 * Class Crc32Hasher
 * @package Runner\ConsistentHash\HashAlgorithm
 */
class Crc32Algorithm implements HashAlgorithmInterface
{

    /**
     * @param string $string
     * @return string
     */
    public function hash($string)
    {
        return crc32($string);
    }
}
