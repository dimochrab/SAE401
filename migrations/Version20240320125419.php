<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240320125419 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, user_id_id INT DEFAULT NULL, post_id_id INT NOT NULL, content LONGTEXT NOT NULL, date_time DATETIME NOT NULL, INDEX IDX_67F068BC9D86650F (user_id_id), INDEX IDX_67F068BCE85F12B8 (post_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE connexion (id INT AUTO_INCREMENT NOT NULL, user_id_id INT DEFAULT NULL, connection_id INT NOT NULL, provider VARCHAR(255) NOT NULL, INDEX IDX_936BF99C9D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE follow (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, follower_id_id INT NOT NULL, INDEX IDX_683444709D86650F (user_id_id), INDEX IDX_68344470E8DDDA11 (follower_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE publication (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, post_id INT NOT NULL, date_time DATETIME NOT NULL, likes_count INT DEFAULT NULL, INDEX IDX_AF3C67799D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, profile_picture VARCHAR(255) DEFAULT NULL, profile_cover VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC9D86650F FOREIGN KEY (user_id_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCE85F12B8 FOREIGN KEY (post_id_id) REFERENCES publication (id)');
        $this->addSql('ALTER TABLE connexion ADD CONSTRAINT FK_936BF99C9D86650F FOREIGN KEY (user_id_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE follow ADD CONSTRAINT FK_683444709D86650F FOREIGN KEY (user_id_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE follow ADD CONSTRAINT FK_68344470E8DDDA11 FOREIGN KEY (follower_id_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C67799D86650F FOREIGN KEY (user_id_id) REFERENCES utilisateur (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC9D86650F');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCE85F12B8');
        $this->addSql('ALTER TABLE connexion DROP FOREIGN KEY FK_936BF99C9D86650F');
        $this->addSql('ALTER TABLE follow DROP FOREIGN KEY FK_683444709D86650F');
        $this->addSql('ALTER TABLE follow DROP FOREIGN KEY FK_68344470E8DDDA11');
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY FK_AF3C67799D86650F');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE connexion');
        $this->addSql('DROP TABLE follow');
        $this->addSql('DROP TABLE publication');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
