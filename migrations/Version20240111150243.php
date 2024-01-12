<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240111150243 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $table = $schema->createTable('contact');
        $table->addColumn('id', 'bigint', ['autoincrement' => true]);
        $table->addColumn('name', 'string', ['length' => 125]);
        $table->addColumn('email', 'string', ['length' => 125]);
        $table->addColumn('message', 'string', ['length' => 255]);
        $table->setPrimaryKey(['id']);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE contact');
    }
}
