module.exports = {
  env: {
    browser: true,
    node: true,
    es6: true
  },
  extends: ["airbnb-base", "prettier", "prettier/standard"],
  parserOptions: {
    sourceType: "module"
  },
  parser: "babel-eslint",
  globals: {
    IS_PRODUCTION: false,
    towa: false
  },
  rules: {
    "no-debugger": process.env.PRE_COMMIT ? "error" : "off",
    "no-console": process.env.PRE_COMMIT
      ? ["error", { allow: ["warn", "error"] }]
      : "off"
  }
};
