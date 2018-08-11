<?php

namespace Drupal\my_crud\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'My_crudBlock' block.
 *
 * @Block(
 *  id = "mycrud_block",
 *  admin_label = @Translation("My CRUD block"),
 * )
 */
class MycrudBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $form = \Drupal::formBuilder()->getForm('Drupal\my_crud\Form\MycrudForm');
    return $form;
  }

}
