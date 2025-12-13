<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterWinnerTable extends Migration
{
    public function up()
    {
        // Cek apakah tabel winner (lama) ada
        if ($this->db->tableExists('winner')) {
            // Drop tabel lama jika ada
            $this->forge->dropTable('winner', true);
        }

        // Cek apakah tabel winners sudah ada
        if (!$this->db->tableExists('winners')) {
            // Buat tabel winners baru
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
            
            // Cek apakah foreign key bisa ditambahkan
            try {
                $this->forge->addForeignKey('registrant_id', 'registran', 'id', 'CASCADE', 'CASCADE');
                $this->forge->addForeignKey('prize_id', 'prizes', 'id', 'CASCADE', 'CASCADE');
            } catch (\Exception $e) {
                // Skip foreign key jika error
            }
            
            $this->forge->createTable('winners');
        } else {
            // Jika tabel sudah ada, tambahkan kolom yang kurang
            $fields = [
                'registrant_id' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => true,
                    'null'       => true,
                ],
                'prize_id' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => true,
                    'null'       => true,
                ],
            ];

            foreach ($fields as $fieldName => $fieldDef) {
                if (!$this->db->fieldExists($fieldName, 'winners')) {
                    $this->forge->addColumn('winners', [$fieldName => $fieldDef]);
                }
            }

            // Hapus kolom lama jika ada
            $oldFields = ['name', 'bisnis_unit', 'handphone', 'prize_name', 'updated_at'];
            foreach ($oldFields as $field) {
                if ($this->db->fieldExists($field, 'winners')) {
                    $this->forge->dropColumn('winners', $field);
                }
            }
        }
    }

    public function down()
    {
        if ($this->db->tableExists('winners')) {
            $this->forge->dropTable('winners', true);
        }
    }
}

