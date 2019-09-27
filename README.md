# About
Application displays simple html table with tasks from trello.

Board id and tasks ids are defined in .env file.

# Installation 

* git clone
* composer install
* copy .env.example to .env
* set parameters in .env

# .env PARAMETERS

You can find your API_KEY and TOKEN on page https://trello.com/app-key

Copy BOARD_ID form trello url of the board `https://trello.com/b/<BOARD_ID>/<BOARD_NAME>`

CARD_IDS is coma-separated list of card short-ids (they are shown in trello as #1000, #1002, etc.)
