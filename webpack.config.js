const path = require("path");

module.exports = {
    entry: {
        main: "./scripts/main.js",
        "character-sheet": "./scripts/character-sheet.js",
        "character-edit": "/scripts/character-edit.js",
        "game-table": "/scripts/game-table.js",
        "characters-manager": "/scripts/characters-manager.js",
        "chat-window": "/scripts/chat-window.js",
        "widget-armor": "/scripts/widget-armor.js",
        "items-filter": "/scripts/items-filter.js",
        "account-settings": "/scripts/account-settings.js",
    },
    mode: "production",
    //mode: "development",
    output: {
        filename: "[name].min.js",
        path: path.resolve(__dirname, "scripts"),
    },

    optimization: {
        usedExports: true,
        sideEffects: true,
    },
};
