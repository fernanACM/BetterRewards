-- #! mysql
-- #{ betterrewards

-- #  { init
CREATE TABLE IF NOT EXISTS cooldowns (
    player VARCHAR(255),
    cooldown_id VARCHAR(255),
    expiration INT
    );
-- #  }

-- #    { addcooldown
-- # 	  :player string
-- # 	  :cooldown_id string
-- # 	  :expiration int
INSERT INTO cooldowns (player, cooldown_id, expiration) VALUES (:player, :cooldown_id, :expiration);
-- #  }

-- #    { removecooldown
-- # 	  :player string
-- # 	  :cooldown_id string
DELETE FROM cooldowns WHERE player = :player AND cooldown_id = :cooldown_id;
-- #  }

-- #    { getcooldown
-- # 	  :player string
-- # 	  :cooldown_id string
SELECT * FROM cooldowns WHERE player = :player AND cooldown_id = :cooldown_id;
-- #  }
-- #}