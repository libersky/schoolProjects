<?xml version="1.0" encoding="UTF-8"?>
<sch:schema xmlns:sch="http://purl.oclc.org/dsdl/schematron" queryBinding="xslt2"
    xmlns:sqf="http://www.schematron-quickfix.com/validator/process">

    <sch:ns uri="urn:vse.cz:hotely" prefix="h"/>

    <sch:pattern>
        <sch:title>Kontrola počtu dostupných pokojů</sch:title>
        <sch:rule context="h:hotely/h:budova">
            <sch:report test="count(h:pokoje/h:pokoj[contains(@provoz,'Ano')])!=h:pocetDostupnychPokoju/text()">Počet dostupných pokojů neodpovídá skutečnosti.</sch:report>
        </sch:rule>
    </sch:pattern>

</sch:schema>
