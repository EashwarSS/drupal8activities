<?php
namespace Drupal\migrate_webseries\Plugin\migrate\source;
use Drupal\migrate\Plugin\migrate\source\SqlBase;
use Drupal\migrate\Row;

class Webseries extends SqlBase {

public function query() {
$query = $this->select('webseries', 'd')
      ->fields('d', ['id', 'name', 'description']);
return$query;
  }
public function fields() {
$fields = [
'id' => $this->t('webseries ID'),
'name' => $this->t('webseries Name'),
'description' => $this->t('webseries Description'),
'webseries_chapters' => $this->t('webseries_chapters'),
    ];

return$fields;
  }

public function getIds() {
return [
'id' => [
'type' => 'integer',
'alias' => 'd',
      ],
    ];
  }

public function prepareRow(Row$row) {
$genres = $this->select('webseries_chapters', 'g')
      ->fields('g', ['id'])
      ->condition('webseries_id', $row->getSourceProperty('id'))
      ->execute()
      ->fetchCol();
$row->setSourceProperty('webseries_chapters', $genres);
returnparent::prepareRow($row);
  }
}

