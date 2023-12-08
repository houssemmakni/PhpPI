<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231202201125 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article CHANGE titre_article titre_article VARCHAR(100) DEFAULT NULL, CHANGE image image VARCHAR(100) DEFAULT NULL, CHANGE description_article description_article VARCHAR(100) DEFAULT NULL, CHANGE prix prix VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE commande CHANGE nombre nombre VARCHAR(100) DEFAULT NULL, CHANGE addresse_commande addresse_commande VARCHAR(100) DEFAULT NULL, CHANGE nom_prenom_commande nom_prenom_commande VARCHAR(100) DEFAULT NULL, CHANGE tel_commande tel_commande VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT NULL');

    }   

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article CHANGE titre_article titre_article VARCHAR(100) DEFAULT \'NULL\', CHANGE image image VARCHAR(100) DEFAULT \'NULL\', CHANGE description_article description_article VARCHAR(100) DEFAULT \'NULL\', CHANGE prix prix VARCHAR(100) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE commande CHANGE nombre nombre VARCHAR(100) DEFAULT \'NULL\', CHANGE addresse_commande addresse_commande VARCHAR(100) DEFAULT \'NULL\', CHANGE nom_prenom_commande nom_prenom_commande VARCHAR(100) DEFAULT \'NULL\', CHANGE tel_commande tel_commande VARCHAR(100) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT \'NULL\'');
    }
}
