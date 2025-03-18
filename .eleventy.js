const markdownIt = require("markdown-it")
const markdownItAttrs = require("markdown-it-attrs")
const { feedPlugin } = require("@11ty/eleventy-plugin-rss")
const syntaxHighlight = require("@11ty/eleventy-plugin-syntaxhighlight")
const timeToRead = require('eleventy-plugin-time-to-read')
const config = require('./_data/config.js')

module.exports = function (eleventyConfig) {
    const md = markdownIt({
        html: true,
        breaks: true,
        linkify: true,
    }).use(markdownItAttrs, {
        allowedAttributes: ['target']
    }).disable('code')

    eleventyConfig.setLibrary("md", md)

    eleventyConfig.addPlugin(feedPlugin, {
        type: "rss",
        outputPath: "/feed.xml",
        collection: {
            name: "all",
            limit: 0,
        },
        metadata: {
            language: "es",
            title: "La web de Nuzkito",
            subtitle: "Blog sobre desarrollo de software.",
            base: config().url,
            author: {
                name: "Nuzkito",
            }
        }
    })
    eleventyConfig.addPlugin(syntaxHighlight)
    eleventyConfig.addPlugin(timeToRead, {
        language: 'es',
    })
    eleventyConfig.addPassthroughCopy("blog.css")
    eleventyConfig.addPassthroughCopy("css")
    eleventyConfig.addPassthroughCopy("favicon.ico")
    eleventyConfig.addPassthroughCopy("fonts")
    eleventyConfig.addPassthroughCopy("images")
    eleventyConfig.addPassthroughCopy("CNAME")
}
