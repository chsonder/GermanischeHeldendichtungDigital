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

    <xsl:template match="tei:list">
        <article class="article_one_column">

            <xsl:apply-templates select="tei:head"/>

            <ul>
                <xsl:apply-templates select="tei:item"/>
            </ul>

        </article>
    </xsl:template>

    <xsl:template match="tei:head">
        <header>
            <h2 class="main_subtitle">
                <xsl:value-of select="."/>
            </h2>
        </header>
    </xsl:template>

    <xsl:template match="tei:item">
        <li id="{@xml:id}">
            <xsl:apply-templates/>
        </li>
    </xsl:template>

    <xsl:template match="tei:msDesc">
        <section class="article_one_column_content">
            <xsl:apply-templates/>
        </section>
    </xsl:template>

    <xsl:template match="tei:msIdentifier">
        <p>
            <xsl:apply-templates select="tei:settlement"/>,
            <xsl:apply-templates select="tei:repository"/>,
            <xsl:apply-templates select="tei:idno"/>.
        </p>
    </xsl:template>

    <xsl:template match="tei:repository">
        <a href="{@ref}"><xsl:apply-templates/></a>
    </xsl:template>

    <xsl:template match="tei:msContents">
        <p><b>Inhalt</b></p>
        <dl>
            <xsl:apply-templates/>
        </dl>
    </xsl:template>

    <xsl:template match="tei:msItem">
        <dt><xsl:apply-templates select="tei:title"/></dt>
        <dd><xsl:apply-templates select="tei:locus"/></dd>
    </xsl:template>

    <xsl:template match="tei:msItem/tei:title">
        <a href="../index.php?page={@n}"><xsl:apply-templates/></a>
    </xsl:template>

    <xsl:template match="tei:additional">
        <xsl:apply-templates/>
    </xsl:template>

    <xsl:template match="tei:additional/tei:p">
        <p>
            <xsl:apply-templates/>
        </p>
    </xsl:template>

    <xsl:template match="tei:ref">
        <a href="{@target}"><xsl:apply-templates/></a>
    </xsl:template>

    <xsl:template match="text()">
        <xsl:value-of select="."/>
    </xsl:template>

</xsl:stylesheet>
