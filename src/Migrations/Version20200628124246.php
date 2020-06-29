<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200628124246 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE afspraak (id INT AUTO_INCREMENT NOT NULL, klant_id INT NOT NULL, kapper_id INT NOT NULL, dienst_id INT NOT NULL, notities LONGTEXT DEFAULT NULL, datum DATE NOT NULL, begintijd TIME NOT NULL, eindtijd TIME NOT NULL, bevestigd TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_CBC4B2053C427B2F (klant_id), INDEX IDX_CBC4B205CAD0FA10 (kapper_id), INDEX IDX_CBC4B2057DC308 (dienst_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE klant (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL, password VARCHAR(255) NOT NULL, naam VARCHAR(255) NOT NULL, voornaam VARCHAR(255) NOT NULL, postcode INT NOT NULL, gemeente VARCHAR(255) NOT NULL, straat VARCHAR(255) NOT NULL, huisnr VARCHAR(255) NOT NULL, busnr VARCHAR(255) DEFAULT NULL, telnr VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, reg_key VARCHAR(255) NOT NULL, is_enabled TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_BC33ABE1E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE kapper (id INT AUTO_INCREMENT NOT NULL, naam VARCHAR(255) NOT NULL, postcode INT NOT NULL, gemeente VARCHAR(255) NOT NULL, straat VARCHAR(255) NOT NULL, huisnr VARCHAR(255) NOT NULL, busnr VARCHAR(255) DEFAULT NULL, telnr VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE diensten_kapper (id INT AUTO_INCREMENT NOT NULL, diensten_id INT NOT NULL, kapper_id INT NOT NULL, duur INT NOT NULL, prijs INT NOT NULL, INDEX IDX_2EE19D232BF5ECC0 (diensten_id), INDEX IDX_2EE19D23CAD0FA10 (kapper_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE diensten (id INT AUTO_INCREMENT NOT NULL, naam VARCHAR(255) NOT NULL, omschrijving LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE admin (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_880E0D76E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE agenda (id INT AUTO_INCREMENT NOT NULL, kapper_id INT NOT NULL, datum DATE NOT NULL, openingstijd TIME NOT NULL, sluitingstijd TIME NOT NULL, INDEX IDX_2CEDC877CAD0FA10 (kapper_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE afspraak ADD CONSTRAINT FK_CBC4B2053C427B2F FOREIGN KEY (klant_id) REFERENCES klant (id)');
        $this->addSql('ALTER TABLE afspraak ADD CONSTRAINT FK_CBC4B205CAD0FA10 FOREIGN KEY (kapper_id) REFERENCES kapper (id)');
        $this->addSql('ALTER TABLE afspraak ADD CONSTRAINT FK_CBC4B2057DC308 FOREIGN KEY (dienst_id) REFERENCES diensten_kapper (id)');
        $this->addSql('ALTER TABLE diensten_kapper ADD CONSTRAINT FK_2EE19D232BF5ECC0 FOREIGN KEY (diensten_id) REFERENCES diensten (id)');
        $this->addSql('ALTER TABLE diensten_kapper ADD CONSTRAINT FK_2EE19D23CAD0FA10 FOREIGN KEY (kapper_id) REFERENCES kapper (id)');
        $this->addSql('ALTER TABLE agenda ADD CONSTRAINT FK_2CEDC877CAD0FA10 FOREIGN KEY (kapper_id) REFERENCES kapper (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE afspraak DROP FOREIGN KEY FK_CBC4B2053C427B2F');
        $this->addSql('ALTER TABLE afspraak DROP FOREIGN KEY FK_CBC4B205CAD0FA10');
        $this->addSql('ALTER TABLE diensten_kapper DROP FOREIGN KEY FK_2EE19D23CAD0FA10');
        $this->addSql('ALTER TABLE agenda DROP FOREIGN KEY FK_2CEDC877CAD0FA10');
        $this->addSql('ALTER TABLE afspraak DROP FOREIGN KEY FK_CBC4B2057DC308');
        $this->addSql('ALTER TABLE diensten_kapper DROP FOREIGN KEY FK_2EE19D232BF5ECC0');
        $this->addSql('DROP TABLE afspraak');
        $this->addSql('DROP TABLE klant');
        $this->addSql('DROP TABLE kapper');
        $this->addSql('DROP TABLE diensten_kapper');
        $this->addSql('DROP TABLE diensten');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE agenda');
    }
}
