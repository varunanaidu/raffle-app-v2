<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateWinnerTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'registrant_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'prize_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('registrant_id');
        $this->forge->addKey('prize_id');
        $this->forge->addForeignKey('registrant_id', 'registran', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('prize_id', 'prizes', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('winners');
    }

    public function down()
    {
        $this->forge->dropTable('winners');
    }
}

