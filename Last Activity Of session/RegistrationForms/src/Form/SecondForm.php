<?php
namespace Drupal\RegistrationForms\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\Core\Database\Database;
use Drupal\user\Entity\User;
use Drupal\user\Entity\Query\QueryInterface;

class SecondForm extends FormBase {
 
  public function getFormId() {
    return 'nextdetails';
  }
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['skills'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Skills:'),
      '#required' => TRUE,
    ];
	$form['bio'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Bio:'),
      '#required' => TRUE,
    ];
    $form['gender'] = array(
      '#type' => 'radios',
      '#title' => $this->t('Gender:'),
      '#options' => array('Male' => 'Male', 'Female' => 'Female'),
      '#required' => TRUE,
      );
$c=array_combine($a,$b);
        $form['interest'] = array(
        '#type' => 'select',
        '#title' => $this->t('Interest:'),
        '#options' => array('Movies' => 'Movies', 'Cricket' => 'Cricket', 'Webseries' => 'Webseries', 'ShortFilms' => 'ShortFilms' ,'Travelling' => 'Travelling'),
        '#required' => TRUE,
        );
    $form['actions'] = [
      '#type' => 'actions',
      'submit' => [
        '#type' => 'submit',
        '#value' => $this->t('Submit'),
      ],
    ];

    return $form;
  }
    public function submitForm(array &$form, FormStateInterface $form_state) {
      $user = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());
      $name = $user->get('name')->value;
      $conn = Database::getConnection();
      $conn->insert('nextdetails')->fields(
        array(
          'name'=>$name,
		  'skills' => $form_state->getValue('skills'),
          'bio' => $form_state->getValue('bio'),
          'gender' => $form_state->getValue('gender'),
          'interest' => $form_state->getValue('interest'),
        )
      )->execute();
      drupal_set_message("Detail Successfully Submitted");
  }
}