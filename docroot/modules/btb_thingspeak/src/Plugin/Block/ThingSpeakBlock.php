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
use Drupal\btb_thingspeak\ThingSpeakClient;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\btb_thingspeak\ThingSpeakClientInterface;

class ThingSpeakBlock extends BlockBase implements ContainerFactoryPluginInterface{

  // Implementation of ThingSpeakClientInterface.
  protected $thingspeak_client;

  /**
   * ThingSpeakBlock constructor.
   *
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   * @param ThingSpeakClientInterface $thingspeak_client
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, ThingSpeakClientInterface $thingspeak_client) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->thingspeak_client = $thingspeak_client;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('btb_thingspeak.client')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return ['label_display' => TRUE];
  }

  public function build() {
    // Return the block, and don't cache it!
    return array(
      '#markup' => $this->t($this->thingspeak_client->getFeedData()),
      '#cache' => array(
        'max-age' => 0,
      ),
    );

  }
}
