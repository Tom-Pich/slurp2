const path = require('path');

module.exports = {
	entry: {
		"main": './scripts/main.js',
		"character-sheet": './scripts/character-sheet.js',
		"character-edit" : "/scripts/character-edit.js",
		"game-table" : "/scripts/game-table.js",
		"characters-manager" : "/scripts/characters-manager.js",
	},
	mode: "production",
	output: {
		filename: '[name].min.js',
		path: path.resolve(__dirname, 'scripts'),
	},
};