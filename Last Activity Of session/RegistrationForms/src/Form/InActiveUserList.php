<?php
namespace Drupal\RegistrationForms\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\Core\Database\Database;
use Drupal\user\Entity\User;
use Drupal\user\Entity\Query\QueryInterface;

class InActiveUserList extends FormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'InActiveUserList';
  }
  public function buildForm(array $form, FormStateInterface $form_state) {

    $database = \Drupal::database();
    $query = $database->query("SELECT u.uid,u.name,u.mail,u.status from users_field_data as u where u.uid > 0 and u.status = 0");
    $result = $query->fetchAll();
    $options=[];
    foreach($result as $value){
      $data=(array)$value;
      $options[$value->uid] = $data;
     }
    $header=['uid'=>$this->t('UserID'),
            'name'=>$this->t('Name'),
            'mail'=>$this->t('Email'),
            'status'=>$this->t('Status')];

    $form['table'] = [
      '#type' => 'tableselect',
      '#title' => $this->t('User List'),
      '#header' => $header,
      '#options' => $options,
      '#empty' => $this->t('No users found'),
    ];
    $form['actions'] = [
      '#type' => 'actions',
      'submit' => [
        '#type' => 'submit',
        '#value' => $this->t('Activate Account'),
      ],
    ];

    return $form;
  }
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $data = array_filter($form_state->getValue('table'));
    if(empty(!$data)){
    foreach($data as $id){
      $update = \Drupal\user\Entity\User::load($id);
      $update->set('status',1);
      $update->save();
    }
    }
    drupal_set_message("Account Activated Successfully");
    }

}
