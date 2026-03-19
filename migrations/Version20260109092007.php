<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260109092007 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Aggiunte relazioni domanda-argomento e riposta-domanda. Rimossa tabella messenger_messanges';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE domanda ADD argomento_id INT NOT NULL');
        $this->addSql('ALTER TABLE domanda ADD CONSTRAINT FK_806230DA8804593C FOREIGN KEY (argomento_id) REFERENCES argomento (id_argomento) NOT DEFERRABLE');
        $this->addSql('CREATE INDEX IDX_806230DA8804593C ON domanda (argomento_id)');
        $this->addSql('ALTER TABLE risposta ADD domanda_id INT NOT NULL');
        $this->addSql('ALTER TABLE risposta ADD CONSTRAINT FK_A50903729AA543D1 FOREIGN KEY (domanda_id) REFERENCES domanda (id_domanda) NOT DEFERRABLE');
        $this->addSql('CREATE INDEX IDX_A50903729AA543D1 ON risposta (domanda_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE domanda DROP CONSTRAINT FK_806230DA8804593C');
        $this->addSql('DROP INDEX IDX_806230DA8804593C');
        $this->addSql('ALTER TABLE domanda DROP argomento_id');
        $this->addSql('ALTER TABLE risposta DROP CONSTRAINT FK_A50903729AA543D1');
        $this->addSql('DROP INDEX IDX_A50903729AA543D1');
        $this->addSql('ALTER TABLE risposta DROP domanda_id');
    }
}
