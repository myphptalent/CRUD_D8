<?php

namespace Drupal\my_crud\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Url;

/**
 * Class DeleteForm.
 *
 * @package Drupal\my_crud\Form
 */
class DeleteForm extends ConfirmFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'delete_form';
  }

  public $cid;

  /**
   *
   */
  public function getQuestion() {
    return t('Delete record');
  }

  /**
   *
   */
  public function getCancelUrl() {
    return new Url('my_crud.mycrud_controller_listing');
  }

  /**
   *
   */
  public function getDescription() {
    return t('Are you sure to delete ?');
  }

  /**
   * {@inheritdoc}
   */
  public function getConfirmText() {
    return t('Delete it!');
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelText() {
    return t('Cancel');
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $cid = NULL) {
    $this->id = $cid;
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $query = \Drupal::database();
    $query->delete('my_crud')
      ->condition('id', $this->id)
      ->execute();
    drupal_set_message("succesfully deleted");
    $form_state->setRedirect('my_crud.mycrud_controller_listing');
  }

}
