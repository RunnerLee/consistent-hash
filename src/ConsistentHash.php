<?php
/**
 * @author: RunnerLee
 * @email: runnerleer@gmail.com
 * @time: 16-6-3 下午4:55
 */

namespace Runner\ConsistentHash;

use InvalidArgumentException;
use Runner\ConsistentHash\Algorithms\Crc32Algorithm;
use Runner\ConsistentHash\Algorithms\HashAlgorithmInterface;
use Runner\ConsistentHash\Algorithms\Md5Algorithm;

/**
 * Class ConsistentHash.
 */
class ConsistentHash
{
    /**
     * @var HashAlgorithmInterface
     */
    protected $algorithm;

    /**
     * @var array
     */
    protected $resourceNodes;

    /**
     * @var array
     */
    protected $nodes;

    /**
     * @var int
     */
    protected $nodesCount;

    /**
     * ConsistentHash constructor.
     *
     * @param array  $nodes
     * @param string $algorithm
     */
    public function __construct(array $nodes, $algorithm)
    {
        $this->algorithm = $this->getAlgorithm($algorithm);

        $this->formatNodes($nodes);
    }

    /**
     * @param string $key
     *
     * @return array
     */
    public function lookup($key)
    {
        $hash = $this->algorithm->hash($key);

        for ($i = 0; $i < ($this->nodesCount - 1); ++$i) {
            if ($hash > $this->nodes[$i] && $hash <= $this->nodes[$i + 1]) {
                return $this->resourceNodes[$this->nodes[$i + 1]];
            }
        }

        return $this->resourceNodes[$this->nodes[0]];
    }

    /**
     * @param array $node
     *
     * @return $this
     */
    protected function formatNodes(array $node)
    {
        foreach ($node as $k => $v) {
            if (!isset($v['weight'])) {
                $v['weight'] = 1;
            }
            for ($i = 1; $i <= $v['weight']; ++$i) {
                $this->resourceNodes[$this->algorithm->hash($v['node'].$i)] = $v;
            }
        }
        $this->nodesCount = count($this->resourceNodes);
        $this->nodes = array_keys($this->resourceNodes);
        sort($this->nodes);

        return $this;
    }

    /**
     * @param $algorithm
     *
     * @return HashAlgorithmInterface
     */
    protected function getAlgorithm($algorithm)
    {
        switch ($algorithm) {
            case 'md5':
                return new Md5Algorithm();
            case 'crc32':
                return new Crc32Algorithm();
        }
        throw new InvalidArgumentException('algorithm not supported');
    }
}
