// const BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin;

module.exports = {
  productionSourceMap: false,
  "transpileDependencies": [
    "vuetify"
  ],
  configureWebpack: {
    // plugins: [
    //   new BundleAnalyzerPlugin()
    // ],
    optimization: {
      splitChunks: {
        chunks: 'async',
        minSize: 30000,
        maxSize: 60000,
        minChunks: 1,
      }
    },
    output:{
      chunkFilename: 'js/[id].apuschedule.js'
    }
  },
}