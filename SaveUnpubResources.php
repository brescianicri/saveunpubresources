<?php
/**
 * SaveUnpubResources beta 0.0.1
 *
 * DESCRIPTION
 *
 * This Plugin write Modx Resources with Unpublished date in external table call: resoruce_unpub
 *
 * OnDocFormSave Event
 *
 *
 */


$unpub_date = $resource->get('unpub_date');

// eseguo lo script solo quando ho la data di spubblicazione
if ($unpub_date !== 0){
  $id = $resource->get('id');

  //trovo id della risorsa e data di spubblicazione
  $modx->log(modX::LOG_LEVEL_ERROR, '[SaveUnpub] id'.$id);
  $modx->log(modX::LOG_LEVEL_ERROR, '[SaveUnpub] unpub_date'.$unpub_date);

  //converto la data di spubblicazione in un timestamp
  $unpub_date_format = strtotime($unpub_date) ;

  // cancello le vecchie righe per lo stesso id risorsa
  $sql2 = 'DELETE FROM resoruce_unpub WHERE resource_id = '.$id;
  $stmt2 = $modx->prepare($sql2);
  $stmt2->execute();
  
  //inserisco i dati nella tabella
  $sql = 'INSERT INTO resoruce_unpub (resource_id, unpub_date) VALUES ('.$id.', '.$unpub_date_format.' )';
  $stmt = $modx->prepare($sql);
  $stmt->execute();

  //mi scrivo un log con le righe inserite
  $modx->log(modX::LOG_LEVEL_ERROR, $modx->lastInsertId());
}
