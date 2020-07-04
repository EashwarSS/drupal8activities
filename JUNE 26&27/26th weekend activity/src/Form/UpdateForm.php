<?php

namespace Drupal\data_form\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Messenger\MessengerTrait;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\database_form\DatabaseFormRepository;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;

class DatabaseFormUpdateForm extends FormBase {

 
  protected $repository;


  
  public function getFormId() {
    return 'data_form_update_form';
  }

  public static function create(ContainerInterface $container) {
    $form = new static($container->get('data_form.repository'));
    $form->setStringTranslation($container->get('string_translation'));
    $form->setMessenger($container->get('messenger'));
    return $form;
  }

  public function __construct(Repository $repository) {
    $this->repository = $repository;
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    
    $form = [
      '#prefix' => '<div id="updateform">',
      '#suffix' => '</div>',
    ];
  
    $form['message'] = [
      '#markup' => $this->t('Demonstrates a database update operation.'),
    ];
    $entries = $this->repository->load(); 
   
    if (empty($entries)) {
      $form['no_values'] = [
        '#value' => $this->t('No entries exist in the table database_student table.'),
      ];
      return $form;
    }

    $keyed_entries = [];
    $options = [];
    foreach ($entries as $entry) {
      $options[$entry->pid] = $this->t('@pid: @lastname @firstname @bio @gender @interest', [
        '@pid' => $entry->pid,
        '@firstname' => $entry->firstname,
        '@lastname' => $entry->lastname,
        '@bio' => $entry->bio,
		'@gender' => $entry->gender,
		'@interest' => $entry->interest,

      ]);
      $keyed_entries[$entry->pid] = $entry;
    }

   
    $pid = $form_state->getValue('pid');
    
    $default_entry = !empty($pid) ? $keyed_entries[$pid] : $entries[0];

    $form_state->setValue('entries', $keyed_entries);

    $form['pid'] = [
      '#type' => 'select',
      '#options' => $options,
      '#title' => $this->t('Choose entry to update'),
      '#default_value' => $default_entry->pid,
      '#ajax' => [
        'wrapper' => 'updateform',
        'callback' => [$this, 'updateCallback'],
      ],
    ];

    $form['firstname'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Updated first name'),
      '#size' => 15,
      '#default_value' => $default_entry->firstname,
    ];

    $form['lastname'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Updated last name'),
      '#size' => 15,
      '#default_value' => $default_entry->lastname,
    ];
    $form['bio'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Updated bio'),
      '#size' => 4,
      '#default_value' => $default_entry->bio,
      '#description' => $this->t('Values greater than 127 will cause an exception'),
    ];
	  $form['gender'] = [
      '#type' => 'radios',
      '#title' => $this->t('Access gender'),
      '#description' => $this->t('Radios, #type = radios'),
	  
      '#options' => [1 => 'Female', 0 => 'Male'],
	  '#default_value' => $default_entry->gender,

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
		$form['interest'] = array(
			'#type' => 'select',
			'#title' => t('Click on your interset'),
			
			'#options' =>$c,
			'#default_value' => $default_entry->interest,
			'#description' => t('Click on one or more cities.'),
		  );
	
	 

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Update'),
	   '#ajax' => [
        'callback' => '::updatesCallback',
        'wrapper' => 'names-fieldset-wrapper',
      ],
    ];
    return $form;
  }

  public function updateCallback(array $form, FormStateInterface $form_state) {
    
    $entries = $form_state->getValue('entries');
    $entry = $entries[$form_state->getValue('pid')];
    foreach (['firstname', 'lastname', 'bio', 'gender','interest'] as $item) {
      $form[$item]['#value'] = $entry->$item;
    }
    return $form;
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


  public function submitForm(array &$form, FormStateInterface $form_state) {
   
  }
public function updatesCallback(array &$form, FormStateInterface $form_state) {
   
    $entry = [
      'firstname' => $form_state->getValue('firstname'),
      'lastname' => $form_state->getValue('lastname'),  'bio' => $form_state->getValue('bio'),
      'gender' => $form_state->getValue('gender'),
	'pid' => $form_state->getValue('pid'),
      'interest' => $form_state->getValue('interest'),
    ];
	
    $count = $this->repository->update($entry);
	$response = new AjaxResponse();
	$this->messenger()->addMessage($this->t('Updated entry @entry (@count row updated)', [
      '@count' => $count,
      '@entry' => print_r($entry, TRUE),
    ]));
	return $response;
  }
}
