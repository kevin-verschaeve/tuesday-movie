<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160927223704 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE movie (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, proposed_by VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE movie_voters (movie_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_F05837648F93B6FC (movie_id), INDEX IDX_F0583764A76ED395 (user_id), PRIMARY KEY(movie_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE session_movies (session_id INT NOT NULL, movie_id INT NOT NULL, INDEX IDX_A975E769613FECDF (session_id), INDEX IDX_A975E7698F93B6FC (movie_id), PRIMARY KEY(session_id, movie_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, ipAddress VARCHAR(60) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE movie_voters ADD CONSTRAINT FK_F05837648F93B6FC FOREIGN KEY (movie_id) REFERENCES movie (id)');
        $this->addSql('ALTER TABLE movie_voters ADD CONSTRAINT FK_F0583764A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE session_movies ADD CONSTRAINT FK_A975E769613FECDF FOREIGN KEY (session_id) REFERENCES session (id)');
        $this->addSql('ALTER TABLE session_movies ADD CONSTRAINT FK_A975E7698F93B6FC FOREIGN KEY (movie_id) REFERENCES movie (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE movie_voters DROP FOREIGN KEY FK_F05837648F93B6FC');
        $this->addSql('ALTER TABLE session_movies DROP FOREIGN KEY FK_A975E7698F93B6FC');
        $this->addSql('ALTER TABLE movie_voters DROP FOREIGN KEY FK_F0583764A76ED395');
        $this->addSql('DROP TABLE movie');
        $this->addSql('DROP TABLE movie_voters');
        $this->addSql('DROP TABLE session_movies');
        $this->addSql('DROP TABLE user');
    }
}
