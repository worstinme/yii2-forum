<?php

use yii\db\Migration;

/**
 * Handles the creation for table `tables`.
 */
class m160711_175421_create_tables extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('forum_sections', [
            'id' => $this->primaryKey(),   
            'name' => $this->string()->notNull(),
            'alias' => $this->string()->notNull(),
            'description' => $this->text(),
            'state' => $this->smallInteger()->defaultValue(0),
            'sort' => $this->integer()->defaultValue(0), 
            'metaTitle' => $this->string(),
            'metaDescription' => $this->text(),
            'metaKeywords' => $this->string(),
        ], $tableOptions);

        $this->createTable('forum_forums', [
            'id' => $this->primaryKey(),   
            'section_id' => $this->integer()->notNull(),  
            'name' => $this->string()->notNull(),
            'alias' => $this->string()->notNull(),
            'description' => $this->text(),
            'state' => $this->smallInteger()->defaultValue(0),
            'sort' => $this->integer()->defaultValue(0), 
            'metaTitle' => $this->string(),
            'metaDescription' => $this->text(),
            'metaKeywords' => $this->string(),
            
        ], $tableOptions);
 
        $this->createTable('forum_threads', [
            'id' => $this->primaryKey(),            
            'forum_id' => $this->integer()->notNull(),  
            'name' => $this->string()->notNull(),
            'content' => $this->text(),
            'flag' => $this->smallInteger()->defaultValue(0), 
            'state' => $this->smallInteger()->defaultValue(0), 
            'views' => $this->smallInteger()->defaultValue(0), 
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'user_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createTable('forum_posts', [
            'id' => $this->primaryKey(),      
            'thread_id' => $this->integer()->notNull(),        
            'name' => $this->string()->notNull(),
            'content' => $this->text(),
            'state' => $this->smallInteger()->defaultValue(0), 
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'user_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createTable('forum_tags', [
            'thread_id' => $this->integer()->notNull(),      
            'tag' => $this->string()->notNull(),
        ], $tableOptions);

    }   

    public function safeDown()
    {

        $this->dropTable('forum_sections');
        $this->dropTable('forum_forums');
        $this->dropTable('forum_threads');
        $this->dropTable('forum_posts');
        $this->dropTable('forum_tags');
    }

}