<?php
namespace Drupal\migrate_webseries\Plugin\migrate\source;
use Drupal\migrate\Plugin\migrate\source\SqlBase;
class Webseries_Chapters extends SqlBase {

public function query() {
$query = $this->select('webseries_chapters', 'g')
      ->fields('g', ['id', 'webseries_id', 'name']);
return$query;
  }

public function fields() {
$fields = [
'id' => $this->t('webseries_chapters ID'),
'webseries_id' => $this->t('webseries ID'),
'name' => $this->t('webseries name'),
    ];

return$fields;
  }
  
public function getIds() {
return [
'id' => [
'type' => 'integer',
'alias' => 'g',
      ],
    ];
  }
}

