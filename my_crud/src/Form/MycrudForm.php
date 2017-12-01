<?php

/**
* Form section.
*/

namespace Drupal\my_crud\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Url;

class MycrudForm extends FormBase {

  public function getFormId() {
    return 'mycrud_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {

   $conn = Database::getConnection();
   $record = array();
   if (isset($_GET['id'])) {
    $query = $conn->select('my_crud', 'm')
    ->condition('id', $_GET['id'])
    ->fields('m');
    $record = $query->execute()->fetchAssoc();
  }

  $form['fname'] = [
  '#type' => 'textfield',
  '#title' => t('Fist Name'),
  '#required' => TRUE,
  '#default_value' => (isset($record['fname']) && $_GET['id']) ? $record['fname']:'',
  ];

  $form['lname'] = [
  '#type' => 'textfield',
  '#title' => t('Last Name'),
  '#default_value' => (isset($record['lname']) && $_GET['id']) ? $record['lname']:'',
  ];

  $form['email'] = [
  '#type' => 'email',
  '#title' => t('Email'),
  '#required' => TRUE,
  '#default_value' => (isset($record['email']) && $_GET['id']) ? $record['email']:'',
  ];

  $form['phone_number'] = [
  '#type' => 'tel',
  '#title' => t('Phone Number'),
  '#required' => TRUE,
  '#default_value' => (isset($record['phone_number']) && $_GET['id']) ? $record['phone_number']:'',
  ];

  $form['gender'] = [
  '#type' => 'select',
  '#title' => t('Gender'),
  '#options' => ['1' => t('Male'), '2' => t('Female')],
  '#default_value' => (isset($record['gender']) && $_GET['id']) ? $record['gender']:'',
  ];

  $form['action'] = [
  '#type' => 'action',
  ];

  $form['action']['submit'] = [
  '#type' => 'submit',
  '#value' => t('Save'),
  ];

  $form['action']['reset'] = [
  '#type' => 'button',
  '#value' => t('Reset'),
  '#attributes' => [
  'onclick' => 'this.form.reset(); return false;'
  ],
  ];

  $link = Url::fromUserInput('/my_crud/');

  $form['action']['cancel'] = [
  '#markup' => \Drupal::l(t('Back to page'), $link, array('attributes'=> array('class'=>'button'))),
  ];

  return $form;

}


/**
* Validate form.
*/
public function validateForm(array &$form, FormStateInterface $form_state) {
 $fname = $form_state->getValue('fname');
 if (preg_match('/[^A-Za-z]/', $fname)) {
   $form_state->setErrorByName('fname', $this->t('First name must in characters without space'));
 }

         // No need to validate email, as type=email already.
          /*if (!valid_email_address($form_state->getValue('email'))) {
            $form_state->setErrorByName('email', $this->t('Email address is invalid'));
          }*/

          $phone_number = $form_state->getValue('phone_number');
          if(!preg_match('/[^A-Za-z]/', $phone_number)) {
           $form_state->setErrorByName('phone_number', $this->t('Phone number must be in numbers'));
         }

         if (strlen($form_state->getValue('phone_number')) < 10 ) {
          $form_state->setErrorByName('phone_number', $this->t('Phone number must be in 10 digits'));
        }
        parent::validateForm($form, $form_state);

      }

/**
* Submit form.
*/
public function submitForm(array &$form, FormStateInterface $form_state) {

 $field=$form_state->getValues();
 $fname = $field['fname'];
 $lname = $field['lname'];
 $phone_number = $field['phone_number'];
 $email=$field['email'];
 $gender=$field['gender'];

 if (isset($_GET['id'])) {
  $field  = array(
    'fname'   => $fname,
    'lname'   => $lname,
    'email' =>  $email,
    'phone_number' => $phone_number,
    'gender' => $gender,
    'created' => 'ss',  // Later need to change it
    'updated' => 'ss',   // Later need to change it
    );

  $query = \Drupal::database();
  $query->update('my_crud')
  ->fields($field)
  ->condition('id', $_GET['id'])
  ->execute();
  drupal_set_message("Succesfully updated");
  $form_state->setRedirect('my_crud.mycrud_controller_listing');
}
else {
 $field  = array(
  'fname'   => $fname,
  'lname'   => $lname,
  'email' =>  $email,
  'phone_number' => $phone_number,
  'gender' => $gender,
  'created' => 'ss',    // Later need to change it
  'updated' => 'ss',     // Later need to change it
  );
 $query = \Drupal::database();
 $query ->insert('my_crud')
 ->fields($field)
 ->execute();
 drupal_set_message("succesfully saved");
 //$response = new RedirectResponse("/my_crud");
 //$response->send();
 $form_state->setRedirect('my_crud.mycrud_controller_listing');
}
}

}
