<?php
/**
 * @author: RunnerLee
 * @email: runnerleer@gmail.com
 * @time: 16-7-30 下午11:01
 */

namespace Runner\ConsistentHash\HashAlgorithm;

class Md5Algorithm implements HashAlgorithmInterface
{
    /**
     * @param string $string
     *
     * @return string
     */
    public function hash($string)
    {
        return hexdec(substr(md5($string), 8, 16));
    }
}
