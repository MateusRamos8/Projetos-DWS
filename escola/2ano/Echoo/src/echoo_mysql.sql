CREATE TABLE Usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(200) UNIQUE NOT NULL,
    email VARCHAR(200) UNIQUE NOT NULL,
    senha VARCHAR(100) NOT NULL,
    url_imagem VARCHAR(300) DEFAULT 'default-avatar.png',
    --Valores Novos a serem adicionados
    nome VARCHAR(200) NOT NULL,
    bio VARCHAR(200) NOT NULL,
    qtd_posts INTEGER NOT NULL DEFAULT 0,
    seguidores INTEGER NOT NULL DEFAULT 0,
    seguindo INTEGER NOT NULL DEFAULT 0,
    --
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
    WHERE id = NEW.usuario_id;
END$$

DELIMITER ;

DELIMITER $$

CREATE TRIGGER after_post_delete
AFTER DELETE ON posts
FOR EACH ROW
BEGIN
    UPDATE usuarios
    SET qtd_posts = qtd_posts - 1
    WHERE id = OLD.usuario_id;
END$$

DELIMITER ;




--INSERTS RANDONS



INSERT INTO `usuarios`(`username`, `email`, `senha`, `url_imagem`) VALUES ('user','user@gmail.com','$2b$12$1MO1Fvl4037ncfOpvd7TNukSqNjjIVdRLVigTaarwtPIYIWw26yty','https://w7.pngwing.com/pngs/857/213/png-transparent-man-avatar-user-business-avatar-icon.png');
INSERT INTO `usuarios`(`username`, `email`, `senha`, `url_imagem`) VALUES ('user2','user2@gmail.com','$2b$12$xlUwCla/BW.O8.nM9HQf7ObukSOy07zVDVBdciyTlcfwC7vVsbv1G','https://w7.pngwing.com/pngs/857/213/png-transparent-man-avatar-user-business-avatar-icon.png');
INSERT INTO `usuarios`(`username`, `email`, `senha`, `url_imagem`) VALUES ('user3','user3@gmail.com','$2b$12$6lorgtGqZNrNTsymPGoiq.Vkxa.aDnCAL/MGK9nrPTa.pu9jsiucW','https://w7.pngwing.com/pngs/857/213/png-transparent-man-avatar-user-business-avatar-icon.png');
INSERT INTO `usuarios`(`username`, `email`, `senha`, `url_imagem`) VALUES ('user4','user4@gmail.com','$2b$12$ZRIBNOcPqkZtNP3zRf3yGeGTx4mmTvWYKtVZNIIcINz4.y/MijwJ.','https://w7.pngwing.com/pngs/857/213/png-transparent-man-avatar-user-business-avatar-icon.png');
INSERT INTO `usuarios`(`username`, `email`, `senha`, `url_imagem`) VALUES ('user5','user5@gmail.com','$2b$12$OMOaZpK/7RKhqHSFWwvRE.XMOfiaVdFPOH/HCGKhfs8/tKLG4Hrti','https://w7.pngwing.com/pngs/857/213/png-transparent-man-avatar-user-business-avatar-icon.png');
INSERT INTO `usuarios`(`username`, `email`, `senha`, `url_imagem`) VALUES ('user6','user6@gmail.com','$2b$12$e6VBvaJc3PqKNFikY1S2LudDzxT2s7rjUjPo7Zo1PnpC7NewIVqJC','https://w7.pngwing.com/pngs/857/213/png-transparent-man-avatar-user-business-avatar-icon.png');
INSERT INTO `usuarios`(`username`, `email`, `senha`, `url_imagem`) VALUES ('user7','user7@gmail.com','$2b$12$g1Sah46TTj508UumilvHUO.6lQeA.HPMS59dFV.QqAOrin8sguXSq','https://w7.pngwing.com/pngs/857/213/png-transparent-man-avatar-user-business-avatar-icon.png');
INSERT INTO `usuarios`(`username`, `email`, `senha`, `url_imagem`) VALUES ('user8','user8@gmail.com','$2b$12$1h2aKMnsS7fO9AMzypCe.OpKfKbc.EGe0yK8XD6DTIpiVsECpFJyO','https://w7.pngwing.com/pngs/857/213/png-transparent-man-avatar-user-business-avatar-icon.png');
INSERT INTO `usuarios`(`username`, `email`, `senha`, `url_imagem`) VALUES ('user9','user9@gmail.com','$2b$12$jJ3ZzG88LjDDr2Rv99BxZOz5ARS8OcEK4i0zZGrEA5lHHPFZH7Wuq','https://w7.pngwing.com/pngs/857/213/png-transparent-man-avatar-user-business-avatar-icon.png');

INSERT INTO `usuarios`(`username`, `email`, `senha`, `url_imagem`, `administrador`) VALUES ('admin2','admin2@gmail.com','$2b$12$Mte/L32imvDIRXkjkdbPx.8IkLJBC.SsoWj/T8WZlJTleXxcZTFgW','https://cdn-icons-png.flaticon.com/512/971/971904.png', 1);
INSERT INTO `usuarios`(`username`, `email`, `senha`, `url_imagem`, `administrador`) VALUES ('admin3','admin3@gmail.com','$2b$12$xLf5PEgm8CSTLdHpwYHAte1SioNGyRJjaLgB6OWYZ9IBk66GsgEVG','https://cdn-icons-png.flaticon.com/512/971/971904.png', 1);

INSERT INTO `usuarios`(`username`, `email`, `senha`, `url_imagem`, `administrador`) VALUES ('supremo','supremo@gmail.com','$2b$12$sGRlHErwmbTshAynHmRmPOhl4fSHTIzHwLwOqOF3e0VyePSL1YUJG','https://w7.pngwing.com/pngs/335/467/png-transparent-gothic-bible-computer-icons-knowing-god-god-rectangle-prayer-religion.png', 9);

