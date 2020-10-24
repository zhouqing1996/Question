'use strict'
const merge = require('webpack-merge')
const prodEnv = require('./prod.env')

module.exports = merge(prodEnv, {
  NODE_ENV: '"development"',
  apiBaseUrl:'"http://120.78.150.89/Question/Yii/backend/web/index.php"',
})
