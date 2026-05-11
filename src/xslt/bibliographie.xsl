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

    <xsl:template match="tei:listBibl">
        <article class="article_one_column">

            <!-- Überschrift zuerst -->
            <xsl:apply-templates select="tei:head"/>

            <!-- Dann die Liste -->
            <dl>
                <xsl:apply-templates select="tei:bibl"/>
            </dl>

        </article>
    </xsl:template>

    <xsl:template match="tei:head">
        <header>
            <h2 class="main_subtitle">
                <xsl:value-of select="."/>
            </h2>
        </header>
    </xsl:template>

    <xsl:template match="tei:bibl">
        <dt id="{@xml:id}">
            <xsl:value-of select="php:functionString('formatBiblId', string(@xml:id))"/>
        </dt>
        <dd>
            <xsl:apply-templates/>
        </dd>
    </xsl:template>

    <xsl:template match="tei:ref">
        <xsl:variable name="target-id" select="substring-after(@target, '#')"/>
        <a href="#{$target-id}">
            <xsl:apply-templates select="//tei:bibl[@xml:id = $target-id]/node()"/>
            <xsl:text> </xsl:text>
            <xsl:apply-templates/>
        </a>
    </xsl:template>

    <xsl:template match="tei:hi[@rend='italic']">
        <i>
            <xsl:apply-templates/>
        </i>
    </xsl:template>

    <xsl:template match="text()">
        <xsl:value-of select="."/>
    </xsl:template>

</xsl:stylesheet>
