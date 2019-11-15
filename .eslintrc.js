module.exports = {
  env: {
    es6: true,
    node: true,
  },
  extends: [
    'plugin:vue/recommended',
    'airbnb-base',
  ],
  globals: {
    Atomics: 'readonly',
    SharedArrayBuffer: 'readonly',
    Vue: false,
    axios: false,
  },
  parserOptions: {
    ecmaVersion: 9,
    sourceType: 'module',
  },
  plugins: [
    'vue',
  ],
  rules: {
    'vue/component-name-in-template-casing': ['error', 'PascalCase'],
    'import/no-extraneous-dependencies': ['error', { devDependencies: true }],
    'no-console': process.env.NODE_ENV === 'production' ? 'error' : 'off',
    'no-debugger': process.env.NODE_ENV === 'production' ? 'error' : 'off',
    'max-len': ["error", { "code": 200 }],
    strict: ['error', 'global'],
    curly: 'warn',
  },
};
