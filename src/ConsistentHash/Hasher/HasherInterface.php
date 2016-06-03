<?php
/**
 * @author: RunnerLee
 * @email: runnerleer@gmail.com
 * @time: 16-6-3 下午4:56
 */
namespace Runner\ConsistentHash\Hasher;

/**
 * Interface HasherInterface
 * @package Runner\ConsistentHash\Hasher
 */
interface HasherInterface
{

    /**
     * @param string $string
     * @return string
     */
    public function hash($string);

}
