<?php

namespace Drupal\btb_thingspeak;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockPluginInterface;


/**
 * Provides a ThingSpeak block.
 *
 * @Block(
 *   id = "btb_thingspeak_block",
 *   admin_label = @Translation("ThingSpeak Block Example")
 * )
 */
class ThingSpeakBlock extends BlockBase implements BlockPluginInterface {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return ['label_display' => TRUE];
  }


  /**
   * {@inheritdoc}
   */
  public function build() {
    $client = \Drupal::httpClient();
    try {
      $request_field1 = $client->request('GET', 'https://api.thingspeak.com/channels/113245/fields/1.json',
        ['query' => ['results' => '1']]);
      $field1_raw = $request_field1->getBody();
    }
    catch (RequestException $e) {
      watchdog_exception('btb_thingspeak', $e->getMessage());
      $field1_raw = 0;
    }

    try {
      $request_field2 = $client->request('GET', 'https://api.thingspeak.com/channels/113245/fields/2.json',
        ['query' => ['results' => '1']]);
      $field2_raw = $request_field2->getBody();
    }
    catch (RequestException $e) {
      watchdog_exception('btb_thingspeak', $e->getMessage());
      $field2_raw = 0;
    }

    return array('#markup' => '<span>' . $this->t('Field 1: :field1, Field 2: :field2', array(':field1' => $field1_raw, ':field2' => $field2_raw)) . '</span>');
    //return array('#markup' => '<span>' . $this->t('Powered by <a href=":poweredby">Drupal</a>', array(':poweredby' => 'https://www.drupal.org')) . '</span>');

  }

}
