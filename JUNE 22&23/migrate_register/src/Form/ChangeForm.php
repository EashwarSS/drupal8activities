<?php

namespace Drupal\migrate_register\Form;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Drupal\Core\Url;


use Symfony\Component\HttpFoundation\RedirectResponse;


class ChangeForm extends ConfigFormBase {

  public  $uid;
  
  public function getFormId() {
    return 'migrate_register_change_form';
  }

 protected function getEditableConfigNames()
    {
        return [
        'migrate_register.display',
        ];
    }
  public function buildForm(array $form, FormStateInterface $form_state) {
	  
	  
     $record = array();
	

	 $path = \Drupal::request()->getpathInfo();
$arg  = explode('/',$path);
 
	 
	 $uid=$arg[3];
    if ($uid) {
        
	  
	  
	  $record = \Drupal::service('config.factory')->getEditable('migrate_register.settings')->get($uid);
		
}
$config = \Drupal::service('config.factory')->getEditable('migrate_register.settings');


$form['username'] = [
       '#type' => 'textfield',
      '#title' => $this->t('Candidate'),
      '#description' => $this->t('Email, #type = textfield'),
	   '#default_value' => (isset($record['username']) && $uid) ? $record['username']:'',
      
    ];

    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email ID'),
      '#description' => $this->t('Email, #type = email'),
	   '#default_value' => (isset($record['email']) && $uid) ? $record['email']:'',
    ];

   
    $form['password'] = [
      '#type' => 'password',
      '#title' => $this->t('Password'),
	  
      '#description' => 'Password, #type = password',
	  '#default_value' => (isset($record['password']) && $uid) ? $record['password']:'',
    ];

   

  $form['uid'] = [
       '#type' => 'textfield',
      '#title' => $this->t('Uid'),
      '#description' => $this->t('uid, #type = textfield'),
	   '#default_value' => $uid,
      
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
	   
    $d=array();
	
	
	$field=$form_state->getValues();
    $username=$field['username'];
    $password=$field['password'];
    $email=$field['email'];
	$id=$field['uid'];
   
		   $config = \Drupal::service('config.factory')->getEditable('migrate_register.settings');
		   
		
          $field  = array(
              'username'   => $username,
              'password' =>  $password,
              'email' =>  $email,
              
          );
	  
	
	$d=array($id=>
		$field);
		
		$config = \Drupal::service('migrate_register.register')->savetoeditcinfig($d);	
			
		 
		 
		
      }
 
}
