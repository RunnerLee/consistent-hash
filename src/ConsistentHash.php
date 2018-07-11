<?php
/**
 * @author: RunnerLee
 * @email: runnerleer@gmail.com
 * @time: 16-6-3 下午4:55
 */

namespace Runner\ConsistentHash;

use Runner\ConsistentHash\Algorithms\HashAlgorithmInterface;

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
     * @param array $nodes
     * @param HashAlgorithmInterface $algorithm
     */
    public function __construct(array $nodes, HashAlgorithmInterface $algorithm)
    {
        $this->algorithm = $algorithm;

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

        for ($i = 0; $i < ($this->nodesCount - 1); $i++) {
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
            for ($i = 1; $i <= $v['weight']; $i++) {
                $this->resourceNodes[$this->algorithm->hash($v['node'].$i)] = $v;
            }
        }
        $this->nodesCount = count($this->resourceNodes);
        $this->nodes = array_keys($this->resourceNodes);
        sort($this->nodes);

        return $this;
    }
}
