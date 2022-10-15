<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221006154710 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE book_issue_book (book_id INT NOT NULL, issue_book_id INT NOT NULL, INDEX IDX_CAF214E16A2B381 (book_id), INDEX IDX_CAF214EB35AF660 (issue_book_id), PRIMARY KEY(book_id, issue_book_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE book_issue_book ADD CONSTRAINT FK_CAF214E16A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE book_issue_book ADD CONSTRAINT FK_CAF214EB35AF660 FOREIGN KEY (issue_book_id) REFERENCES issue_book (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book_issue_book DROP FOREIGN KEY FK_CAF214E16A2B381');
        $this->addSql('ALTER TABLE book_issue_book DROP FOREIGN KEY FK_CAF214EB35AF660');
        $this->addSql('DROP TABLE book_issue_book');
    }
}
