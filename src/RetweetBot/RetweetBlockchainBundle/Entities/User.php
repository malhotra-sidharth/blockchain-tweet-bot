<?php


namespace RetweetBot\RetweetBlockchainBundle\Entities;


class User {

  /**
   * @var int
   */
  private $id;

  /**
   * User constructor.
   * @param object $user
   */
  public function __construct(object $user) {
    $this->id = $user->id;
  }

  /**
   * @return int
   */
  public function getId(): int {
    return $this->id;
  }

  /**
   * @param int $id
   */
  public function setId(int $id) {
    $this->id = $id;
  }
}