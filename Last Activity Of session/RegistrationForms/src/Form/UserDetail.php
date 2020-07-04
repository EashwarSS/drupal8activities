<?php
namespace Drupal\RegistrationForms\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\Core\Database\Database;
use Drupal\user\Entity\User;
use Drupal\user\Entity\Query\QueryInterface;

class UserDetail extends FormBase {
 
  public function getFormId() {
    return 'User_detail';
  }
  public function buildForm(array $form, FormStateInterface $form_state) {

    $database = \Drupal::database();
    $user = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());
    $name = $user->get('name')->value;
    #print_r($name);die;
    $query = $database->query("SELECT u.pid,u.name,u.skills,u.bio,u.gender,u.interest from otherdetails as u where name = '$name'");
    $result = $query->fetchAll();
    $options=[];
    foreach($result as $value){
      $data=(array)$value;
      $options[$value->pid] = $data;
     }
    $header=[
            'name'=>$this->t('Name'),
            'gender'=>$this->t('Gender'),
            'skills'=>$this->t('Skills'),
            'bio'=>$this->t('Bio'),
            'interest'=>$this->t('interest')];

    $form['table'] = [
      '#type' => 'tableselect',
      '#title' => $this->t('User List'),
      '#header' => $header,
      '#options' => $options,
      '#empty' => $this->t('No users found'),
    ];

    return $form;
  }
  public function submitForm(array &$form, FormStateInterface $form_state) {
    drupal_set_message("Account Activated Successfully");
    }

}