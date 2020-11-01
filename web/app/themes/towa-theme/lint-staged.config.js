module.exports = {
  "*.js": ["eslint --fix", "prettier --write", "git add"],
  "*.json": ["prettier --write", "git add"],
  "*.vue": ["eslint --fix", "stylelint --fix", "prettier --write", "git add"],
  "*.php": [
    "./../../../../vendor/bin/php-cs-fixer fix --config=./../../../../.php_cs",
    "git add"
  ]
};
