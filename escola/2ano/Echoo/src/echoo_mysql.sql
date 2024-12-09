CREATE TABLE Usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(200) UNIQUE NOT NULL,
    email VARCHAR(200) UNIQUE NOT NULL,
    senha VARCHAR(100) NOT NULL,
    url_imagem VARCHAR(300),
 
    nome VARCHAR(200) NOT NULL DEFAULT '0',
    bio VARCHAR(200) NOT NULL DEFAULT 'Usuário do Echoo',
    qtd_posts INTEGER NOT NULL DEFAULT 0,
    seguidores INTEGER NOT NULL DEFAULT 0,
    seguindo INTEGER NOT NULL DEFAULT 0,
    
    data_criacao DATE NOT NULL DEFAULT CURRENT_DATE,
    administrador INT NOT NULL DEFAULT 0
) ENGINE=InnoDB;

CREATE TABLE seguidores(
    id_seguidor INT NOT NULL,
    id_seguido INT NOT NULL,
    PRIMARY KEY (id_seguidor, id_seguido),
    FOREIGN KEY (id_seguidor) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (id_seguido) REFERENCES usuarios(id) ON DELETE CASCADE
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


DELIMITER $$

CREATE TRIGGER after_post_insert
AFTER INSERT ON posts
FOR EACH ROW
BEGIN
    UPDATE usuarios
    SET qtd_posts = qtd_posts + 1
    WHERE id = NEW.id_usuario;
END$$

DELIMITER ;

--Ta dando ruim

DELIMITER $$

CREATE TRIGGER after_post_delete
AFTER DELETE ON posts
FOR EACH ROW
BEGIN
    UPDATE usuarios
    SET qtd_posts = qtd_posts - 1
    WHERE id = OLD.id_usuario;
END$$

DELIMITER ;

CREATE TABLE chats (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100),
    last_message TEXT,
    url_imagem_icon varchar(400),
    url_imagem_background varchar(400),
    is_group BOOLEAN NOT NULL,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE chat_users (
    id_chat INT NOT NULL,
    id_usuario INT NOT NULL,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id_chat, id_usuario),
    FOREIGN KEY (id_chat) REFERENCES chats(id),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
);

CREATE TABLE messages (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_chat INT NOT NULL,
    id_sender INT NOT NULL,
    message TEXT NOT NULL,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_chat) REFERENCES chats(id),
    FOREIGN KEY (id_sender) REFERENCES usuarios(id)
);

CREATE TABLE message_read_status (
    id_mensagem INT NOT NULL,
    id_usuario INT NOT NULL,
    data_leitura TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id_mensagem, id_usuario),
    FOREIGN KEY (id_mensagem) REFERENCES messages(id),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
);


DELIMITER $$

CREATE TRIGGER after_message_insert
AFTER INSERT ON messages
FOR EACH ROW
BEGIN
    DECLARE sender_name VARCHAR(100);

    -- Obtém o nome do remetente
    SELECT username INTO sender_name
    FROM usuarios
    WHERE id = NEW.id_sender;

    -- Atualiza o campo last_message no chat
    IF (SELECT is_group FROM chats WHERE id = NEW.id_chat) = 1 THEN
        -- Para grupos: "Nome do usuário: Mensagem"
        UPDATE chats
        SET last_message = CONCAT(sender_name, ': ', NEW.message)
        WHERE id = NEW.id_chat;
    ELSE
        -- Para chats privados: apenas a mensagem
        UPDATE chats
        SET last_message = NEW.message
        WHERE id = NEW.id_chat;
    END IF;
END$$

DELIMITER ;

DELIMITER $$

CREATE TRIGGER after_message_insert_read_status
AFTER INSERT ON messages
FOR EACH ROW
BEGIN
    -- Insere um registro na tabela de status de leitura para o remetente
    INSERT INTO message_read_status (id_mensagem, id_usuario)
    VALUES (NEW.id, NEW.id_sender);
END$$

DELIMITER ;


--DELETES

-- Desabilitar verificações de chave estrangeira temporariamente
SET FOREIGN_KEY_CHECKS = 0;

-- Apagar tabelas na ordem correta
DROP TABLE IF EXISTS message_read_status;
DROP TABLE IF EXISTS messages;
DROP TABLE IF EXISTS chat_users;
DROP TABLE IF EXISTS chats;
DROP TABLE IF EXISTS seguidores;
DROP TABLE IF EXISTS posts;
DROP TABLE IF EXISTS usuarios;

-- Habilitar verificações de chave estrangeira novamente
SET FOREIGN_KEY_CHECKS = 1;

-- Remover todos os triggers criados
DROP TRIGGER IF EXISTS after_post_insert;
DROP TRIGGER IF EXISTS after_post_delete;
DROP TRIGGER IF EXISTS after_message_insert;
DROP TRIGGER IF EXISTS after_message_insert_read_status;

-- Pronto, tudo foi removido!




--INSERTS RANDONS



INSERT INTO `usuarios`(`username`, `nome`, `email`, `senha`, `url_imagem`) VALUES ('user','uuser','user@gmail.com','$2b$12$1MO1Fvl4037ncfOpvd7TNukSqNjjIVdRLVigTaarwtPIYIWw26yty','https://w7.pngwing.com/pngs/857/213/png-transparent-man-avatar-user-business-avatar-icon.png');
INSERT INTO `usuarios`(`username`, `nome`, `email`, `senha`, `url_imagem`) VALUES ('user2','uuser2','user2@gmail.com','$2b$12$xlUwCla/BW.O8.nM9HQf7ObukSOy07zVDVBdciyTlcfwC7vVsbv1G','https://w7.pngwing.com/pngs/857/213/png-transparent-man-avatar-user-business-avatar-icon.png');
INSERT INTO `usuarios`(`username`, `nome`, `email`, `senha`, `url_imagem`) VALUES ('user3','uuser3','user3@gmail.com','$2b$12$6lorgtGqZNrNTsymPGoiq.Vkxa.aDnCAL/MGK9nrPTa.pu9jsiucW','https://w7.pngwing.com/pngs/857/213/png-transparent-man-avatar-user-business-avatar-icon.png');
INSERT INTO `usuarios`(`username`, `nome`, `email`, `senha`, `url_imagem`) VALUES ('user4','uuser4','user4@gmail.com','$2b$12$ZRIBNOcPqkZtNP3zRf3yGeGTx4mmTvWYKtVZNIIcINz4.y/MijwJ.','https://w7.pngwing.com/pngs/857/213/png-transparent-man-avatar-user-business-avatar-icon.png');
INSERT INTO `usuarios`(`username`, `nome`, `email`, `senha`, `url_imagem`) VALUES ('user5','uuser5','user5@gmail.com','$2b$12$OMOaZpK/7RKhqHSFWwvRE.XMOfiaVdFPOH/HCGKhfs8/tKLG4Hrti','https://w7.pngwing.com/pngs/857/213/png-transparent-man-avatar-user-business-avatar-icon.png');
INSERT INTO `usuarios`(`username`, `nome`, `email`, `senha`, `url_imagem`) VALUES ('user6','uuser6','user6@gmail.com','$2b$12$e6VBvaJc3PqKNFikY1S2LudDzxT2s7rjUjPo7Zo1PnpC7NewIVqJC','https://w7.pngwing.com/pngs/857/213/png-transparent-man-avatar-user-business-avatar-icon.png');
INSERT INTO `usuarios`(`username`, `nome`, `email`, `senha`, `url_imagem`) VALUES ('user7','uuser7','user7@gmail.com','$2b$12$g1Sah46TTj508UumilvHUO.6lQeA.HPMS59dFV.QqAOrin8sguXSq','https://w7.pngwing.com/pngs/857/213/png-transparent-man-avatar-user-business-avatar-icon.png');
INSERT INTO `usuarios`(`username`, `nome`, `email`, `senha`, `url_imagem`) VALUES ('user8','uuser8','user8@gmail.com','$2b$12$1h2aKMnsS7fO9AMzypCe.OpKfKbc.EGe0yK8XD6DTIpiVsECpFJyO','https://w7.pngwing.com/pngs/857/213/png-transparent-man-avatar-user-business-avatar-icon.png');
INSERT INTO `usuarios`(`username`, `nome`, `email`, `senha`, `url_imagem`) VALUES ('user9','uuser9','user9@gmail.com','$2b$12$jJ3ZzG88LjDDr2Rv99BxZOz5ARS8OcEK4i0zZGrEA5lHHPFZH7Wuq','https://w7.pngwing.com/pngs/857/213/png-transparent-man-avatar-user-business-avatar-icon.png');
INSERT INTO `usuarios`(`username`, `nome`, `email`, `senha`) VALUES ('user9c','uuser9c','user9c@gmail.com','$2b$12$jJ3ZzG88LjDDr2Rv99BxZOz5ARS8OcEK4i0zZGrEA5lHHPFZH7Wuq');

INSERT INTO `usuarios`(`username`, `nome`, `email`, `senha`, `url_imagem`, `administrador`) VALUES ('admin2','aadmin2','admin2@gmail.com','$2b$12$Mte/L32imvDIRXkjkdbPx.8IkLJBC.SsoWj/T8WZlJTleXxcZTFgW','https://cdn-icons-png.flaticon.com/512/971/971904.png', 1);
INSERT INTO `usuarios`(`username`, `nome`, `email`, `senha`, `url_imagem`, `administrador`) VALUES ('admin3','aadmin3', 'admin3@gmail.com','$2b$12$xLf5PEgm8CSTLdHpwYHAte1SioNGyRJjaLgB6OWYZ9IBk66GsgEVG','https://cdn-icons-png.flaticon.com/512/971/971904.png', 1);

INSERT INTO `usuarios`(`username`, `nome`, `email`, `senha`, `url_imagem`, `administrador`) VALUES ('supremo','ssupremo','supremo@gmail.com','$2b$12$sGRlHErwmbTshAynHmRmPOhl4fSHTIzHwLwOqOF3e0VyePSL1YUJG','https://super.abril.com.br/wp-content/uploads/2018/07/alexandre-o-grande-banner-650x330.jpg?crop=1&resize=1212,909', 9);

