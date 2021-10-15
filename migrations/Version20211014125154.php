<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211014125154 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag_articles (tag_id INT NOT NULL, articles_id INT NOT NULL, INDEX IDX_89EC4AB3BAD26311 (tag_id), INDEX IDX_89EC4AB31EBAF6CC (articles_id), PRIMARY KEY(tag_id, articles_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag_videos (tag_id INT NOT NULL, videos_id INT NOT NULL, INDEX IDX_C0EB2D1EBAD26311 (tag_id), INDEX IDX_C0EB2D1E763C10B2 (videos_id), PRIMARY KEY(tag_id, videos_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tag_articles ADD CONSTRAINT FK_89EC4AB3BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag_articles ADD CONSTRAINT FK_89EC4AB31EBAF6CC FOREIGN KEY (articles_id) REFERENCES articles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag_videos ADD CONSTRAINT FK_C0EB2D1EBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag_videos ADD CONSTRAINT FK_C0EB2D1E763C10B2 FOREIGN KEY (videos_id) REFERENCES videos (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE articles ADD categorie_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE articles ADD CONSTRAINT FK_BFDD3168BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('CREATE INDEX IDX_BFDD3168BCF5E72D ON articles (categorie_id)');
        $this->addSql('ALTER TABLE videos ADD categorie_id INT NOT NULL');
        $this->addSql('ALTER TABLE videos ADD CONSTRAINT FK_29AA6432BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('CREATE INDEX IDX_29AA6432BCF5E72D ON videos (categorie_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE articles DROP FOREIGN KEY FK_BFDD3168BCF5E72D');
        $this->addSql('ALTER TABLE videos DROP FOREIGN KEY FK_29AA6432BCF5E72D');
        $this->addSql('ALTER TABLE tag_articles DROP FOREIGN KEY FK_89EC4AB3BAD26311');
        $this->addSql('ALTER TABLE tag_videos DROP FOREIGN KEY FK_C0EB2D1EBAD26311');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE tag_articles');
        $this->addSql('DROP TABLE tag_videos');
        $this->addSql('DROP INDEX IDX_BFDD3168BCF5E72D ON articles');
        $this->addSql('ALTER TABLE articles DROP categorie_id');
        $this->addSql('DROP INDEX IDX_29AA6432BCF5E72D ON videos');
        $this->addSql('ALTER TABLE videos DROP categorie_id');
    }
}
