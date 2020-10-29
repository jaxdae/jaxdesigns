/* eslint-disable no-console */
const fs = require("fs");
const chalk = require("chalk");

// use third argument from command line
const componentName = process.argv[2];

const files = [
  {
    name: `${componentName}.scss`,
    content: `.${componentName} {
  background-color: DeepSkyBlue;
  color: white;
  padding: 10px;
}
`
  },
  {
    name: `${componentName}.json`,
    content: `{
  "title": "Sektion: ${componentName}"
}
`
  },
  {
    name: `${componentName}.twig`,
    content: `<section class="${componentName}">{{ title }}</section>`
  }
];

// create folder
if (fs.existsSync(`./resources/components/${componentName}`)) {
  console.log(`\n${chalk.red(`${componentName} already exists.`)}\n`);
  process.exit(0);
}

fs.mkdirSync(`./resources/components/${componentName}`);
files.forEach(file => {
  fs.writeFileSync(
    `./resources/components/${componentName}/${file.name}`,
    file.content
  );
});

console.log(`\nCreated component ${chalk.green(componentName)} 🙌\n`);
