<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240320125250 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE likes DROP FOREIGN KEY FK_49CA4E7D9D86650F');
        $this->addSql('ALTER TABLE likes DROP FOREIGN KEY FK_49CA4E7DE85F12B8');
        $this->addSql('DROP TABLE likes');
        $this->addSql('ALTER TABLE connexion ADD connection_id INT NOT NULL');
        $this->addSql('ALTER TABLE publication ADD post_id INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE likes (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, post_id_id INT NOT NULL, date_time DATETIME NOT NULL, INDEX IDX_49CA4E7D9D86650F (user_id_id), INDEX IDX_49CA4E7DE85F12B8 (post_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE likes ADD CONSTRAINT FK_49CA4E7D9D86650F FOREIGN KEY (user_id_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE likes ADD CONSTRAINT FK_49CA4E7DE85F12B8 FOREIGN KEY (post_id_id) REFERENCES publication (id)');
        $this->addSql('ALTER TABLE publication DROP post_id');
        $this->addSql('ALTER TABLE connexion DROP connection_id');
    }
}
