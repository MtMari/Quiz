<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260112085227 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Correzione setter risposta';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE domanda ADD CONSTRAINT FK_806230DA8804593C FOREIGN KEY (argomento_id) REFERENCES argomento (id) NOT DEFERRABLE');
        $this->addSql('ALTER TABLE risposta ADD CONSTRAINT FK_A50903729AA543D1 FOREIGN KEY (domanda_id) REFERENCES domanda (id) NOT DEFERRABLE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE domanda DROP CONSTRAINT FK_806230DA8804593C');
        $this->addSql('ALTER TABLE risposta DROP CONSTRAINT FK_A50903729AA543D1');
    }
}
