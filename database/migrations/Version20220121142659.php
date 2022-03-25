<?php

declare(strict_types=1);

namespace Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220121142659 extends AbstractMigration
{
    /**
     * @return string
     */
    public function getDescription(): string
    {
        return 'Create urls table';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable("urls");
        $table->addColumn('id', 'integer', [
            'autoincrement' => true,
        ]);
        $table->addColumn("url", "string");
        $table->addColumn("short_url", "string");
        $table->setPrimaryKey(array('id'));
        $table->addUniqueConstraint(array('short_url'));
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('urls');
    }
}
