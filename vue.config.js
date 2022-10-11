module.exports = {
  // chainWebpack: config => {
  //   config.plugin('html').tap((args) => {
  //     args[0].minify = {
  //       ...args[0].minify,
  //       removeAttributeQuotes: false
  //     }
  //     return args
  //   })
  // },
  publicPath: process.env.NODE_ENV === 'production'
    ? '/'
    : '/'
}