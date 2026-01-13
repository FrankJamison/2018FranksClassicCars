<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="html" indent="yes" />
    <xsl:template match="/rss/channel">
        <html>
            <head>
                <title>
                    <xsl:value-of select="title" />
                </title>
                <style>
                    body { font-family: Arial, sans-serif; margin: 2em; background: #f9f9f9; }
                    h1 { color: #2c3e50; }
                    .item { margin-bottom: 2em; padding: 1em; background: #fff; border-radius: 8px;
                    box-shadow: 0 2px 6px #eee; }
                    .item-title { font-size: 1.2em; font-weight: bold; color: #2980b9; }
                    .item-date { color: #888; font-size: 0.9em; }
                    .item-desc { margin-top: 0.5em; }
                </style>
            </head>
            <body>
                <h1>
                    <xsl:value-of select="title" />
                </h1>
                <div>
                    <xsl:value-of select="description" />
                </div>
                <xsl:for-each select="item">
                    <div class="item">
                        <div class="item-title">
                            <a href="{link}">
                                <xsl:value-of select="title" />
                            </a>
                        </div>
                        <div class="item-date">
                            <xsl:value-of select="pubDate" />
                        </div>
                        <div class="item-desc">
                            <xsl:value-of select="description" disable-output-escaping="yes" />
                        </div>
                    </div>
                </xsl:for-each>
            </body>
        </html>
    </xsl:template>
</xsl:stylesheet>