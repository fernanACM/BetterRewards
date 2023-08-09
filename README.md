# BetterRewards

[![](https://poggit.pmmp.io/shield.state/BetterRewards)](https://poggit.pmmp.io/p/BetterRewards)

[![](https://poggit.pmmp.io/shield.api/BetterRewards)](https://poggit.pmmp.io/p/BetterRewards)

Daily and monthly rewards, depending on the day of the week. With these rewards you can make your server one of the most fun. Available for PocketMine-MP 5.0 servers

![Captura de pantalla 2023-04-28 161916](https://user-images.githubusercontent.com/83558341/235257406-d5797344-884e-4d26-a71c-26d19adcc605.png)
<a href="https://discord.gg/YyE9XFckqb"><img src="https://img.shields.io/discord/837701868649709568?label=discord&color=7289DA&logo=discord" alt="Discord" /></a>

### 📸 Images
> Here I leave a tutorial of the plugin: [BetterRewards](https://youtu.be/HAAUUf719Ec)

**Main menu**
> You can choose the type of reward you want to receive
<img src="https://user-images.githubusercontent.com/83558341/235257406-d5797344-884e-4d26-a71c-26d19adcc605.png">

**Daily rewards menu**
> Select the day of the week to receive your reward with just one click
<img src="https://user-images.githubusercontent.com/83558341/235257867-2a3d8bc4-f368-4963-af7d-cccfd4e7c5f5.png">

**Monthly rewards menu**
> Receive your monthly reward with this menu
<img src="https://user-images.githubusercontent.com/83558341/235257958-f69b1079-0c59-4186-a92a-da7ea68875d0.png">

**Inventory editing menu**
> Here you can edit the inventory of the objects to receive. It will only work when the ```custom-inventory``` option is ```true```.
<img src="https://user-images.githubusercontent.com/83558341/235258138-f1711b7c-9a96-4913-b5b7-092a375b49f3.png">

### 🌍 Wiki
* Check our plugin [wiki](https://github.com/fernanACM/BetterRewards/wiki) for features and secrets in the...

### 💡 Implementations
* [X] Multilanguage
* [X] Configuration
* [X] Database provider
* [X] Cooldown
* [X] Commands
* [X] inventory editor
* [X] Save item information

### 💾 Config
```yaml
#  ____           _     _                   ____                                         _       
# | __ )    ___  | |_  | |_    ___   _ __  |  _ \    ___  __      __   __ _   _ __    __| |  ___ 
# |  _ \   / _ \ | __| | __|  / _ \ | '__| | |_) |  / _ \ \ \ /\ / /  / _` | | '__|  / _` | / __|
# | |_) | |  __/ | |_  | |_  |  __/ | |    |  _ <  |  __/  \ V  V /  | (_| | | |    | (_| | \__ \
# |____/   \___|  \__|  \__|  \___| |_|    |_| \_\  \___|   \_/\_/    \__,_| |_|     \__,_| |___/
#        by fernanAcM
# Daily and monthly rewards, depending on the day of the week. Available for PocketMine-MP 5.0 servers

# DO NOT TOUCH
config-version: "2.0.1"

# Languages
# "eng", // English
# "spa", // Spanish
# "ger", // German
# "frc", // French
# "indo", // Indonesian
# "portg", // Portuguese
# "vie" // Vietnamese
language: eng

# Prefix plugin
Prefix: "&l&f[&bBetterRewards&f]&8»&r "

# Providers
database:
  # The database type. "sqlite" and "mysql" are supported.
  type: sqlite

  # Edit these settings only if you choose "sqlite".
  sqlite:
    # The file name of the database in the plugin data folder.
    # You can also put an absolute path here.
    file: data.sqlite
  # Edit these settings only if you choose "mysql".
  mysql:
    host: 127.0.0.1
    # Avoid using the "root" user for security reasons.
    username: root
    password: ""
    schema: your_schema
  # The maximum number of simultaneous SQL queries
  # Recommended: 1 for sqlite, 2 for MySQL. You may want to further increase this value if your MySQL connection is very slow.
  worker-limit: 1

# Settings for daily and monthly rewards.
Reward:
  # Here are the rewards with commands, you can add 
  # as many as you can.
  # Use {PLAYER} to identify the player

  # (Rewards for custom inventories)
  # Only works if the (custom-inventory) option 
  # is enabled. But if not, implement the commands in: 
  # weekly-normal-content: []
  monday-commands:
    - "give {PLAYER} apple 24"
    - "give {PLAYER} iron_sword 1"
  tuesday-commands:
    - "give {PLAYER} apple 24"
    - "give {PLAYER} iron_pickaxe 1"
  wednesday-commands:
    - "give {PLAYER} apple 24"
    - "give {PLAYER} diamond_sword 1"
  thursday-commands:
    - "give {PLAYER} apple 24"
    - "give {PLAYER} stone 12"
  friday-commands:
    - "give {PLAYER} apple 24"
    - "give {PLAYER} wool 13"
  saturday-commands:
    - "give {PLAYER} apple 24"
    - "give {PLAYER} iron_block 1"
  sunday-commands:
    - "give {PLAYER} apple 24"
    - "give {PLAYER} book 1"

  # (General rewards)
  weekly-commands:
    - "give {PLAYER} golden_apple 4"
    - "give {PLAYER} stone 12"
  monthly-commands:
    - "give {PLAYER} apple 24"
    - "give {PLAYER} diamond 33"
  # This for rewards with custom items.
  # It only works if the (custom-inventory) option is disabled.
  # Follow this example for custom items:
  
  # ONLY WORKS WITH THESE:
  # weekly-normal-content []
  # monthly-normal-content: []

  # NOTE: Use "&" as a replacement for the minecraft color code
  # weekly-normal-content:
  #   items:
  #     - item: "diamond"
  #       count: 23
  #       name: "A diamond!"
  #       lore:
  #         - "This diamond is very valuable"
  #         - "Careful not to lose it!"
  #       enchantments:
  #         - "sharpness:3"
  #         - "fire_aspect:1"
  #
  # // It also works like this
  # 
  #     - item: "1:0"
  #       count: 32
  #       name: "A stone!"
  #       lore: []
  #       enchantments:
  #         - "protection:3"
  weekly-normal-content:
    items:
      - item: "1:0"
        count: 16
        name: "&r&cA stone!"
        lore:
          - "&r&bBy:&a fernanACM"
        enchantments:
          - "protection:3"
  monthly-normal-content:
    items:
      - item: "stone"
        count: 16
        name: "&r&aA stone!"
        lore: []
        enchantments:
          - "protection:1"

Settings:
  inventory:
    # With this enabled, you will be able to customize 
    # your inventory for a weekly or monthly reward. Use /betterrewards edit
    custom-inventory: false
    # Here you can put the items to receive your daily and 
    # monthly reward. It only works if the (custom-inventory) option is enabled.

    # RECOMMENDATION:
    # If you put 3 and you have 10 items in the custom inventory, you will only receive 3 random 
    # items that are in the inventory, if you want them to have all the items, put the number of 
    # items that are in the custom inventory.

    # You can put /betterrewards count <inventory type>
    # weekly
    monday-items-to-receive: 4
    tuesday-items-to-receive: 2
    wednesday-items-to-receive: 4
    thursday-items-to-receive: 5
    friday-items-to-receive: 1
    saturday-items-to-receive: 6
    sunday-items-to-receive: 5
    # monthly
    monthly-items-to-receive: 5
# TimeMode
TimeMode:
  years: "{YEAR} year(s)"
  months: "{MONTH} month(s)"
  days: "{DAY} day(s)"
  hours: "{HOUR} hour(s)"
  minutes: "{MINUTE} minute(s)"
  seconds: "{SECOND} second(s)"
# Change the name of day
Days:
  monday: Monday
  tuesday: Tuesday
  wednesday: Wednesday
  thursday: Thursday
  friday: Friday
  saturday: Saturday
  sunday: Sunday
```

### 🦴 Item in config.yml
> Create items from here, this will work if the option: ```custom-inventory``` is set to ```false```.
```yml
# Example:
# weekly-normal-content:
#  items:
#    - item: "id"
#        count: 16
#        name: "Name for the item"
#        lore:
#          - "Lore for the item"
#          - "fernanACM"
#        enchantments:
#          - "enchantment:level"

weekly-normal-content:
  items:
    - item: "1:0"
      count: 16
      name: "&r&cA stone!"
      lore: []
      enchantments:
      - "protection:3"
    - item: "wood"
      count: 1
      name: "&r&eA plank of wood"
      lore: []
      enchantments: []
```

### 🕹 Commands
| Command | Description |
|---------|-------------|
| ```/betterrewards``` | Open the main menu |
| ```/betterrewards diary``` | Open daily rewards menu |
| ```/betterrewards monthly``` | Open monthly rewards menu |
| ```/betterrewards edit``` | Open inventory editing menu |
| ```/betterrewards count``` | Count inventory items |

### 🔒 Permissions
| Permission | Description |
|---------|-------------|
| ```betterrewards.cmd.acm:``` | Executing the command |
| ```betterrewards.diary.acm``` | Diary |
| ```betterrewards.monthly.acm``` | Monthly |
| ```betterrewards.edit.acm``` | Edit |

### 🌐 MultiLanguage
| Language | Translated by |
|----------|---------------|
| English | [fernanACM](https://github.com/fernanACM) |
| Spanish | [fernanACM](https://github.com/fernanACM) |
| Indonesian | BetterRewards |
| German | [GamerMJay](https://github.com/GamerMJay) |
| French | BetterRewards |
| Portuguese | BetterRewards |
| Vietnamese | [NhanAZ](https://github.com/NhanAZ) |

### 📢 Report bug
* If you find any bugs in this plugin, please let me know via: [issues](https://github.com/fernanACM/BetterRewards/issues)

### 📞 Contact 
| Redes | Tag | Link |
|-------|-------------|------|
| YouTube | fernanACM | [YouTube](https://www.youtube.com/channel/UC-M5iTrCItYQBg5GMuX5ySw) | 
| Discord | fernanACM#5078 | [Discord](https://discord.gg/YyE9XFckqb) |
| GitHub | fernanACM | [GitHub](https://github.com/fernanACM)
| Poggit | fernanACM | [Poggit](https://poggit.pmmp.io/ci/fernanACM)

### ✔ Credits
| Authors | Github | Lib |
|---------|--------|-----|
| Vecnavium | [Vecnavium](https://github.com/Vecnavium) | [FormsUI](https://github.com/Vecnavium/FormsUI/tree/master/) |
| CortexPE | [CortexPE](https://github.com/CortexPE) | [Commando](https://github.com/CortexPE/Commando/tree/master/) |
| Muqsit | [Muqsit](https://github.com/Muqsit) | [SimplePacketHandler](https://github.com/Muqsit/SimplePacketHandler) |
| Muqsit | [Muqsit](https://github.com/Muqsit) | [InvMenu](https://github.com/Muqsit/InvMenu) |
| DaPigGuy | [DaPigGuy](https://github.com/DaPigGuy) | [libPiggyUpdateChecker](https://github.com/DaPigGuy/libPiggyUpdateChecker) |
| Poggit | [Poggit](https://github.com/poggit) | [libasynql](https://github.com/poggit/libasynql) |
| [jacob3105](https://github.com/jacob3105) | Thanks for your help in the libasynql implementation | |
