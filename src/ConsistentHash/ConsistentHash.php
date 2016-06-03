<?php
/**
 * @author: RunnerLee
 * @email: runnerleer@gmail.com
 * @time: 16-6-3 下午4:55
 */
namespace Runner\ConsistentHash;

use Runner\ConsistentHash\Hasher\HasherInterface;

/**
 * Class ConsistentHash
 * @package Runner\ConsistentHash
 */
class ConsistentHash
{

    /**
     * @var
     */
    protected $hasher;

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
     * @param array $nodes
     * @param HasherInterface $hasherInterface
     */
    public function __construct(array $nodes, HasherInterface $hasherInterface)
    {
        $this->hasher = $hasherInterface;

        $this->buildNodesMap($nodes);
    }


    /**
     * @param $key
     * @return string
     */
    public function lookup($key)
    {
        $hash = $this->hasher->hash($key);

        if(isset($this->virtualNodes[$hash])) {
            return $this->virtualNodesMap[$this->virtualNodes[$hash]];
        }
        if($hash <= $this->virtualNodes[0]) {
            return $this->virtualNodesMap[$this->virtualNodes[0]];
        }
        if($hash > $this->virtualNodes[$this->virtualNodeTotal - 1]) {
            return $this->virtualNodesMap[$this->virtualNodes[0]];
        }

        for($i = 0; $i < $this->virtualNodeTotal; ++$i) {
            if($hash > $this->virtualNodes[$i] && $hash < $this->virtualNodes[$i + 1]) {
                return $this->virtualNodesMap[$this->virtualNodes[$i + 1]];
            }
        }
    }


    /**
     * @param array $node
     * @return $this
     */
    protected function buildNodesMap(array $node)
    {
        foreach($node as $k => $v) {
            if(!isset($v['weight'])) {
                $v['weight'] = 1;
            }

            for($i = 1; $i <= $v['weight']; ++$i) {
                $this->virtualNodesMap[$this->hasher->hash($v['node'] . $i)] = $v['node'];
            }
        }

        $this->virtualNodeTotal = count($this->virtualNodesMap);
        $this->virtualNodes = array_keys($this->virtualNodesMap);
        sort($this->virtualNodes);

        return $this;
    }
}
