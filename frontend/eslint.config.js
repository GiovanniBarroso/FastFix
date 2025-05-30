import { defineConfig } from 'eslint-define-config'
// import vue from 'eslint-plugin-vue'
import globals from 'globals'

export default defineConfig({
  root: true,
  env: globals.browser,
  parser: 'vue-eslint-parser',
  parserOptions: {
    parser: '@babel/eslint-parser',
    ecmaVersion: 2020,
    sourceType: 'module',
    requireConfigFile: false,
    ecmaFeatures: {
      jsx: true,
    },
  },
  plugins: ['vue'],
  extends: ['eslint:recommended', 'plugin:vue/vue3-essential', 'prettier'],
  rules: {},
  ignorePatterns: ['dist/', 'node_modules/'],
})
