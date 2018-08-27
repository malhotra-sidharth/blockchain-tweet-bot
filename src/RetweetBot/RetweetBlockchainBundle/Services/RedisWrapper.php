<?php


namespace RetweetBot\RetweetBlockchainBundle\Services;


use Symfony\Component\Cache\Adapter\RedisAdapter;
use Symfony\Component\Cache\CacheItem;
use Symfony\Component\Config\Definition\Exception\Exception;

class RedisWrapper {

  /**
   * @var string
   */
  private $redisAddress;

  /**
   * @var RedisAdapter
   */
  private $redisCache;

  /**
   * RedisWrapper constructor.
   * @param string $address
   */
  public function __construct(string $address) {
    $this->redisAddress = $address;
    $this->getConnection();
  }

  /**
   * Creates a connection to redis server and returns the cache connection
   * This connection inserts 'blockchain-' prefix to all the keys by default
   */
  public function getConnection() {
    // Get a Redis class connection
    $connection = RedisAdapter::createConnection(
        $this->redisAddress
    );

    try {
      $this->redisCache = new RedisAdapter($connection, 'blockchain', (24 * 60 * 60));
    } catch (Exception $e) {
      print($e->getMessage());
      die();
    }
  }

  /**
   * Checks if the cache has the given key or not
   *
   * @param int $key
   * Key to be checked for in the cache
   *
   * @return bool
   * TRUE if the given key is in cache else false
   */
  public function hasItem(int $key): bool {
    return $this->redisCache->hasItem("blockchain" . $key);
  }

  /**
   * Checks if the given keys exits in cache, if not adds it else
   * does nothing and returns False
   *
   * @param int $key
   * key to be added to the cache
   *
   * @return bool
   * True if key is added to the cache else false
   */
  public function putItem(int $key): bool {
    $cacheKey = $this->redisCache->getItem((string)$key);

    if (false === $cacheKey->isHit()) {
      $cacheKey->set(true);
      return $this->redisCache->save($cacheKey);
    }

    return false;
  }
}