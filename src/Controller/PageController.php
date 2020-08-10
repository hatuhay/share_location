<?php

namespace Drupal\share_location\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PageController.
 */
class PageController extends ControllerBase {

  /**
   * Get.
   *
   * @return string
   *   Return Hello string.
   */
  public function getLocation(AccountInterface $user) {
    return new JsonResponse([
      'data' => $this->getResults($user),
      'method' => 'GET',
    ]);
  }

  /**
   * Page.
   * 
   * Parameter:
   *  - lat
   *  - lng
   *
   * @return string
   *   Return Hello string.
   */
  public function setLocation(AccountInterface $user, Request $request) {
    $location = [
      'lat' => $request->query->get('lat'),
      'lng' => $request->query->get('lng')
    ];
    return new JsonResponse([
      'data' => $this->setResults($user, $location),
      'method' => 'GET',
    ]);
  }

  /**
   * Render.
   *
   * @return string
   *   Return Hello string.
   */
  public function renderMap($user) {
    $uid = $user->id();
    return [
      '#type' => 'markup',
      '#markup' => '<div id="map"></div>',
      '#attached' => [
        'library' => [
          'share_location/map',
        ],
        'drupalSettings' => [
          'dataPaseo' => [
            'paseador' => $uid,
          ]
        ]
      ],
    ];
  }

  /**
   * A helper function returning results.
   */
  public function getResults($user) {
    $lat = $user->get('field_ubicacion')->lat;
    $lng = $user->get('field_ubicacion')->lng;
    return [
      'lat' => $lat,
      'lng' => $lng
    ];
  }

  /**
   * A helper function returning results.
   */
  public function setResults($user, $location) {
    $full_location = [
      'lat' => $location['lat'],
      'lng' => $location['lng'],
      'lat_sin' => $lat = $user->get('field_ubicacion')->lat_sin,
      'lat_cos' => $lng = $user->get('field_ubicacion')->lat_cos,
      'lng_rad' => $lat = $user->get('field_ubicacion')->lng_rad,
      'data' => $lng = $user->get('field_ubicacion')->data,
    ];
    $user->field_ubicacion[0] = $full_location;
    return $user->save();
  }
}