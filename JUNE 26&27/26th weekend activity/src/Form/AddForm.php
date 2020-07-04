<?php

namespace Drupal\data_form\Form;

use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Form\FormInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Messenger\MessengerTrait;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\database_form\DatabaseFormRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\database_form\ExampleEvent;

class DataFormAddForm implements FormInterface, ContainerInjectionInterface {

  use StringTranslationTrait;
  use MessengerTrait;

  protected $repository;

  
  protected $currentUser;

  
  public static function create(ContainerInterface $container) {
    $form = new static(
      $container->get('data_form.repository'),
      $container->get('current_user')
    );
   
    $form->setStringTranslation($container->get('string_translation'));
    $form->setMessenger($container->get('messenger'));
    return $form;
  }

  public function __construct(Repository $repository, AccountProxyInterface $current_user) {
    $this->repository = $repository;
    $this->currentUser = $current_user;
  }

  
  public function getFormId() {
    return 'database_form_add_form';
  }
  public function validateForm(array &$form, FormStateInterface $form_state) {

      if (empty($form_state->getValue('firstname'))) {
        $form_state->setErrorByName('firstname', $this->t('enter firstname.'));
      }
	  if (empty($form_state->getValue('lastname'))) {
        $form_state->setErrorByName('lastname', $this->t('enter lastname.'));
      }
	   if (empty($form_state->getValue('bio'))) {
        $form_state->setErrorByName('bio', $this->t('enter bio.'));
      }
	
    }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = [];

    $form['message'] = [
      '#markup' => $this->t('Add an entry to the database_student table.'),
    ];
   
    $form['add'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Add a person entry'),
    ];
    $form['add']['firstname'] = [
      '#type' => 'textfield',
      '#title' => $this->t('firstname'),
      '#size' => 15,
    ];
    $form['add']['lastname'] = [
      '#type' => 'textfield',
      '#title' => $this->t('lastname'),
      '#size' => 15,
    ];
	  $form['add']['bio'] = [
      '#type' => 'textfield',
      '#title' => $this->t('bio'),
      '#size' => 15,
    ];
     $form['add']['gender'] = [
      '#type' => 'radios',
      '#title' => $this->t('Access gender'),
      '#description' => $this->t('Radios, #type = radios'),
	  
      '#options' => [1 => 'Female', 0 => 'Male'],

    ];
	
		$database = \Drupal::database();
		$query = $database->query("SELECT tid,name FROM taxonomy_term_field_data WHERE vid = 'interest' ");
		$results = $query->fetchAll();

			$options1 = array();$v=0;
			$a=array();$b=array();$c=array();
			foreach($results  as $key=>$value){
			
			
				array_push($a,$results[$v]->tid);
				array_push($b,$results[$v]->name);
				
				$v++;
			}
			$c=array_combine($a,$b);
			$form['add']['interest'] = array(
			'#type' => 'select',
			'#title' => t('Click on your interset'),
			
			'#options' =>$c,
			'#description' => t('Click on one or more cities.'),
			);
	
		$form['add']['submit'] = [
		  '#type' => 'submit',
		  '#value' => $this->t('Add'),
		  
		   '#ajax' => [
        'callback' => '::addCallback',
        'wrapper' => 'names-fieldset-wrapper',
      ],
		];

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
   
  }

  public function addCallback(array &$form, FormStateInterface $form_state) {
   
    $entry = [
      'firstname' => $form_state->getValue('firstname'),
      'lastname' => $form_state->getValue('lastname'),
      'gender' => $form_state->getValue('gender'),
	  'bio' => $form_state->getValue('bio'),
      'interest' => $form_state->getValue('interest'),
    ];
	 $return = $this->repository->insert($entry);
	 
	 
	$dispatcher = \Drupal::service('event_dispatcher');
    $event = new ExampleEvent($entry);	
	$response = new AjaxResponse();
    if ($return) {
      $this->messenger()->addMessage($this->t('Created entry @entry', ['@entry' => print_r($entry, TRUE)]));
    }
	return $response;
  }

}
