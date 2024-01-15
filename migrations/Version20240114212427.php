<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use App\Helper\UsersHelper;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240114212427 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    /**/
    public function up(Schema $schema): void
    {
        $table = $schema->createTable('users');

        $table->addColumn('id', 'bigint', ['autoincrement' => true, 'unsigned' => true]);
        $table->addColumn('uname', 'string', ['length' => 180]);
        $table->addColumn('password', 'string', ['length' => 255]);
        $table->addColumn('roles', 'json');
        $table->addUniqueIndex(['uname']);
        $table->setPrimaryKey(['id']);

    }

    /**/
    public function postUp(Schema $schema): void
    {
        $this->connection->insert('users',
            [
                'uname' => 'admin',
                'password' => UsersHelper::getHashedPassword('password'),
                'roles' => '["ROLE_SUPER_ADMIN"]'
            ]
        );
    }

    /**/
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE users');
    }
}
