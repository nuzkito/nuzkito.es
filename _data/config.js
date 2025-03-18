module.exports = function () {
    return {
        environment: process.env.ENVIRONMENT || 'development',
        url: process.env.URL || 'http://localhost',
    }
}
