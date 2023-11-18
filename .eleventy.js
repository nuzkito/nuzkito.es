const markdownIt = require("markdown-it");
const markdownItAttrs = require("markdown-it-attrs");
const pluginRss = require("@11ty/eleventy-plugin-rss");
const syntaxHighlight = require("@11ty/eleventy-plugin-syntaxhighlight");
const timeToRead = require('eleventy-plugin-time-to-read');

module.exports = function(eleventyConfig) {
    const md = markdownIt({
        html: true,
        breaks: true,
        linkify: true,
    }).use(markdownItAttrs, {
        allowedAttributes: ['target']
    }).disable('code');

    eleventyConfig.setLibrary("md", md);

    eleventyConfig.addPlugin(pluginRss);
    eleventyConfig.addPlugin(syntaxHighlight);
    eleventyConfig.addPlugin(timeToRead, {
        language: 'es',
    });
    eleventyConfig.addPassthroughCopy("blog.css");
    eleventyConfig.addPassthroughCopy("css");
    eleventyConfig.addPassthroughCopy("favicon.ico");
    eleventyConfig.addPassthroughCopy("fonts");
    eleventyConfig.addPassthroughCopy("images");
    eleventyConfig.addPassthroughCopy("CNAME");
};
