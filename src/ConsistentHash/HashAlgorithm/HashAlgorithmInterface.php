<?php
/**
 * @author: RunnerLee
 * @email: runnerleer@gmail.com
 * @time: 16-6-3 下午4:56
 */
namespace Runner\ConsistentHash\HashAlgorithm;

/**
 * Interface HasherInterface
 * @package Runner\ConsistentHash\HashAlgorithm
 */
interface HashAlgorithmInterface
{

    /**
     * @param string $string
     * @return string
     */
    public function hash($string);

}
