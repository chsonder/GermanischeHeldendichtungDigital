<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns:tei="http://www.tei-c.org/ns/1.0"
                xmlns:php="http://php.net/xsl"
                exclude-result-prefixes="tei php">

    <xsl:output method="html" encoding="UTF-8" indent="yes"/>

    <xsl:template match="/">
        <xsl:apply-templates select="tei:TEI/tei:teiHeader/tei:fileDesc/tei:titleStmt/tei:title"/>
        <xsl:apply-templates select="tei:TEI/tei:text"/>
    </xsl:template>

    <xsl:template match="tei:teiHeader/tei:fileDesc/tei:titleStmt/tei:title">
        <h1 class="main_title">
            <xsl:value-of select="."/>
        </h1>
    </xsl:template>

    <xsl:template match="tei:div">
        <article class="article_one_column">
            <xsl:apply-templates/>
        </article>
    </xsl:template>

    <xsl:template match="tei:div/tei:head">
        <header>
            <h2 class="main_subtitle">
                <xsl:apply-templates/>
            </h2>
        </header>
    </xsl:template>

    <xsl:template match="tei:listWit">
        <dl>
            <xsl:apply-templates/>
        </dl>
    </xsl:template>

    <xsl:template match="tei:witness">
        <dt><a href="../index.php?page=quellen#{@xml:id}"><xsl:value-of select="@n"/></a></dt>
        <dd><xsl:apply-templates select="tei:msDesc"/></dd>
    </xsl:template>

    <xsl:template match="tei:msIdentifier">
        <xsl:apply-templates select="tei:settlement"/>,
        <xsl:apply-templates select="tei:repository"/>,
        <xsl:apply-templates select="tei:idno"/>.
    </xsl:template>

    <xsl:template match="text()">
        <xsl:value-of select="."/>
    </xsl:template>

</xsl:stylesheet>
