<?php
/**
 * @author: RunnerLee
 * @email: runnerleer@gmail.com
 * @time: 16-6-3 下午4:55
 */

namespace Runner\ConsistentHash;

use Runner\ConsistentHash\HashAlgorithm\HashAlgorithmInterface;

/**
 * Class ConsistentHash.
 */
class ConsistentHash
{
    /**
     * @var HashAlgorithmInterface
     */
    protected $hashAlgorithm;

    /**
     * @var array
     */
    protected $virtualNodesMap;

    /**
     * @var array
     */
    protected $virtualNodes;

    /**
     * @var int
     */
    protected $virtualNodeTotal;

    /**
     * ConsistentHash constructor.
     *
     * @param array                  $nodes
     * @param HashAlgorithmInterface $hashAlgorithmInterface
     */
    public function __construct(array $nodes, HashAlgorithmInterface $hashAlgorithmInterface)
    {
        $this->hashAlgorithm = $hashAlgorithmInterface;

        $this->buildNodesMap($nodes);
    }

    /**
     * @param string $key
     *
     * @return string
     */
    public function lookup($key)
    {
        $hash = $this->hashAlgorithm->hash($key);

        for ($i = 0; $i < ($this->virtualNodeTotal - 1); ++$i) {
            if ($hash > $this->virtualNodes[$i] && $hash <= $this->virtualNodes[$i + 1]) {
                return $this->virtualNodesMap[$this->virtualNodes[$i + 1]];
            }
        }

        return $this->virtualNodesMap[$this->virtualNodes[0]];
    }

    /**
     * @param array $node
     *
     * @return $this
     */
    protected function buildNodesMap(array $node)
    {
        foreach ($node as $k => $v) {
            if (!isset($v['weight'])) {
                $v['weight'] = 1;
            }
            for ($i = 1; $i <= $v['weight']; ++$i) {
                $this->virtualNodesMap[$this->hashAlgorithm->hash($v['node'].$i)] = $v['node'];
            }
        }
        $this->virtualNodeTotal = count($this->virtualNodesMap);
        $this->virtualNodes = array_keys($this->virtualNodesMap);
        sort($this->virtualNodes);

        return $this;
    }
}
