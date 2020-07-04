<?php
namespace Drupal\RegistrationForms\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\Core\Database\Database;
use Drupal\user\Entity\User;
use Drupal\user\Entity\Query\QueryInterface;

class SignInForm extends FormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'SignInForm';
  }
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['candidate_name'] = [
       '#type' => 'textfield',
      '#title' => $this->t('Candidate_Name:'),
    ];
    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email:'),
    ];
    $form['password'] = [
      '#type' => 'password',
      '#title' => $this->t('Password:'),
    ];
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
    $candidate_name = $form_state->getValue('candidate_name');
    $email = $form_state->getValue('email');
    $password = $form_state->getValue('password');
    $result = \Drupal::entityQuery('user')
        ->condition('name', $candidate_name)
        ->range(0, 1)
        ->execute();
    #print_r($result);die;
    if(empty($result)){
      $user = User::create();
      $user->setPassword($password);
      $user->enforceIsNew();
      $user->setEmail($email);
      $user->setUsername($candidate_name);
      $user->addRole('users');
      $user->save();
      $this->messenger()->addMessage('your account is registered our admin team will look & activate your account.');
    }
    else{
      $this->messenger()->addMessage('user already exist with this name');
    }
  }
}
