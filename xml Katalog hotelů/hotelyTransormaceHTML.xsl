<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
    xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:h="urn:vse.cz:hotely"
    exclude-result-prefixes="xs h" version="2.0">

    <xsl:output method="html" encoding="UTF-8"/>

    <xsl:output name="html" method="html" encoding="UTF-8"/>

    <xsl:template match="/">
        <xsl:text disable-output-escaping="yes">&lt;!DOCTYPE html&gt;</xsl:text>
        <html lang="cs">
            <head>
                <title>
                    <xsl:text>Hotely</xsl:text>
                </title>
                <style>
                    body {
                        text-align: center;
                        font-family: Arial, Helvetica, sans-serif;
                        background-color: #115c5c;
                        color: white;
                    }
                    ul {
                        padding: 0px;
                        padding-top: 20px;
                    }
                    li {
                        list-style-type: none;
                        display: block;
                        padding-top: 10px;
                    }
                    a {
                        color: white;
                    }</style>
            </head>
            <body>
                <xsl:apply-templates/>
            </body>
        </html>
    </xsl:template>

    <xsl:template match="h:hotely">
        <h1>
            <xsl:text>Seznam hotelů:</xsl:text>
        </h1>
        <ul>
            <xsl:apply-templates select="h:budova"/>
        </ul>
    </xsl:template>

    <xsl:template match="h:budova">
        <li>
            <a href="{generate-id(.)}.html">
                <xsl:value-of select="h:nazev"/>
                <xsl:text disable-output-escaping="yes"> - </xsl:text>
                <xsl:value-of select="generate-id(.)"/>
            </a>
        </li>
        <xsl:result-document href="{generate-id(.)}.html" format="html">
            <xsl:text disable-output-escaping="yes">&lt;!DOCTYPE html&gt;</xsl:text>
            <html  lang="cs">
                <head>
                    <title>
                        <xsl:value-of select="h:nazev"/>
                    </title>
                    <style>
                        body {
                            width: 100%;
                            height: 1020px;
                            background-color: #e6ffff;
                            margin: 0px;
                            padding: 0px;
                            font-family: Arial, Helvetica, sans-serif;
                        }
                        .header {
                            background-color: #115c5c;
                            color: white;
                            width: 100%;
                            height: 170px;
                            text-align: center;
                            position: absolute;
                            top: 0;
                        }
                        
                        .header a {
                            position: absolute;
                            top: 5px;
                            right: 5px;
                            z-index: 2;
                            color: white;
                        }
                        
                        .owner {
                            margin: 3px auto;
                        }
                        
                        li {
                            list-style-type: none;
                        }
                        
                        .main {
                            min-height: 520px;
                            width: 100%;
                            margin-top: 170px;
                        }
                        
                        .leftSide {
                            float: left;
                            width: 500px;
                            padding: 2% 5%;
                            padding-bottom: 0%;
                        }
                        
                        .additional {
                            text-align: center;
                        }
                        
                        .pokoje {
                            background-color: rgb(240, 255, 255);
                            float: left;
                            width: 43%;
                            height: 470px;
                            overflow: auto;
                            padding-left: 7%;
                            padding-bottom: 50px;
                        }
                        
                        .footer {
                            background-color: #115c5c;
                            color: white;
                            width: 100%;
                            height: 600px;
                            position: relative;
                            bottom: 0;
                        }
                        
                        .kontakt {
                            float: right;
                            width: 50%;
                            margin-top: 30px;
                        }
                        
                        .predstavenstvo {
                            float: left;
                            width: 35%;
                            margin-left: 15%;
                            margin-top: 30px;
                        }</style>
                </head>
                <body>
                    <header>
                        <div class="header">
                            <a href="hotelyHTML.html">Zpět na seznam hotelů.</a>
                            <h1>
                                <xsl:value-of select="h:nazev"/>
                            </h1>
                            <h2>
                                <xsl:value-of select="h:hvezdy"/>
                                <xsl:text> hvězdičkové ubytování</xsl:text>
                            </h2>
                            <xsl:choose>
                                <xsl:when test="h:nazev != h:kontakt/@vlastnik">
                                    <div class="owner">
                                        <xsl:text>Hotel je dceřinou společností hotelu </xsl:text>
                                        <xsl:value-of select="h:kontakt/@vlastnik"/>
                                    </div>
                                </xsl:when>
                            </xsl:choose>
                        </div>
                    </header>
                    <main>
                        <div class="main">
                            <div class="leftSide">
                                <div class="obrazek">
                                    <xsl:text disable-output-escaping="yes">&lt;img src="</xsl:text>
                                    <xsl:value-of select="h:nazev"/>
                                    <xsl:text disable-output-escaping="yes">.jpg" alt="Obrázek hotelu </xsl:text>
                                    <xsl:value-of select="h:nazev"/>
                                    <xsl:text disable-output-escaping="yes">. (Pokud se obrázek nezobrazuje, znamená to, že nebyl nahrán, nebo nebyl uložen ve formátu .jpg pod názvem </xsl:text>
                                    <xsl:value-of select="h:nazev"/>
                                    <xsl:text disable-output-escaping="yes">.jpg)" width="500"&gt;</xsl:text>
                                </div>
                                <div class="additional">
                                    <h3>
                                        <xsl:text>Vybavení hotelu: </xsl:text>
                                        <xsl:value-of select="h:vybaveniHotelu"/>
                                    </h3>
                                </div>
                            </div>
                            <div class="pokoje">
                                <h2>
                                    <xsl:text>Počet dostupných pokojů: </xsl:text>
                                    <xsl:value-of select="h:pocetDostupnychPokoju"/>
                                </h2>
                                <h2>
                                    <xsl:text>Pokoje:</xsl:text>
                                </h2>
                                <xsl:apply-templates select="h:pokoje"/>
                            </div>
                        </div>
                    </main>
                    <footer>
                        <div class="footer">
                            <div class="kontakt">
                                <h2>
                                    <xsl:text>Kontakt:</xsl:text>
                                </h2>
                                <xsl:apply-templates select="h:kontakt"/>
                            </div>
                            <div class="predstavenstvo">
                                <h2>
                                    <xsl:text>Představenstvo:</xsl:text>
                                </h2>
                                <xsl:apply-templates select="h:predstavenstvo/h:osoba"/>
                            </div>
                        </div>
                    </footer>
                </body>
            </html>
        </xsl:result-document>
    </xsl:template>

    <xsl:template match="h:kontakt">
        <ul>
            <li>
                <xsl:text>Telefon: </xsl:text>
                <xsl:value-of select="h:telefon"/>
            </li>
            <li>
                <xsl:text>Email: </xsl:text>
                <xsl:value-of select="h:email"/>
            </li>
            <li>
                <xsl:text>Adresa: </xsl:text>
                <xsl:value-of select="h:adresa"/>
            </li>
        </ul>
    </xsl:template>

    <xsl:template match="h:adresa">
        <xsl:text>Vypis:</xsl:text>
        <ul>
            <li>
                <xsl:value-of select="h:ulice"/>
                <xsl:text> </xsl:text>
                <xsl:value-of select="h:cp"/>
            </li>
            <li>
                <xsl:value-of select="h:mesto"/>
            </li>
            <li>
                <xsl:value-of select="h:psc"/>
            </li>
        </ul>
    </xsl:template>

    <xsl:template match="h:osoba">
        <h3>
            <xsl:value-of select="@pozice"/>
        </h3>
        <xsl:text>Jméno: </xsl:text>
        <xsl:value-of select="h:jmeno"/>
        <br/>
        <xsl:text>Kontakt: </xsl:text>
        <ul>
            <li>
                <xsl:value-of select="h:kontakt/h:email"/>
            </li>
            <li>
                <xsl:value-of select="h:kontakt/h:telefon"/>
            </li>
        </ul>
    </xsl:template>

    <xsl:template match="h:pokoje">
        <xsl:for-each-group select="h:pokoj" group-by="h:cenaZaNoc">
            <xsl:sort select="current-grouping-key()" lang="cs" data-type="number"/>
            <xsl:for-each select="current-group()">
                <xsl:sort select="h:cenaZaNoc" lang="cs" data-type="number"/>

                <h3>
                    <xsl:value-of select="h:pocetLuzek"/>
                    <xsl:text> lůžkový pokoj - </xsl:text>
                    <xsl:choose>
                        <xsl:when test="@provoz = 'Ano'">
                            <xsl:text>volný</xsl:text>
                        </xsl:when>
                        <xsl:otherwise>
                            <xsl:text>obsazený</xsl:text>
                        </xsl:otherwise>
                    </xsl:choose>
                </h3>
                <xsl:text>Typ: </xsl:text>
                <xsl:value-of select="h:typ"/>
                <br/>
                <xsl:text>Počet lůžek: </xsl:text>
                <xsl:value-of select="h:pocetLuzek"/>
                <br/>
                <xsl:text>Vybavení pokoje: </xsl:text>
                <xsl:value-of select="h:vybaveniPokoje"/>
                <br/>
                <xsl:choose>
                    <xsl:when test="h:socialniZarizeni = 'Ano'">
                        <xsl:text>Pokoj má vlastní socialní zařízení.</xsl:text>
                        <br/>
                    </xsl:when>
                    <xsl:otherwise>
                        <xsl:text>Pokoj nemá vlastní socialní zařízení.</xsl:text>
                        <br/>
                    </xsl:otherwise>
                </xsl:choose>
                <xsl:text>Cena za noc: </xsl:text>
                <xsl:value-of select="h:cenaZaNoc"/>
                <br/>

            </xsl:for-each>
        </xsl:for-each-group>
    </xsl:template>

</xsl:stylesheet>
