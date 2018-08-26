<?php


namespace RetweetBot\RetweetBlockchainBundle\Entities;


class Tweet {

  /**
   * @var int
   */
  private $id;

  /**
   * @var User
   */
  private $user;

  public function __construct(object $tweet) {
    $this->id = $tweet->id;
    $this->setUser($tweet->user);
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

  /**
   * @return User
   */
  public function getUser(): User {
    return $this->user;
  }

  /**
   * @param object $user
   */
  public function setUser(object $user) {
    $this->user = new User($user);
  }
}