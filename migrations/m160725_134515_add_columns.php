<?php

use yii\db\Migration;

class m160725_134515_add_columns extends Migration
{
    public function safeUp()
    {

        $this->addColumn('{{%forum_sections}}', 'lang', $this->string());
        $this->addColumn('{{%forum_forums}}', 'lang', $this->string());
        $this->addColumn('{{%forum_threads}}', 'posted_at', $this->integer());
               
    }

    public function safeDown()
    {
        $this->dropColumn('{{%forum_sections}}', 'lang');
        $this->dropColumn('{{%forum_forums}}', 'lang');
        $this->dropColumn('{{%forum_threads}}', 'posted_at');
    }

}
