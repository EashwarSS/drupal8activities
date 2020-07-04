<?php
namespace Drupal\enrollment\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
class SimpleForm extends FormBase {
  
  public function getFormId() {
    return 'enrollment';
  }
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['candidate_name'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Candidate Name:'),
      '#required' => TRUE,
    );
    $form['candidate_mail'] = array(
      '#type' => 'email',
      '#title' => $this->t('Email ID:'),
      '#required' => TRUE,
    );
    $form['candidate_security'] = array (
      '#type' => 'tel',
      '#title' => $this->t('Password:'),
    );
    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Log In'),
    );
    return $form;
  }
  public function submitForm(array &$form, FormStateInterface $form_state) {
     foreach ($form_state->getValues() as $key => $value) {
       drupal_set_message($key . ': ' . $value);
     }
    }
  }
