<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231113190736 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__classeur_tux AS SELECT id, membre_tux_id, name FROM classeur_tux');
        $this->addSql('DROP TABLE classeur_tux');
        $this->addSql('CREATE TABLE classeur_tux (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, membre_tux_id INTEGER DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_66709D1FBDC18023 FOREIGN KEY (membre_tux_id) REFERENCES membre_tux (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO classeur_tux (id, membre_tux_id, name) SELECT id, membre_tux_id, name FROM __temp__classeur_tux');
        $this->addSql('DROP TABLE __temp__classeur_tux');
        $this->addSql('CREATE INDEX IDX_66709D1FBDC18023 ON classeur_tux (membre_tux_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__membre_tux AS SELECT id, role, pseudo FROM membre_tux');
        $this->addSql('DROP TABLE membre_tux');
        $this->addSql('CREATE TABLE membre_tux (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, role VARCHAR(255) NOT NULL, pseudo VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO membre_tux (id, role, pseudo) SELECT id, role, pseudo FROM __temp__membre_tux');
        $this->addSql('DROP TABLE __temp__membre_tux');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__classeur_tux AS SELECT id, membre_tux_id, name FROM classeur_tux');
        $this->addSql('DROP TABLE classeur_tux');
        $this->addSql('CREATE TABLE classeur_tux (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, membre_tux_id INTEGER DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_66709D1FBDC18023 FOREIGN KEY (membre_tux_id) REFERENCES membre_tux (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO classeur_tux (id, membre_tux_id, name) SELECT id, membre_tux_id, name FROM __temp__classeur_tux');
        $this->addSql('DROP TABLE __temp__classeur_tux');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_66709D1FBDC18023 ON classeur_tux (membre_tux_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__membre_tux AS SELECT id, role, pseudo FROM membre_tux');
        $this->addSql('DROP TABLE membre_tux');
        $this->addSql('CREATE TABLE membre_tux (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, classeurtux_id INTEGER DEFAULT NULL, role VARCHAR(255) NOT NULL, pseudo VARCHAR(255) NOT NULL, CONSTRAINT FK_5D9834C963BEB4BA FOREIGN KEY (classeurtux_id) REFERENCES classeur_tux (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO membre_tux (id, role, pseudo) SELECT id, role, pseudo FROM __temp__membre_tux');
        $this->addSql('DROP TABLE __temp__membre_tux');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5D9834C963BEB4BA ON membre_tux (classeurtux_id)');
    }
}
