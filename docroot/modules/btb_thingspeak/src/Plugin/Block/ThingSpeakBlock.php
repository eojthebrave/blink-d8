<?php

/**
 * Provides a ThingSpeak Block
 *
 * @Block(
 *   id = "btb_thingspeak_block",
 *   admin_label = @Translation("ThingSpeak Block"),
 * )
 */

namespace Drupal\btb_thingspeak\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Drupal\node\Entity\Node;

class ThingSpeakBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return ['label_display' => TRUE];
  }


  /**
   * {@inheritdoc}
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

  public function getFeedData() {

    $client = \Drupal::httpClient();
    $request = $client->request('GET',
      'https://api.thingspeak.com/channels/113245/feeds.json',
      ['query' => 'api_key=ETJ1ES8LFQYC0EKP&amp;results=2']);
    $response = $request->getBody()->getContents();

    $params = json_decode($response);
    $lat = $params->feeds[0]->field1;
    $long = $params->feeds[0]->field2;

    $this->createLocation($lat, $long);


    //kint($params->feeds[0]->field1);

    // test
    // $this->createLocation(21.23234, 114.42442);

    return 'Last location of the Mary Maersk Container Ship: Latitude: ' . $lat . ', Longitude: ' . $long;

  }

  public function build() {
    // Return the block, and don't cache it!
    return array(
      '#markup' => $this->t($this->getFeedData()),
      '#cache' => array(
        'max-age' => 0,
      ),
    );

  }
}
