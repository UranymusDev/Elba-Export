<pre>

<?php

$row = 1;
$buchungen = array();
if (($handle = fopen("elba.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $line = array();
        $book = array();
        $num = count($data);
        $row++;
        for ($c=0; $c < $num; $c++) {
            $line[$c] = trim($data[$c]);

        }

        $delimiters = "/[;]/"; // specify the delimiters inside the regex pattern
        $parts = preg_split($delimiters, $line[0], -1, PREG_SPLIT_NO_EMPTY);

        $book['date'] = $parts[0];
        $book['info'] = str_replace('"', '', $parts[1]);

        $keywords = [ "Verwendungszweck", "Auftraggeberreferenz", "Mandat",  "Zahlungsempfänger", "Zahlungsempfänger BIC", "Zahlungsempfänger IBAN", "Zahlungsreferenz", "IBAN Empfänger", "BIC Empfänger", "Empfänger-Kennung"];

        $outputString = $book['info'];
        foreach ($keywords as $keyword) {
            $outputString = str_replace($keyword, ';'.$keyword , $outputString);
        }
        $book['info'] = $outputString;

        $explodedArray = array_filter(array_map('trim', explode(';', $book['info'])));
        //var_dump( $explodedArray);

        $final = array();



    foreach ( $keywords as $keyword ) {
        foreach( $explodedArray as $string ) {

            if (strpos($string, $keyword) !== false) {
                $final[$keyword] = trim(str_replace($keyword. ':', '' , $string));;
            }
        }
    }

        var_dump( $final);

}
    fclose($handle);
}

?>
</pre>
