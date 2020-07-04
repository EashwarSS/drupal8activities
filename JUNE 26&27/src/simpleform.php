<?php
namespace Drupal\formcreations\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
class simpleform extends FormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'formcreations';
  }
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['candidate_firstname'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('First Name:'),
      '#required' => TRUE,
    );
	$form['candidate_Lastt Name'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Last Name:'),
      '#required' => TRUE,
    );
	$form['topic'] = array(
      '#type' => 'radios',
      '#title' => t('Gender'),
      '#options' => array('Male'=>t('Male'),'Female'=>t('Female'),'Others'=>t('Others')),
    );
	$form['topic'] = array(
      '#type' => 'radios',
      '#title' => t('Interests'),
      '#options' => array('Movie'=>t('Movie'),'Songs'=>t('Sports'),'Music'=>t('Music'),'Books'=>t('Books'),'Others'=>t('Others')),
    );
   /* $form['candidate_mail'] = array(
      '#type' => 'email',
      '#title' => $this->t('Email ID:'),
      '#required' => TRUE,
    );
    $form['candidate_number'] = array (
      '#type' => 'tel',
      '#title' => $this->t('Mobile No:'),
    );
    $form['candidate_dob'] = array (
      '#type' => 'date',
      '#title' => $this->t('DATE OF BIRTH:'),
      '#required' => TRUE,
    );*/
    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('SAVE'),
    );
    return $form;
  }
  public function submitForm(array &$form, FormStateInterface $form_state) {
     foreach ($form_state->getValues() as $key => $value) {
       drupal_set_message($key . ': ' . $value);
     }
    }
  }