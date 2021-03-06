<?php
/**
* Provides a 'Hello' Block
*
* @Block(
*   id = "hello_block",
*   admin_label = @Translation("Hello block"),
* )
*/

namespace Drupal\btb_thingspeak\Plugin\Block;

use Drupal\Core\Block\BlockBase;

class HelloBlock extends BlockBase {
/**
* {@inheritdoc}
*/
public function build() {
  return array(
  '#markup' => $this->t('Hello, World!'),
  );
  }
}