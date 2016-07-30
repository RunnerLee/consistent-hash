# consistent-hash

一致性哈希分表

## 抄的
权重的实现方法是抄的，其他地方也多多少少抄了些。
比较大的区别就是，我把环形空间上的每个节点，无论是节点本身还是虚拟节点，均视为虚拟节点。并记录虚拟节点同真实节点的映射关系。
因此，最终计算出来的，只能有一个目标节点。

总得来说，对这个东西还是一知半解，玩玩看哈。

## 使用

```
use Runner\ConsistentHash\ConsistentHash;

$hash = new ConsistentHash([
        [
            'node' => 'node_1',
        ],
        [
            'node' => 'node_2',
            'weight' => 2,
        ],
        [
            'node' => 'node_3',
            'weight' => 3,
        ],
        [
            'node' => 'node_4',
            'weight' => 4,
        ],
        [
            'node' => 'node_5',
            'weight' => 5,
        ],
], new \Runner\ConsistentHash\HashAlgorithm\Crc32Algorithm());

$target = $hash->loopup('RUNNERLEER');

```

## TODO
还不知道这个权重的实现方法靠不靠谱

## 参考
[https://github.com/pda/flexihash](https://github.com/pda/flexihash)

[http://blog.codinglabs.org/articles/consistent-hashing.html](http://blog.codinglabs.org/articles/consistent-hashing.html)