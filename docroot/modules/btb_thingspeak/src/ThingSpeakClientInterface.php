<?php
/**
 * @file
 */

namespace Drupal\btb_thingspeak;

/**
 * Interface ThingSpeakClientInterface.
 */
interface ThingSpeakClientInterface {
  /**
   *
   * @param $lat
   * @param $long
   * @return mixed
   */
  public function createLocation($lat, $long);

  /**
   *
   * @return mixed
   */
  public function getFeedData();
}
