<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260109141621 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Correzione nome colonna id';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE argomento DROP CONSTRAINT argomento_pkey CASCADE');
        $this->addSql('ALTER TABLE argomento RENAME COLUMN id_argomento TO id');
        $this->addSql('ALTER TABLE argomento ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE domanda DROP CONSTRAINT domanda_pkey CASCADE');
        $this->addSql('ALTER TABLE domanda RENAME COLUMN id_domanda TO id');
        $this->addSql('ALTER TABLE domanda ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE risposta DROP CONSTRAINT risposta_pkey CASCADE');
        $this->addSql('ALTER TABLE risposta RENAME COLUMN id_risposta TO id');
        $this->addSql('ALTER TABLE risposta ADD PRIMARY KEY (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE argomento DROP CONSTRAINT argomento_pkey');
        $this->addSql('ALTER TABLE argomento RENAME COLUMN id TO id_argomento');
        $this->addSql('ALTER TABLE argomento ADD PRIMARY KEY (id_argomento)');
        $this->addSql('ALTER TABLE domanda DROP CONSTRAINT FK_806230DA8804593C');
        $this->addSql('ALTER TABLE domanda DROP CONSTRAINT domanda_pkey');
        $this->addSql('ALTER TABLE domanda RENAME COLUMN id TO id_domanda');
        $this->addSql('ALTER TABLE domanda ADD CONSTRAINT fk_806230da8804593c FOREIGN KEY (argomento_id) REFERENCES argomento (id_argomento) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE domanda ADD PRIMARY KEY (id_domanda)');
        $this->addSql('ALTER TABLE risposta DROP CONSTRAINT FK_A50903729AA543D1');
        $this->addSql('ALTER TABLE risposta DROP CONSTRAINT risposta_pkey');
        $this->addSql('ALTER TABLE risposta RENAME COLUMN id TO id_risposta');
        $this->addSql('ALTER TABLE risposta ADD CONSTRAINT fk_a50903729aa543d1 FOREIGN KEY (domanda_id) REFERENCES domanda (id_domanda) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE risposta ADD PRIMARY KEY (id_risposta)');
    }
}
