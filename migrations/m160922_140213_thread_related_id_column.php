<?php

use yii\db\Migration;

class m160922_140213_thread_related_id_column extends Migration
{
    public function safeUp()
    {

        $this->addColumn('{{%forum_threads}}', 'related_id', $this->integer());
        $this->dropColumn('{{%forum_threads}}', 'posted_at');

    }

    public function safeDown()
    {
        $this->dropColumn('{{%forum_threads}}', 'related_id');
        $this->addColumn('{{%forum_threads}}', 'posted_at', $this->integer());
    }
}
