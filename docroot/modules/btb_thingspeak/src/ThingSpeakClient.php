<?php
/**
 * @file
 */

namespace Drupal\btb_thingspeak;

use GuzzleHttp\Client;
use Drupal\node\Entity\Node;

/**
 * Class ThingSpeakClient.
 */
class ThingSpeakClient implements ThingSpeakClientInterface{

  // A Guzzle HTTP client.
  private $http_client;

  public function __construct () {
    $config = [
      'base_uri' => 'https://api.thingspeak.com/',
    ];
    $this->http_client = new Client($config);
  }

  /**
   *
   */
  public function createLocation($lat, $long) {
    $point_str = 'POINT (' . $long . ' ' . $lat . ')';

    $node = Node::create(array(
      'nid' => NULL,
      'type' => 'location',
      'title' => 'Mary Maersk',
      'uid' => 1,
      'status' => TRUE,
      'field_geolocation' => $point_str
    ));
    $node->save();
  }

  /**
   *
   */
  public function getFeedData() {
    $request = $this->http_client->request('GET',
      'channels/113245/feeds.json',
      ['query' => 'api_key=ETJ1ES8LFQYC0EKP&amp;results=2']);
    $response = $request->getBody()->getContents();

    $params = json_decode($response);
    $lat = $params->feeds[0]->field1;
    $long = $params->feeds[0]->field2;

    $this->createLocation($lat, $long);

    return 'Last location of the Mary Maersk Container Ship: Latitude: ' . $lat . ', Longitude: ' . $long;

  }
}

/*
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
*/
