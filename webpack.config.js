const path = require('path');

module.exports = {
	entry: {
		main: './scripts/main.js',
		"character-sheet": './scripts/character-sheet.js'
	},
	mode: "production",
	output: {
		filename: '[name].min.js',
		path: path.resolve(__dirname, 'scripts'),
	},
};