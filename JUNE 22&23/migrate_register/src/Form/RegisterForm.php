<?php

namespace Drupal\migrate_register\Form;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Drupal\Core\Url;

class RegisterForm extends ConfigFormBase {

  public function getFormId() {
    return 'migrate_register_register_form';
  }
   public function buildForm(array $form, FormStateInterface $form_state) {

    $form['username'] = [
       '#type' => 'textfield',
      '#title' => $this->t('Candidate Name'),
      '#description' => $this->t('Email, #type = textfield'),
      
    ];

    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email'),
      '#description' => $this->t('Email, #type = email'),
    ];

    $form['password'] = [
      '#type' => 'password',
      '#title' => $this->t('Password'),
      '#description' => 'Password, #type = password',
    ];

   
    $form['action'] = [
      '#type' => 'action',
      'submit' => [
        '#type' => 'submit',
        '#value' => $this->t('Submit'),
      ],
    ];

    return $form;
  }
  
  protected function getEditableConfigNames()
    {
        return [
        'migrate_register.register',
        ];
    }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
	$a=array();$b=array();
	
    foreach ($values as $key => $value) {
      $label = isset($form[$key]['#title']) ? $form[$key]['#title'] : $key;

      if (is_array($value)) {
        $value = array_filter($value);
      }

      if ($value && $label) {
        $display_value = is_array($value) ? preg_replace('/[\n\r\s]+/', ' ', print_r($value, 1)) : $value;
        $message = $this->t('Value for %title: %value', ['%title' => $label, '%value' => $display_value]);
        $this->messenger()->addMessage($message);
		

      }
    }
	  foreach ($values as $key => $value) {
	  if ($key=='username' || $key== 'email' || $key =='password')
	  {
		  array_push($a, $key);
		  array_push($b, $value);
	  }
	  }
	  $uuid_service = \Drupal::service('uuid');
$uuid = $uuid_service->generate();
	$c = array_combine($a, $b);
	$d=array('id'=>'');
	
	$d=array($uuid=>
		$c);

	$config = \Drupal::service('migrate_register.register')->savetocinfig($d);
  }

}
