<?php
namespace Drupal\studentforms\Formapi;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
class StudentForms extends FormBase {
  
  public function getFormId() {
    return 'studentforms';
  }
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['candidate_name'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('User Name:'),
      '#required' => TRUE,
	);  
	   $form['candidate_number'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Roll Number:'),
      '#required' => TRUE,
    );
      $form['candidate_mail'] = array(
      '#type' => 'email',
      '#title' => $this->t('Email ID:'),
      '#required' => TRUE,
    );
      $form['candidate_dob'] = array (
      '#type' => 'date',
      '#title' => $this->t('DOB'),
      '#required' => TRUE,
    );
    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Save'),
    );
    return $form;
  }
  public function submitForm(array &$form, FormStateInterface $form_state) {
     foreach ($form_state->getValues() as $key => $value) {
       drupal_set_message($key . ': ' . $value);
     }
    }
  }
