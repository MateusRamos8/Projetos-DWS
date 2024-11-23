CREATE TABLE Usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(200) UNIQUE NOT NULL,
    email VARCHAR(200) UNIQUE NOT NULL,
    senha VARCHAR(100) NOT NULL,
    url_imagem VARCHAR(300) DEFAULT 'default-avatar.png',
    data_criacao DATE NOT NULL,
    administrador INT NOT NULL DEFAULT 0
) ENGINE=InnoDB;

CREATE TABLE Posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(50) UNIQUE NOT NULL,
    conteudo TEXT NOT NULL,
    url_imagem VARCHAR(300) DEFAULT 'default-avatar.png',
    data_criacao DATETIME NOT NULL,
    id_usuario INT,
    FOREIGN KEY (id_usuario) REFERENCES Usuarios(id)
        ON DELETE CASCADE
) ENGINE=InnoDB;