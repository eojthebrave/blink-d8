<?php

namespace Drupal\btb_thingspeak;

use GuzzleHttp\Client;

class ClientFactory {

/**
* Return a configured Client object.
*/
public function get() {
  $config = [
  'base_uri' => 'https://api.thingspeak.com/',
  ];

  $client = new Client($config);

  return $client;
  }
}
