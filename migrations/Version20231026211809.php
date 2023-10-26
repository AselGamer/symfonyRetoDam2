<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231026211809 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE Alquiler (idAlquiler INT AUTO_INCREMENT NOT NULL, fecha_inicio DATE NOT NULL, fecha_fin DATE NOT NULL, fecha_devolucion DOUBLE PRECISION DEFAULT NULL, precio DOUBLE PRECISION NOT NULL, idTransaccion INT DEFAULT NULL, INDEX TransaccionAlquiler (idTransaccion), PRIMARY KEY(idAlquiler)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Articulo (idArticulo INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(50) DEFAULT NULL, precio DOUBLE PRECISION DEFAULT NULL, stock INT NOT NULL, foto VARCHAR(255) DEFAULT NULL, idMarca INT DEFAULT NULL, INDEX MarcaArticulo (idMarca), PRIMARY KEY(idArticulo)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Compra (idCompra INT AUTO_INCREMENT NOT NULL, fecha DATE DEFAULT NULL, idTransaccion INT DEFAULT NULL, INDEX TransaccionCompra (idTransaccion), PRIMARY KEY(idCompra)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Consola (idConsola INT AUTO_INCREMENT NOT NULL, modelo VARCHAR(255) DEFAULT NULL, cant_mandos VARCHAR(30) DEFAULT NULL, almacenamiento VARCHAR(255) DEFAULT NULL, idArticulo INT DEFAULT NULL, INDEX ConsolaArticulo (idArticulo), PRIMARY KEY(idConsola)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE DetalleTransaccion (idDetalleTransaccion INT AUTO_INCREMENT NOT NULL, precio_total DOUBLE PRECISION NOT NULL, idTransaccion INT DEFAULT NULL, idArticulo INT DEFAULT NULL, INDEX DetalleArticulo (idArticulo), INDEX DetalleTransaccion (idTransaccion), PRIMARY KEY(idDetalleTransaccion)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE DispositivoMovil (idDispositivoMovil INT AUTO_INCREMENT NOT NULL, almacenamiento VARCHAR(255) DEFAULT NULL, ram VARCHAR(30) DEFAULT NULL, tamano_pantalla VARCHAR(30) DEFAULT NULL, idArticulo INT DEFAULT NULL, INDEX DispositivoMovilArticulo (idArticulo), PRIMARY KEY(idDispositivoMovil)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Empleado (idEmpleado INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(30) NOT NULL, apellido1 VARCHAR(30) NOT NULL, apellido2 VARCHAR(30) NOT NULL, password VARCHAR(30) NOT NULL, gerente TINYINT(1) NOT NULL, PRIMARY KEY(idEmpleado)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE EstadoReparacion (idEstadoReparacion INT AUTO_INCREMENT NOT NULL, estado VARCHAR(30) NOT NULL, PRIMARY KEY(idEstadoReparacion)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Etiqueta (idEtiqueta INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) DEFAULT NULL, PRIMARY KEY(idEtiqueta)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE EtiquetaVideoJuego (idEtiquetaVideoJuego INT AUTO_INCREMENT NOT NULL, idVideojuego INT DEFAULT NULL, idEtiqueta INT DEFAULT NULL, INDEX EtiquetaVideoJuegoEtiqueta (idEtiqueta), INDEX EtiquetaVideoJuegoVideoJuego (idVideojuego), PRIMARY KEY(idEtiquetaVideoJuego)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Marca (idMarca INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(50) NOT NULL, PRIMARY KEY(idMarca)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Plataforma (idPlataforma INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY(idPlataforma)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE PlataformaConsola (idPlataformaConsola INT AUTO_INCREMENT NOT NULL, idConsola INT DEFAULT NULL, idPlataforma INT DEFAULT NULL, INDEX PlataformaConsola (idConsola), INDEX ConsolaPlataforma (idPlataforma), PRIMARY KEY(idPlataformaConsola)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Reparacion (idReparacion INT AUTO_INCREMENT NOT NULL, problema VARCHAR(255) NOT NULL, comentario_reparacion VARCHAR(255) DEFAULT NULL, fecha_inicio DATE DEFAULT NULL, fecha_fin DATE DEFAULT NULL, precio DOUBLE PRECISION DEFAULT NULL, idUsuario INT DEFAULT NULL, idEstadoReparacion INT DEFAULT NULL, idEmpleado INT DEFAULT NULL, INDEX ReparacionUsuario (idUsuario), INDEX ReparacionEmpleado (idEmpleado), INDEX ReparacionEstadoReparacion (idEstadoReparacion), PRIMARY KEY(idReparacion)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Transaccion (idTransaccion INT AUTO_INCREMENT NOT NULL, latitud VARCHAR(30) DEFAULT NULL, longitud VARCHAR(30) DEFAULT NULL, idUsuario INT DEFAULT NULL, INDEX idUsuario (idUsuario), PRIMARY KEY(idTransaccion)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Usuario (idUsuario INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) DEFAULT NULL, nombre VARCHAR(30) DEFAULT NULL, password VARCHAR(30) DEFAULT NULL, apellido1 VARCHAR(30) DEFAULT NULL, apellido2 VARCHAR(30) DEFAULT NULL, telefono VARCHAR(30) DEFAULT NULL, calle VARCHAR(30) DEFAULT NULL, num_portal VARCHAR(30) DEFAULT NULL, piso VARCHAR(30) DEFAULT NULL, codigo_postal VARCHAR(255) DEFAULT NULL, ciudad VARCHAR(30) DEFAULT NULL, provincia VARCHAR(30) DEFAULT NULL, pais VARCHAR(30) DEFAULT NULL, PRIMARY KEY(idUsuario)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE VideoJuego (idVideojuego INT AUTO_INCREMENT NOT NULL, idPlataforma INT DEFAULT NULL, idArticulo INT DEFAULT NULL, INDEX VideoJuegoArticulo (idArticulo), INDEX VideoJuegoPlataforma (idPlataforma), PRIMARY KEY(idVideojuego)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Alquiler ADD CONSTRAINT FK_9C2D8F6FFFA4958F FOREIGN KEY (idTransaccion) REFERENCES Transaccion (idTransaccion)');
        $this->addSql('ALTER TABLE Articulo ADD CONSTRAINT FK_909F2CC710CE420E FOREIGN KEY (idMarca) REFERENCES Marca (idMarca)');
        $this->addSql('ALTER TABLE Compra ADD CONSTRAINT FK_996D34C9FFA4958F FOREIGN KEY (idTransaccion) REFERENCES Transaccion (idTransaccion)');
        $this->addSql('ALTER TABLE Consola ADD CONSTRAINT FK_FED332333A4A64CA FOREIGN KEY (idArticulo) REFERENCES Articulo (idArticulo)');
        $this->addSql('ALTER TABLE DetalleTransaccion ADD CONSTRAINT FK_71958049FFA4958F FOREIGN KEY (idTransaccion) REFERENCES Transaccion (idTransaccion)');
        $this->addSql('ALTER TABLE DetalleTransaccion ADD CONSTRAINT FK_719580493A4A64CA FOREIGN KEY (idArticulo) REFERENCES Articulo (idArticulo)');
        $this->addSql('ALTER TABLE DispositivoMovil ADD CONSTRAINT FK_6926428A3A4A64CA FOREIGN KEY (idArticulo) REFERENCES Articulo (idArticulo)');
        $this->addSql('ALTER TABLE EtiquetaVideoJuego ADD CONSTRAINT FK_7903DB2528AA7310 FOREIGN KEY (idVideojuego) REFERENCES VideoJuego (idVideojuego)');
        $this->addSql('ALTER TABLE EtiquetaVideoJuego ADD CONSTRAINT FK_7903DB253EFF8C61 FOREIGN KEY (idEtiqueta) REFERENCES Etiqueta (idEtiqueta)');
        $this->addSql('ALTER TABLE PlataformaConsola ADD CONSTRAINT FK_E2D527DD21D7605D FOREIGN KEY (idConsola) REFERENCES Consola (idConsola)');
        $this->addSql('ALTER TABLE PlataformaConsola ADD CONSTRAINT FK_E2D527DD220A94F4 FOREIGN KEY (idPlataforma) REFERENCES Plataforma (idPlataforma)');
        $this->addSql('ALTER TABLE Reparacion ADD CONSTRAINT FK_D4C4D6B32DCDBAF FOREIGN KEY (idUsuario) REFERENCES Usuario (idUsuario)');
        $this->addSql('ALTER TABLE Reparacion ADD CONSTRAINT FK_D4C4D6B1D20DB19 FOREIGN KEY (idEstadoReparacion) REFERENCES EstadoReparacion (idEstadoReparacion)');
        $this->addSql('ALTER TABLE Reparacion ADD CONSTRAINT FK_D4C4D6B8A7A9509 FOREIGN KEY (idEmpleado) REFERENCES Empleado (idEmpleado)');
        $this->addSql('ALTER TABLE Transaccion ADD CONSTRAINT FK_3965E52032DCDBAF FOREIGN KEY (idUsuario) REFERENCES Usuario (idUsuario)');
        $this->addSql('ALTER TABLE VideoJuego ADD CONSTRAINT FK_24C2412E220A94F4 FOREIGN KEY (idPlataforma) REFERENCES Plataforma (idPlataforma)');
        $this->addSql('ALTER TABLE VideoJuego ADD CONSTRAINT FK_24C2412E3A4A64CA FOREIGN KEY (idArticulo) REFERENCES Articulo (idArticulo)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE Alquiler DROP FOREIGN KEY FK_9C2D8F6FFFA4958F');
        $this->addSql('ALTER TABLE Articulo DROP FOREIGN KEY FK_909F2CC710CE420E');
        $this->addSql('ALTER TABLE Compra DROP FOREIGN KEY FK_996D34C9FFA4958F');
        $this->addSql('ALTER TABLE Consola DROP FOREIGN KEY FK_FED332333A4A64CA');
        $this->addSql('ALTER TABLE DetalleTransaccion DROP FOREIGN KEY FK_71958049FFA4958F');
        $this->addSql('ALTER TABLE DetalleTransaccion DROP FOREIGN KEY FK_719580493A4A64CA');
        $this->addSql('ALTER TABLE DispositivoMovil DROP FOREIGN KEY FK_6926428A3A4A64CA');
        $this->addSql('ALTER TABLE EtiquetaVideoJuego DROP FOREIGN KEY FK_7903DB2528AA7310');
        $this->addSql('ALTER TABLE EtiquetaVideoJuego DROP FOREIGN KEY FK_7903DB253EFF8C61');
        $this->addSql('ALTER TABLE PlataformaConsola DROP FOREIGN KEY FK_E2D527DD21D7605D');
        $this->addSql('ALTER TABLE PlataformaConsola DROP FOREIGN KEY FK_E2D527DD220A94F4');
        $this->addSql('ALTER TABLE Reparacion DROP FOREIGN KEY FK_D4C4D6B32DCDBAF');
        $this->addSql('ALTER TABLE Reparacion DROP FOREIGN KEY FK_D4C4D6B1D20DB19');
        $this->addSql('ALTER TABLE Reparacion DROP FOREIGN KEY FK_D4C4D6B8A7A9509');
        $this->addSql('ALTER TABLE Transaccion DROP FOREIGN KEY FK_3965E52032DCDBAF');
        $this->addSql('ALTER TABLE VideoJuego DROP FOREIGN KEY FK_24C2412E220A94F4');
        $this->addSql('ALTER TABLE VideoJuego DROP FOREIGN KEY FK_24C2412E3A4A64CA');
        $this->addSql('DROP TABLE Alquiler');
        $this->addSql('DROP TABLE Articulo');
        $this->addSql('DROP TABLE Compra');
        $this->addSql('DROP TABLE Consola');
        $this->addSql('DROP TABLE DetalleTransaccion');
        $this->addSql('DROP TABLE DispositivoMovil');
        $this->addSql('DROP TABLE Empleado');
        $this->addSql('DROP TABLE EstadoReparacion');
        $this->addSql('DROP TABLE Etiqueta');
        $this->addSql('DROP TABLE EtiquetaVideoJuego');
        $this->addSql('DROP TABLE Marca');
        $this->addSql('DROP TABLE Plataforma');
        $this->addSql('DROP TABLE PlataformaConsola');
        $this->addSql('DROP TABLE Reparacion');
        $this->addSql('DROP TABLE Transaccion');
        $this->addSql('DROP TABLE Usuario');
        $this->addSql('DROP TABLE VideoJuego');
    }
}
