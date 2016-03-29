<?php

use yii\db\Migration;

class m160328_182748_create_table_note extends Migration
{
    public function up()
    {
        $this->createTable('table_note', [
            'id' => $this->primaryKey()
        ]);
    }

    public function down()
    {
        $this->dropTable('table_note');
    }
}
