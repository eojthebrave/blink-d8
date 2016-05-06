<?php

namespace Drupal\btb_thingspeak;

class ThingSpeakClient extends ClientFactory {

  protected $thingspeak_client;
  public function __construct(Client $thingspeak_client) {
    parent::__construct();
    $this->thingspeak_client = $thingspeak_client;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('btb_thingspeak.client')
    );
  }
}