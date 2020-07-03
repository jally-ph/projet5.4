<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200703073415 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE books (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, content TEXT NOT NULL, author VARCHAR(255) NOT NULL, date DATETIME NOT NULL, public TINYINT(1) NOT NULL, completed TINYINT(1) NOT NULL, category VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chapter (id INT AUTO_INCREMENT NOT NULL, books_id INT NOT NULL, title VARCHAR(255) NOT NULL, content TEXT NOT NULL, published_date DATETIME NOT NULL, public TINYINT(1) NOT NULL, completed TINYINT(1) NOT NULL, INDEX IDX_F981B52E7DD8AC20 (books_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, chapter_id INT NOT NULL, author VARCHAR(255) NOT NULL, content TEXT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_9474526C579F4768 (chapter_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `like` (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, chapter_id INT DEFAULT NULL, comment_id INT DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_AC6340B3A76ED395 (user_id), INDEX IDX_AC6340B3579F4768 (chapter_id), INDEX IDX_AC6340B3F8697D13 (comment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE chapter ADD CONSTRAINT FK_F981B52E7DD8AC20 FOREIGN KEY (books_id) REFERENCES books (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C579F4768 FOREIGN KEY (chapter_id) REFERENCES chapter (id)');
        $this->addSql('ALTER TABLE `like` ADD CONSTRAINT FK_AC6340B3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE `like` ADD CONSTRAINT FK_AC6340B3579F4768 FOREIGN KEY (chapter_id) REFERENCES chapter (id)');
        $this->addSql('ALTER TABLE `like` ADD CONSTRAINT FK_AC6340B3F8697D13 FOREIGN KEY (comment_id) REFERENCES comment (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chapter DROP FOREIGN KEY FK_F981B52E7DD8AC20');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C579F4768');
        $this->addSql('ALTER TABLE `like` DROP FOREIGN KEY FK_AC6340B3579F4768');
        $this->addSql('ALTER TABLE `like` DROP FOREIGN KEY FK_AC6340B3F8697D13');
        $this->addSql('ALTER TABLE `like` DROP FOREIGN KEY FK_AC6340B3A76ED395');
        $this->addSql('DROP TABLE books');
        $this->addSql('DROP TABLE chapter');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE `like`');
        $this->addSql('DROP TABLE user');
    }
}
