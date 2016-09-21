<?php

use yii\db\Migration;

/**
 * Handles the creation for table `media`.
 */
class m160920_112139_create_media_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('media', [
            'id' => $this->primaryKey(),
            'owner' => $this->string(),
            'owner_id' => $this->string(),
            'entity' => $this->string(),
            'entity_id' => $this->string(),
            'mime_type' => $this->string(),
            'file_type' => $this->string(),
            'size' => $this->float(),
            'default' => $this->boolean(),
            'path' => $this->string(),
            'link' => $this->string(),
            'type'=> $this->string(),
            'created_at'=> $this->dateTime(),
            'updated_at'=> $this->dateTime()
        ]);

        $this->createIndex('entity_find_by_entity_index', 'media', ['entity', 'entity_id', 'mime_type', 'type']);
        $this->createIndex('entity_find_by_path_index', 'media', ['path']);
        $this->createIndex('entity_find_by_link_index', 'media', ['link']);
        $this->createIndex('entity_find_by_owner_index', 'media', ['owner', 'owner_id']);


    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('media');
    }
}
