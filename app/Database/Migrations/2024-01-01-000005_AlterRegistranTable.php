<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterRegistranTable extends Migration
{
    public function up()
    {
        $fields = [
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
                'after'      => 'name',
            ],
            'company' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
                'after'      => 'phone_number',
            ],
            'inputed_time' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
                'after'      => 'bisnis_unit',
            ],
        ];

        // Cek dan tambahkan kolom jika belum ada
        foreach ($fields as $fieldName => $fieldDef) {
            if (!$this->db->fieldExists($fieldName, 'registran')) {
                $this->forge->addColumn('registran', [$fieldName => $fieldDef]);
            }
        }

        // Ubah bisnis_unit menjadi nullable jika belum
        if ($this->db->fieldExists('bisnis_unit', 'registran')) {
            $this->db->query("ALTER TABLE `registran` MODIFY `bisnis_unit` VARCHAR(100) NULL");
        }

        // Tambahkan index untuk email jika belum ada
        try {
            $indexExists = $this->db->query("
                SELECT COUNT(*) as count 
                FROM information_schema.statistics 
                WHERE table_schema = DATABASE() 
                AND table_name = 'registran' 
                AND index_name = 'email'
            ")->getRow();
            
            if ($indexExists && $indexExists->count == 0) {
                $this->db->query("ALTER TABLE `registran` ADD INDEX `email` (`email`)");
            }
        } catch (\Exception $e) {
            // Index might already exist or table doesn't exist, skip
            log_message('debug', 'Index check failed: ' . $e->getMessage());
        }

        // Update data existing: copy bisnis_unit ke company jika company kosong
        $this->db->query("UPDATE `registran` SET `company` = `bisnis_unit` WHERE (`company` IS NULL OR `company` = '') AND `bisnis_unit` IS NOT NULL");
    }

    public function down()
    {
        // Hapus kolom yang ditambahkan
        $fieldsToRemove = ['inputed_time', 'company', 'email'];
        
        foreach ($fieldsToRemove as $field) {
            if ($this->db->fieldExists($field, 'registran')) {
                $this->forge->dropColumn('registran', $field);
            }
        }

        // Hapus index email
        try {
            $indexExists = $this->db->query("
                SELECT COUNT(*) as count 
                FROM information_schema.statistics 
                WHERE table_schema = DATABASE() 
                AND table_name = 'registran' 
                AND index_name = 'email'
            ")->getRow();
            
            if ($indexExists && $indexExists->count > 0) {
                $this->db->query("ALTER TABLE `registran` DROP INDEX `email`");
            }
        } catch (\Exception $e) {
            // Index might not exist, skip
            log_message('debug', 'Index check failed: ' . $e->getMessage());
        }
    }
}

