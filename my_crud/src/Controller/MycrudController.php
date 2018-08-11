<?php

namespace Drupal\my_crud\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Drupal\Core\Url;

/**
 * Controller for CRUD operation.
 */
class MycrudController extends ControllerBase {

  /**
   * Listing.
   */
  public function Listing() {

    // Table header.
    $header_table = [
      'id' => t('ID'),
      'fname' => t('First Name'),
      'lname' => t('Last Name'),
      'email' => t('Email'),
      'phone_number' => t('Phone'),
      'opt' => t('Operation'),
      'opt1' => t('Operation'),
    ];

    $rows = [];
    $query = \Drupal::Database()->select('my_crud', 'm');
    $query->fields('m', ['id', 'fname', 'lname', 'email', 'phone_number']);
    $result = $query->execute()->fetchAll();
    foreach ($result as $value) {
      $delete = Url::fromUserInput('/my_crud/form/delete/' . $value->id);
      $edit   = Url::fromUserInput('/my_crud/form/data?id=' . $value->id);
      $rows[] = [
        'id' => $value->id,
        'fname' => $value->fname,
        'lname' => $value->lname,
        'email' => $value->email,
        'phone_number' => $value->phone_number,
        'opt' => \Drupal::l(t('Edit'), $edit),
        'opt1' => \Drupal::l(t('Delete'), $delete),
      ];

    }

    $add = Url::fromUserInput('/my_crud/form/data');
    $data['table'] = [
      '#type' => 'table',
      '#header' => $header_table,
      '#rows' => $rows,
      '#empty' => t('No record found'),
      '#caption' => \Drupal::l(t('Add User'), $add),
    ];
    return $data;
  }

}
