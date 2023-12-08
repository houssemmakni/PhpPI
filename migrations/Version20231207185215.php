<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231207185215 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE abonnement (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, linka_id INT DEFAULT NULL, titre_article VARCHAR(100) DEFAULT NULL, image VARCHAR(100) DEFAULT NULL, description_article VARCHAR(100) DEFAULT NULL, prix VARCHAR(100) DEFAULT NULL, INDEX IDX_23A0E663ACEC799 (linka_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, color VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(100) DEFAULT NULL, addresse_commande VARCHAR(100) DEFAULT NULL, nom_prenom_commande VARCHAR(100) DEFAULT NULL, tel_commande VARCHAR(100) DEFAULT NULL, idarticle VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, total_price VARCHAR(255) DEFAULT NULL, nomarticle VARCHAR(255) DEFAULT NULL, date_commande DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cours (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, duration VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cours_categories (cours_id INT NOT NULL, categories_id INT NOT NULL, INDEX IDX_3F0BB4417ECF78B0 (cours_id), INDEX IDX_3F0BB441A21214B7 (categories_id), PRIMARY KEY(cours_id, categories_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE paiment (id INT AUTO_INCREMENT NOT NULL, abonnement_id INT DEFAULT NULL, date DATE NOT NULL, montant DOUBLE PRECISION NOT NULL, INDEX IDX_DC8138FF1D74413 (abonnement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE planning (id INT AUTO_INCREMENT NOT NULL, cours_id INT DEFAULT NULL, start DATETIME NOT NULL, end DATETIME NOT NULL, all_day TINYINT(1) NOT NULL, background_color VARCHAR(255) NOT NULL, text_color VARCHAR(255) NOT NULL, border_color VARCHAR(255) NOT NULL, INDEX IDX_D499BFF67ECF78B0 (cours_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reclamation (id INT AUTO_INCREMENT NOT NULL, date_reclamation DATETIME NOT NULL, description VARCHAR(255) NOT NULL, status VARCHAR(50) DEFAULT NULL, response VARCHAR(255) DEFAULT NULL, date_reponse DATETIME DEFAULT NULL, subject VARCHAR(255) NOT NULL, user_email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E663ACEC799 FOREIGN KEY (linka_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE cours_categories ADD CONSTRAINT FK_3F0BB4417ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cours_categories ADD CONSTRAINT FK_3F0BB441A21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE paiment ADD CONSTRAINT FK_DC8138FF1D74413 FOREIGN KEY (abonnement_id) REFERENCES abonnement (id)');
        $this->addSql('ALTER TABLE planning ADD CONSTRAINT FK_D499BFF67ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E663ACEC799');
        $this->addSql('ALTER TABLE cours_categories DROP FOREIGN KEY FK_3F0BB4417ECF78B0');
        $this->addSql('ALTER TABLE cours_categories DROP FOREIGN KEY FK_3F0BB441A21214B7');
        $this->addSql('ALTER TABLE paiment DROP FOREIGN KEY FK_DC8138FF1D74413');
        $this->addSql('ALTER TABLE planning DROP FOREIGN KEY FK_D499BFF67ECF78B0');
        $this->addSql('DROP TABLE abonnement');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE cours');
        $this->addSql('DROP TABLE cours_categories');
        $this->addSql('DROP TABLE paiment');
        $this->addSql('DROP TABLE planning');
        $this->addSql('DROP TABLE reclamation');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
