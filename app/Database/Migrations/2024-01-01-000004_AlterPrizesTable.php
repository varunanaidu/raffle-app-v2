<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterPrizesTable extends Migration
{
    public function up()
    {
        $fields = [
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
                'after'      => 'id',
            ],
            'image' => [
                'type'       => 'VARCHAR',
                'constraint' => '500',
                'null'       => true,
                'after'      => 'prize_name',
            ],
            'raffled' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'after'      => 'stock',
            ],
            'is_grand_prize' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'after'      => 'raffled',
            ],
            'is_grandprize' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'after'      => 'is_grand_prize',
            ],
        ];

        // Cek dan tambahkan kolom jika belum ada
        foreach ($fields as $fieldName => $fieldDef) {
            if (!$this->db->fieldExists($fieldName, 'prizes')) {
                $this->forge->addColumn('prizes', [$fieldName => $fieldDef]);
            }
        }

        // Update data existing: copy prize_name ke name jika name kosong
        $this->db->query("UPDATE prizes SET name = prize_name WHERE (name IS NULL OR name = '') AND prize_name IS NOT NULL");
        
        // Update data existing: copy images ke image jika image kosong
        $this->db->query("UPDATE prizes SET image = images WHERE (image IS NULL OR image = '') AND images IS NOT NULL");
    }

    public function down()
    {
        // Hapus kolom yang ditambahkan
        $fieldsToRemove = ['is_grandprize', 'is_grand_prize', 'raffled', 'image', 'name'];
        
        foreach ($fieldsToRemove as $field) {
            if ($this->db->fieldExists($field, 'prizes')) {
                $this->forge->dropColumn('prizes', $field);
            }
        }
    }
}

