<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
    xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:fo="http://www.w3.org/1999/XSL/Format"
    xmlns:h="urn:vse.cz:hotely" exclude-result-prefixes="xs" version="2.0">

    <xsl:output method="xml" encoding="Windows-1250" indent="no"/>

    <xsl:template match="/">
        <fo:root font-family="Arial, Helvetica, sans-serif" font-size="13pt" language="cs"
            hyphenate="true">
            <!-- Definice layoutu stránky -->
            <fo:layout-master-set>
                <!-- Rozměry stránky a její okraje -->
                <fo:simple-page-master master-name="title-page" page-height="297mm"
                    page-width="210mm" margin="1in">
                    <fo:region-body margin-bottom="5mm" margin-top="5mm"/>
                </fo:simple-page-master>
                <fo:simple-page-master master-name="content-page" page-height="297mm"
                    page-width="210mm" margin="1in">
                    <fo:region-body margin-bottom="15mm" margin-top="15mm"/>
                    <fo:region-before extent="10mm"/>
                    <fo:region-after extent="10mm"/>
                </fo:simple-page-master>
                <fo:simple-page-master master-name="hotel-page" page-height="297mm"
                    page-width="210mm" margin="1in">
                    <fo:region-body margin-bottom="15mm" margin-top="15mm"/>
                    <fo:region-before extent="10mm"/>
                    <fo:region-after extent="10mm"/>
                </fo:simple-page-master>
            </fo:layout-master-set>

            <fo:page-sequence master-reference="title-page">
                <fo:flow flow-name="xsl-region-body">
                    <xsl:call-template name="titlePage"/>
                </fo:flow>
            </fo:page-sequence>

            <fo:page-sequence master-reference="content-page">
                <fo:static-content flow-name="xsl-region-before">
                    <fo:block color="#bfbfbf">
                        <xsl:text>Hotely</xsl:text>
                    </fo:block>
                </fo:static-content>
                <fo:static-content flow-name="xsl-region-after">
                    <fo:block color="#bfbfbf">
                        <xsl:text>Strana </xsl:text>
                        <fo:page-number/>
                    </fo:block>
                </fo:static-content>
                <fo:flow flow-name="xsl-region-body">
                    <xsl:call-template name="contentPage"/>
                </fo:flow>
            </fo:page-sequence>

            <fo:page-sequence master-reference="hotel-page">
                <fo:static-content flow-name="xsl-region-before">
                    <fo:block color="#bfbfbf">
                        <xsl:text>Hotely</xsl:text>
                    </fo:block>
                </fo:static-content>
                <fo:static-content flow-name="xsl-region-after">
                    <fo:block color="#bfbfbf">
                        <xsl:text>Strana </xsl:text>
                        <fo:page-number/>
                    </fo:block>
                </fo:static-content>
                <fo:flow flow-name="xsl-region-body">
                    <xsl:call-template name="hotelPage"/>
                </fo:flow>
            </fo:page-sequence>

        </fo:root>
    </xsl:template>

    <xsl:template name="titlePage">
        <fo:block text-align="center" font-size="60px" font-weight="bold" line-height="145mm">
            <xsl:text>Katalog hotelů</xsl:text>
        </fo:block>
    </xsl:template>

    <xsl:template name="contentPage">
        <fo:block font-weight="bold" font-size="30px" margin-bottom="10mm">
            <xsl:text>Obsah:</xsl:text>
        </fo:block>
        <xsl:for-each select="h:hotely/h:budova">
            <fo:block margin-bottom="5mm">
                <fo:basic-link internal-destination="{generate-id(.)}">
                    <xsl:value-of select="h:nazev/text()"/>
                </fo:basic-link>
                <fo:leader leader-pattern="dots"/>
                <fo:basic-link internal-destination="{generate-id(.)}">
                    <fo:page-number-citation ref-id="{generate-id(.)}"/>
                </fo:basic-link>
            </fo:block>
        </xsl:for-each>
    </xsl:template>

    <xsl:template name="hotelPage">
        <xsl:apply-templates select="h:hotely"/>
    </xsl:template>

    <xsl:template match="h:hotely">
        <xsl:apply-templates select="h:budova"/>
    </xsl:template>

    <xsl:template match="h:budova">
        <fo:block margin-bottom="10mm" margin-top="10mm" font-weight="bold" font-size="50px"
            text-align="center" id="{generate-id(.)}">
            <xsl:value-of select="h:nazev"/>
        </fo:block>
        <fo:block font-size="30px" text-align="center" margin-bottom="5mm">
            <xsl:value-of select="h:hvezdy"/>
            <xsl:text> hvězdičkové ubytování</xsl:text>
        </fo:block>
        <xsl:choose>
            <xsl:when test="h:nazev != h:kontakt/@vlastnik">
                <fo:block font-size="25px" text-align="center" margin-bottom="5mm">
                    <xsl:text>Hotel je dceřinou společností hotelu </xsl:text>
                    <xsl:value-of select="h:kontakt/@vlastnik"/>
                </fo:block>
            </xsl:when>
        </xsl:choose>
        <fo:block>
            <xsl:text disable-output-escaping="yes">&lt;fo:external-graphic src="url(</xsl:text>
            <xsl:value-of select="h:nazev"/>
            <xsl:text disable-output-escaping="yes">.jpg)" content-width="100mm" width="100%" text-align="center" display-align="center"/&gt;</xsl:text>
        </fo:block>
        <xsl:apply-templates select="h:kontakt"/>
        <xsl:apply-templates select="h:predstavenstvo"/>
        <fo:block font-size="30px" page-break-before="always" font-weight="bold">
            <xsl:text>Ubytování:</xsl:text>
        </fo:block>
        <fo:block margin-top="5mm">
            <xsl:text>Počet dostupných pokojů: </xsl:text>
            <xsl:value-of select="h:pocetDostupnychPokoju"/>
        </fo:block>
        <xsl:apply-templates select="h:pokoje"/>
        <fo:block page-break-after="always" margin-top="5mm">
            <xsl:text>Společné prostory a vybavení hotelu: </xsl:text>
            <xsl:value-of select="h:vybaveniHotelu"/>
        </fo:block>
    </xsl:template>

    <xsl:template match="h:kontakt">
        <fo:block margin-top="5mm" margin-left="35mm">
            <xsl:text>Telefoní číslo na recepci: </xsl:text>
            <xsl:value-of select="h:telefon"/>
        </fo:block>
        <fo:block margin-left="35mm">
            <xsl:text>Kontaktní email hotelu: </xsl:text>
            <xsl:value-of select="h:email"/>
        </fo:block>
        <fo:block margin-left="35mm" margin-top="5mm">
            <xsl:text>Poloha hotelu:</xsl:text>
        </fo:block>
        <xsl:apply-templates select="h:adresa"/>
    </xsl:template>

    <xsl:template match="h:adresa">
        <fo:block margin-left="50mm">
            <xsl:value-of select="h:ulice"/>
            <xsl:text> </xsl:text>
            <xsl:value-of select="h:cp"/>
        </fo:block>
        <fo:block margin-left="50mm">
            <xsl:value-of select="h:mesto"/>
        </fo:block>
        <fo:block margin-left="50mm" page-break-after="always">
            <xsl:value-of select="h:psc"/>
        </fo:block>
    </xsl:template>

    <xsl:template match="h:predstavenstvo">
        <fo:block text-align="center" font-size="30px" font-weight="bold">
            <xsl:text>Představenstvo hotelu:</xsl:text>
        </fo:block>
        <xsl:apply-templates select="h:osoba"/>
    </xsl:template>

    <xsl:template match="h:osoba">
        <fo:block margin-left="48mm" margin-top="5mm">
            <xsl:value-of select="h:jmeno"/>
            <xsl:text> - </xsl:text>
            <xsl:value-of select="@pozice"/>
        </fo:block>
        <fo:block margin-left="48mm">
            <xsl:text>Kontakt:</xsl:text>
        </fo:block>
        <fo:block margin-left="52mm">
            <xsl:text>Telefon: </xsl:text>
            <xsl:value-of select="h:kontakt/h:telefon"/>
        </fo:block>
        <fo:block margin-left="52mm">
            <xsl:text>Email: </xsl:text>
            <xsl:value-of select="h:kontakt/h:email"/>
        </fo:block>
    </xsl:template>

    <xsl:template match="h:pokoje">
        <fo:table border-style="solid" margin-top="5mm">
            <fo:table-body>
                <fo:table-row>
                    <fo:table-cell border-style="solid">
                        <fo:block>
                            <xsl:text/>
                        </fo:block>
                    </fo:table-cell>
                    <fo:table-cell border-style="solid">
                        <fo:block>
                            <xsl:text>Typ pokoje: </xsl:text>
                        </fo:block>
                    </fo:table-cell>
                    <fo:table-cell border-style="solid">
                        <fo:block>
                            <xsl:text>Socialní zařízení: </xsl:text>
                        </fo:block>
                    </fo:table-cell>
                    <fo:table-cell border-style="solid">
                        <fo:block>
                            <xsl:text>Vybavení pokoje: </xsl:text>
                        </fo:block>
                    </fo:table-cell>
                    <fo:table-cell border-style="solid">
                        <fo:block>
                            <xsl:text>Cena za noc: </xsl:text>
                        </fo:block>
                    </fo:table-cell>
                    <fo:table-cell border-style="solid">
                        <fo:block>
                            <xsl:text>Dostupný: </xsl:text>
                        </fo:block>
                    </fo:table-cell>
                </fo:table-row>
            </fo:table-body>
        </fo:table>
        <xsl:for-each-group select="h:pokoj" group-by="h:cenaZaNoc">
            <xsl:sort select="current-grouping-key()" lang="cs" data-type="number"/>
            <xsl:for-each select="current-group()">
                <xsl:sort select="h:cenaZaNoc" lang="cs" data-type="number"/>
                <fo:table border-style="solid" text-align="center">
                    <fo:table-body>
                        <fo:table-row>
                            <fo:table-cell border-style="solid">
                                <fo:block>
                                    <xsl:value-of select="h:pocetLuzek"/>
                                    <xsl:text> lůžkový pokoj</xsl:text>
                                </fo:block>
                            </fo:table-cell>
                            <fo:table-cell border-style="solid">
                                <fo:block>
                                    <xsl:value-of select="h:typ"/>
                                </fo:block>
                            </fo:table-cell>
                            <fo:table-cell border-style="solid">
                                <fo:block>
                                    <xsl:value-of select="h:socialniZarizeni"/>
                                </fo:block>
                            </fo:table-cell>
                            <fo:table-cell border-style="solid">
                                <fo:block>
                                    <xsl:value-of select="h:vybaveniPokoje"/>
                                </fo:block>
                            </fo:table-cell>
                            <fo:table-cell border-style="solid">
                                <fo:block>
                                    <xsl:value-of select="h:cenaZaNoc"/>
                                    <xsl:text> Kč</xsl:text>
                                </fo:block>
                            </fo:table-cell>
                            <fo:table-cell border-style="solid">
                                <fo:block>
                                    <xsl:value-of select="@provoz"/>
                                </fo:block>
                            </fo:table-cell>
                        </fo:table-row>
                    </fo:table-body>
                </fo:table>
            </xsl:for-each>
        </xsl:for-each-group>
    </xsl:template>

</xsl:stylesheet>
