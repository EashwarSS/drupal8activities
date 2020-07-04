<?php
namespace Drupal\data_form;
use Drupal\Core\Database\Connection;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\Core\Messenger\MessengerTrait;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\StringTranslation\TranslationInterface;

class Repository {

  use MessengerTrait;
  use StringTranslationTrait;

  protected $connection;


  public function __construct(Connection $connection, TranslationInterface $translation, MessengerInterface $messenger) {
    $this->connection = $connection;
    $this->setStringTranslation($translation);
    $this->setMessenger($messenger);
  }
 
  public function insert(array $entry) {
    try {
      $return_value = $this->connection->insert('taxonomyform')
        ->fields($entry)
        ->execute();
    }
    catch (\Exception $e) {
      $this->messenger()->addMessage(t('Insert failed. Message = %message', [
        '%message' => $e->getMessage(),
      ]), 'error');
    }
    return $return_value ?? NULL;
  }

  public function update(array $entry) {
	 
    try {
    
      $count = $this->connection->update('taxonomyform')
        ->fields($entry)
        ->condition('pid', $entry['pid'])
        ->execute();
    }
    catch (\Exception $e) {
      $this->messenger()->addMessage(t('Update failed. Message = %message, query= %query', [
        '%message' => $e->getMessage(),
        '%query' => $e->query_string,
      ]
      ), 'error');
    }
    return $count ?? 0;
  }

  public function delete(array $entry) {
    $this->connection->delete('taxonomyform')
      ->condition('pid', $entry['pid'])
      ->execute();
  }
 
  public function load(array $entry = []) {
    
    $select = $this->connection
      ->select('taxonomyform',t)
    
      ->fields(t);

    foreach ($entry as $field => $value) {
      $select->condition($field, $value);
    }

    return $select->execute()->fetchAll();
  }
