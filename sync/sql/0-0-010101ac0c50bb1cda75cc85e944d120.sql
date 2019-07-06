INSERT INTO `sync` (`id`, `tabla`, `correlativo`, `inicio`, `td`) VALUES (NULL, 'corte_diario', '0', '0', '0');

UPDATE `sync` SET `td` = (SELECT td FROM config_master WHERE id = 1) WHERE tabla = 'corte_diario';