<?php

namespace Drupal\route_examples\Controller;

use Drupal\Component\Utility\Html;
use Drupal\Component\Utility\Xss;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Cache\Context\ContextCacheKeys;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Datetime\DateFormatterInterface;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Session\AccountInterface;
use Drupal\node\NodeInterface;
use Drupal\user\UserInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class RouteExampleController extends ControllerBase {

  /**
   * @var \Drupal\Core\Datetime\DateFormatterInterface
   */
  protected DateFormatterInterface $dateFormatter;

  /**
   * @param DateFormatterInterface $dateFormatter
   */
  public function __construct(DateFormatterInterface $dateFormatter) {
    $this->dateFormatter = $dateFormatter;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('date.formatter')
    );
  }

  public function helloWorld() {
    $cache = new CacheableMetadata();
    $cache->setCacheMaxAge(0);

    $build = [
      '#plain_text' => $this->t('Hello world! The time is: @time.', [
        '@time' => (new DrupalDateTime())->format('H:i:s'),
      ]),
    ];
    $cache->applyTo($build);

    return $build;
  }

  public function helloUser() {
    // return [
    //   '#markup' => Html::escape($this->currentUser()->getDisplayName()),
    // ];
    // return [
    //   '#plain_text' => $this->currentUser()->getDisplayName(),
    // ];
    return [
      '#markup' => $this->t('Hello @user', ['@user' => $this->currentUser()->getDisplayName()])
    ];
  }

  public function helloUserTitle() {
    return $this->t('Hello @user', ['@user' => $this->currentUser()->getDisplayName()]);
  }

  public function userInfo(UserInterface $user) {
    $build = [];

    $build[] = [
      '#type' => 'html_tag',
      '#tag' => 'div',
      '#value' => $this->t('Name: @name', ['@name' => $user->getDisplayName()]),
    ];
    $build[] = [
      '#type' => 'html_tag',
      '#tag' => 'div',
      '#value' => $this->t('Email: @email', ['@email' => $user->getEmail()]),
    ];
    $build[] = [
      '#type' => 'html_tag',
      '#tag' => 'div',
      '#value' => $this->t('Created: @created', ['@created' => $this->dateFormatter->format($user->getCreatedTime())]),
    ];
    $build[] = [
      '#type' => 'html_tag',
      '#tag' => 'div',
      '#value' => $this->t('Last Login: @login', ['@login' => $this->dateFormatter->format($user->getLastLoginTime())]),
    ];

    return $build;
  }

  public function userInfoTitle(UserInterface $user) {
    return $this->t('Information About @user', ['@user' => $user->getDisplayName()]);
  }


  public function nodeList(int $limit, string $type) {
    $cache = new CacheableMetadata();
    $node_storage = $this->entityTypeManager()->getStorage('node');
    $query = $node_storage->getQuery()
      ->accessCheck(TRUE)
      ->sort('nid')
      ->pager(4);
    if ($type !== '_all') {
      $query->condition('type', $type);
    }
    $nids = $query->execute();

    $nodes = $node_storage->loadMultiple($nids);

    $header = [
      $this->t('ID'),
      $this->t('Type'),
      $this->t('Title'),
    ];
    $rows = [];
    foreach ($nodes as $node) {
      $cache->addCacheableDependency($node);
      $rows[] = [
        $node->id(),
        $node->bundle(),
        $node->label(),
      ];
    }

    $cache->addCacheTags(['node_list']);

    $build = [
      'results' => [
        '#theme' => 'table',
        '#header' => $header,
        '#rows' => $rows,
      ],
      'pager' => [
        '#type' => 'pager',
      ],
    ];

    $cache->applyTo($build);

    return $build;
  }

  public function nodeCompare(NodeInterface $node1, NodeInterface $node2) {
    $diff = $node1->getCreatedTime() - $node2->getCreatedTime();

    return [
      '#markup' => t('Created Time Difference: @diff seconds', ['@diff' => $diff]),
    ];
  }

  public function userInfoAccess(AccountInterface $account, UserInterface $user) {
    if ($account->hasPermission('view any user info')) {
      return AccessResult::allowed();
    }
    if ($account->hasPermission('view own user info') && $account->id() == $user->id()) {
      return AccessResult::allowed();
    }
    return AccessResult::forbidden();
  }



}
