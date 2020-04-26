CREATE TABLE `log` (
  `interval_start` datetime NOT NULL,
  `interval_end` datetime NOT NULL,
  `counter` int(10) unsigned NOT NULL,
  PRIMARY KEY (`interval_start`),
  KEY `Index_interval_end` (`interval_end`),
  KEY `Index_counter` (`counter`)
) ENGINE=InnoDB;

DELIMITER ;;
CREATE FUNCTION DosageCoefficient (cpm int)
RETURNS float
BEGIN
  IF cpm <= 30 THEN
    RETURN 142.0; -- comply with manual
  END IF;
  IF cpm <= 110 THEN
    -- RETURN 138.3;
    RETURN -0.04625 * cpm + 143.3875; -- own curve, C(30) = 142, C(110) = 138.3
  END IF;
  IF cpm <= 388 THEN
    RETURN -0.08339350180505416 * cpm + 147.56;
  END IF;
  IF cpm <= 1327 THEN
    RETURN -0.01931769722814499 * cpm + 122.5;
  END IF;
  IF cpm <= 4513 THEN
    RETURN -0.004583987441130298 * cpm + 102.65;
  END IF;
  RETURN -0.0009384033800311318 * cpm + 85.706;
END;;
DELIMITER ;

CREATE VIEW `view_cpm` AS SELECT
  CONCAT(DATE(`interval_start`), ' ', HOUR(`interval_start`), ':00:00') AS time,
  `counter` / TIMESTAMPDIFF(MINUTE, `interval_start`, `interval_end`) AS cpm
  FROM `log` WHERE `interval_start` >= '2020-03-25';

CREATE VIEW `view_odl` AS SELECT `time`, `cpm` / DosageCoefficient(`cpm`) AS dosage FROM `view_cpm`;
