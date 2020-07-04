<?php
namespace Drupal\data_form\Controller;
use Drupal\Core\Controller\ControllerBase;
use Drupal\database_form\DatabaseFormRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Url;
use Drupal\Core\Render\Markup;
use Drupal\user\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;

class FormController extends ControllerBase {


  protected $repository;
  public $user;

  public static function create(ContainerInterface $container) {
    $controller = new static($container->get('database_form.repository'));
    $controller->setStringTranslation($container->get('string_translation'));
    return $controller;
  }


  public function __construct(Repository $repository) {
    $this->repository = $repository;
  }


  public function entryList() {
    $content = [];

    $content['message'] = [
      '#markup' => $this->t('Generate a list of all entries in the database. There is no filter in the query.'),
    ];

    $rows = [];
    $headers = [
      $this->t('pid'),
    
      $this->t('firstname'),
      $this->t('lastname'),
      $this->t('bio'),
	  $this->t('interest'), 
	    $this->t('gender'),
		$this->t('link'),
    ];

	$results = $this->repository->load();
	
	$k1=array();
   $output=array();

    foreach($results as $k=>$data){

      $term_name = \Drupal\taxonomy\Entity\Term::load($results[$k]->interest)->get('name')->value;
	 
      if($results[$k]->gender ==1)
      {
		  
		  $edit   = Url::fromUserInput('/update');
          $output[] = [
		  'pid' => $results[$k]->pid,
		  'lastname' => $results[$k]->lastname,
          'firstname' => $results[$k]->firstname,     
          'bio' => $results[$k]->bio,
          'gender' => 'Male',
		 
          'interest' => $term_name,
          \Drupal::l('Edit', $edit),

         ];
      }
      if($results[$k]->gender ==0)
      {
		  
		 $edit   = Url::fromUserInput('/update');
          $output[] = [
		  'pid' => $results[$k]->pid,
		  'lastname' => $results[$k]->lastname,
          'firstname' => $results[$k]->firstname,     
          'bio' => $results[$k]->bio,
          'gender' => 'Female',
		  
          'interest' => $term_name,
          \Drupal::l('Edit', $edit),

         ];
      }

        array_push($k1,$output);
 
    }

    $content['table'] = [
              '#type' => 'table',
              '#header' => $headers,
              '#rows' => $output,
              '#empty' => t('No users found'),
          ];
		
		  return new jsonResponse(
		  [
		  
		  'data' => $output,
		  'method' => 'GET'
		  ]
		  );
  }
