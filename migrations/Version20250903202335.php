<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250903202335 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE book_user (book_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_940E9D4116A2B381 (book_id), INDEX IDX_940E9D41A76ED395 (user_id), PRIMARY KEY(book_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE book_user ADD CONSTRAINT FK_940E9D4116A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE book_user ADD CONSTRAINT FK_940E9D41A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE book ADD writer_id INT NOT NULL');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A3311BC7E6B6 FOREIGN KEY (writer_id) REFERENCES writer (id)');
        $this->addSql('CREATE INDEX IDX_CBE5A3311BC7E6B6 ON book (writer_id)');
        $this->addSql('ALTER TABLE status ADD reader_id INT NOT NULL');
        $this->addSql('ALTER TABLE status ADD CONSTRAINT FK_7B00651C1717D737 FOREIGN KEY (reader_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_7B00651C1717D737 ON status (reader_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book_user DROP FOREIGN KEY FK_940E9D4116A2B381');
        $this->addSql('ALTER TABLE book_user DROP FOREIGN KEY FK_940E9D41A76ED395');
        $this->addSql('DROP TABLE book_user');
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A3311BC7E6B6');
        $this->addSql('DROP INDEX IDX_CBE5A3311BC7E6B6 ON book');
        $this->addSql('ALTER TABLE book DROP writer_id');
        $this->addSql('ALTER TABLE status DROP FOREIGN KEY FK_7B00651C1717D737');
        $this->addSql('DROP INDEX IDX_7B00651C1717D737 ON status');
        $this->addSql('ALTER TABLE status DROP reader_id');
    }
}
