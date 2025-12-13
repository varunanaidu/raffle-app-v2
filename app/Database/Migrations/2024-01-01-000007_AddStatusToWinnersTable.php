<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStatusToWinnersTable extends Migration
{
    public function up()
    {
        // Add status column to winners table if it doesn't exist
        if ($this->db->tableExists('winners')) {
            if (!$this->db->fieldExists('status', 'winners')) {
                $fields = [
                    'status' => [
                        'type'       => 'VARCHAR',
                        'constraint' => 50,
                        'default'    => 'Pending',
                        'null'       => false,
                        'after'      => 'prize_id',
                    ],
                ];
                $this->forge->addColumn('winners', $fields);
            }
        }
    }

    public function down()
    {
        // Remove status column if exists
        if ($this->db->tableExists('winners')) {
            if ($this->db->fieldExists('status', 'winners')) {
                $this->forge->dropColumn('winners', 'status');
            }
        }
    }
}

