-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS Configurador_Ordenadores;
USE Configurador_Ordenadores;

-- Tabla USUARIO
CREATE TABLE IF NOT EXISTS USUARIO (
    usuario_id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_nombre VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    admin BOOLEAN NOT NULL
);

-- Tabla MARCA
CREATE TABLE IF NOT EXISTS MARCA (
    marca_id INT AUTO_INCREMENT PRIMARY KEY,
    marca_nombre VARCHAR(100) NOT NULL
);

-- Tabla PLACA BASE
CREATE TABLE IF NOT EXISTS PLACA_BASE (
    placa_id INT AUTO_INCREMENT PRIMARY KEY,
    placa_nombre VARCHAR(100) NOT NULL,
    placa_precio DOUBLE(6,2),
    marca_id INT,    
    FOREIGN KEY (marca_id) REFERENCES MARCA(marca_id)
);

-- Tabla CAJA
CREATE TABLE IF NOT EXISTS CAJA (
    caja_id INT AUTO_INCREMENT PRIMARY KEY,
    caja_nombre VARCHAR(100) NOT NULL,
    caja_precio DOUBLE(6,2),
    marca_id INT,
    FOREIGN KEY (marca_id) REFERENCES MARCA(marca_id)
);

-- Tabla PROCESADOR
CREATE TABLE IF NOT EXISTS PROCESADOR (
    proc_id INT AUTO_INCREMENT PRIMARY KEY,
    proc_nombre VARCHAR(100) NOT NULL,
    gHz FLOAT NOT NULL,
    nucleos INT NOT NULL,
    proc_precio DOUBLE(6,2),	
    marca_id INT,
    FOREIGN KEY (marca_id) REFERENCES MARCA(marca_id)
);

-- Tabla TARJETA GRAFICA
CREATE TABLE IF NOT EXISTS TARJETA_GRAFICA (
    grafica_id INT AUTO_INCREMENT PRIMARY KEY,
    grafica_nombre VARCHAR(100) NOT NULL,
    grafica_Gb INT NOT NULL,
    rtx BOOLEAN NOT NULL,
    grafica_precio DOUBLE(6,2),	
    marca_id INT,
    FOREIGN KEY (marca_id) REFERENCES MARCA(marca_id)
);

-- Tabla RAM
CREATE TABLE IF NOT EXISTS RAM (
    ram_id INT AUTO_INCREMENT PRIMARY KEY,
    ram_nombre VARCHAR(100) NOT NULL,
    ram_gb INT NOT NULL,
    ram_mhz INT NOT NULL,
    ram_precio DOUBLE(6,2),
    marca_id INT,
    FOREIGN KEY (marca_id) REFERENCES MARCA(marca_id)
);

-- Tabla DISCO DURO
CREATE TABLE IF NOT EXISTS DISCO_DURO (
    discoDuro_id INT AUTO_INCREMENT PRIMARY KEY,
    discoDuro_nombre VARCHAR(100) NOT NULL,
    capacidad INT NOT NULL,
    tipo VARCHAR(50) NOT NULL,
    discoDuro_precio DOUBLE(6,2),
    marca_id INT,
    FOREIGN KEY (marca_id) REFERENCES MARCA(marca_id)
);

-- Tabla ORDENADOR
CREATE TABLE IF NOT EXISTS ORDENADOR (
    ord_id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    placa_id INT,
    caja_id INT,
    proc_id INT,
    grafica_id INT,
    ram_id INT,
    discoDuro_id INT,
    FOREIGN KEY (usuario_id) REFERENCES USUARIO(usuario_id) ON DELETE CASCADE,
    FOREIGN KEY (placa_id) REFERENCES PLACA_BASE(placa_id) ON DELETE SET NULL,
    FOREIGN KEY (caja_id) REFERENCES CAJA(caja_id) ON DELETE SET NULL,
    FOREIGN KEY (proc_id) REFERENCES PROCESADOR(proc_id) ON DELETE SET NULL,
    FOREIGN KEY (grafica_id) REFERENCES TARJETA_GRAFICA(grafica_id) ON DELETE SET NULL,
    FOREIGN KEY (ram_id) REFERENCES RAM(ram_id) ON DELETE SET NULL,
    FOREIGN KEY (discoDuro_id) REFERENCES DISCO_DURO(discoDuro_id) ON DELETE SET NULL
);



-- Inserciones 

-- Inserciones para la tabla MARCA
INSERT INTO MARCA (marca_nombre) VALUES
('Intel'),
('AMD'),
('NVIDIA'),
('Kingston'),
('Corsair'),
('Seagate'),
('Western Digital'),
('Gigabyte'),
('ASUS'),
('MSI');

-- Inserciones para la tabla PLACA_BASE
INSERT INTO PLACA_BASE (placa_nombre, placa_precio, marca_id) VALUES
('Gigabyte Z590 AORUS', 189.99, 8),
('ASUS ROG STRIX B450-F', 129.99, 9),
('MSI MPG Z690', 229.99, 10),
('Gigabyte B660 DS3H', 99.99, 8),
('ASUS PRIME B550-PLUS', 114.99, 9),
('MSI MAG B560', 139.99, 10),
('ASUS TUF GAMING X570', 189.99, 9),
('Gigabyte X670 AORUS ELITE', 249.99, 8),
('MSI PRO B760-P', 129.99, 10),
('ASUS ROG Crosshair VIII', 379.99, 9);

-- Inserciones para la tabla CAJA
INSERT INTO CAJA (caja_nombre, caja_precio, marca_id) VALUES
('Corsair 4000D', 94.99, 5),
('NZXT H510', 79.99, 5),
('Cooler Master MasterBox', 59.99, 5),
('Thermaltake V200', 54.99, 5),
('Phanteks Eclipse P300A', 49.99, 5),
('Be Quiet! Pure Base 500DX', 99.99, 5),
('Fractal Design Meshify C', 89.99, 5),
('Corsair iCUE 220T', 109.99, 5),
('Cooler Master NR200P', 79.99, 5),
('Lian Li Lancool II', 129.99, 5);

-- Inserciones para la tabla PROCESADOR
INSERT INTO PROCESADOR (proc_nombre, gHz, nucleos, proc_precio, marca_id) VALUES
('Intel Core i5-11400F', 2.6, 6, 149.99, 1),
('AMD Ryzen 5 5600X', 3.7, 6, 199.99, 2),
('Intel Core i7-12700K', 3.6, 12, 399.99, 1),
('AMD Ryzen 7 5800X', 3.8, 8, 299.99, 2),
('Intel Core i9-12900K', 3.2, 16, 589.99, 1),
('AMD Ryzen 9 5900X', 3.7, 12, 499.99, 2),
('Intel Core i3-10100F', 3.6, 4, 99.99, 1),
('AMD Ryzen 3 3100', 3.6, 4, 119.99, 2),
('Intel Core i5-12600K', 3.7, 10, 279.99, 1),
('AMD Ryzen 5 7600X', 4.7, 6, 299.99, 2);

-- Inserciones para la tabla TARJETA_GRAFICA
INSERT INTO TARJETA_GRAFICA (grafica_nombre, grafica_Gb, rtx, grafica_precio, marca_id) VALUES
('NVIDIA GeForce RTX 3060', 12, TRUE, 329.99, 3),
('NVIDIA GeForce GTX 1660 Super', 6, FALSE, 229.99, 3),
('AMD Radeon RX 6600 XT', 8, FALSE, 379.99, 2),
('NVIDIA GeForce RTX 3070', 8, TRUE, 499.99, 3),
('AMD Radeon RX 6800', 16, FALSE, 579.99, 2),
('NVIDIA GeForce RTX 3080', 10, TRUE, 699.99, 3),
('AMD Radeon RX 6900 XT', 16, FALSE, 999.99, 2),
('NVIDIA GeForce RTX 3090', 24, TRUE, 1499.99, 3),
('AMD Radeon RX 6400', 4, FALSE, 159.99, 2),
('NVIDIA GeForce GTX 1050 Ti', 4, FALSE, 149.99, 3);

-- Inserciones para la tabla RAM
INSERT INTO RAM (ram_nombre, ram_gb, ram_mhz, ram_precio, marca_id) VALUES
('Kingston Fury Beast 16GB', 16, 3200, 74.99, 4),
('Corsair Vengeance LPX 16GB', 16, 3200, 79.99, 5),
('G.Skill Trident Z RGB 32GB', 32, 3600, 189.99, 4),
('Crucial Ballistix 8GB', 8, 2666, 39.99, 4),
('Corsair Dominator Platinum RGB 16GB', 16, 3600, 114.99, 5),
('TeamGroup T-Force Delta RGB 32GB', 32, 3200, 149.99, 4),
('Kingston HyperX Fury 8GB', 8, 2400, 34.99, 4),
('Corsair Vengeance RGB Pro 16GB', 16, 3200, 94.99, 5),
('Patriot Viper Steel 16GB', 16, 3000, 69.99, 4),
('G.Skill Ripjaws V 32GB', 32, 3200, 169.99, 4);

-- Inserciones para la tabla DISCO_DURO
INSERT INTO DISCO_DURO (discoDuro_nombre, capacidad, tipo, discoDuro_precio, marca_id) VALUES
('Seagate Barracuda 1TB', 1000, 'HDD', 49.99, 6),
('Western Digital Blue 1TB', 1000, 'HDD', 54.99, 7),
('Samsung 970 EVO Plus 500GB', 500, 'SSD', 99.99, 6),
('Crucial MX500 1TB', 1000, 'SSD', 114.99, 4),
('Western Digital Black SN850 1TB', 1000, 'SSD', 189.99, 7),
('Seagate FireCuda 2TB', 2000, 'HDD', 89.99, 6),
('Kingston A2000 500GB', 500, 'SSD', 59.99, 4),
('Samsung 980 PRO 2TB', 2000, 'SSD', 249.99, 6),
('Crucial BX500 480GB', 480, 'SSD', 39.99, 4),
('Western Digital Elements 4TB', 4000, 'HDD', 129.99, 7);

