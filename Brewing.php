<?php
include ("top.php");
?>
<main class="about">
<h2>The Brewing Process:</h2>
<p class="steps">1. Water</p>
<p>Pure water is essential to good beer – and brewers pay lots attention to the source and purification of water they use. The water used in brewing is purified to set standards. If it doesn’t have the proper calcium or acidic content for maximum activity of the enzymes in the mash, it must be brought up to that standard.</p>
<p class="steps">2. Malt</p>
<p>To make malt, grain is first allowed to germinate. It’s then dried in a kiln or often roasted. This germination process creates enzymes that convert the grain’s starch into sugar. Depending on how long the roasting process takes, the malt will darken in color. This is what influences the color and flavor of the beer.</p>
<p class="steps">3. Mashing</p>
<p>Malt is added to heated, purified water and, through a carefully controlled time and temperature process, the malt enzymes break down the starch to sugar, and the complex proteins of the malt break down to simpler nitrogen compounds. The mashing takes place in a large round tank called a mash tun, and requires temperature control. Depending on the type of beer desired, the malt is then supplemented by starch from other cereals such as corn, wheat or rice.</p>
<p class="steps">4. Lautering</p>
<p>The mash is transferred to a lautering vessel with a slotted false bottom two to five cm above the actual bottom. The liquid extract drains through the false bottom and is run off to the brew kettle. This extract, a sugar solution called wort, is not yet beer. Water is sparged through the grains to wash out as much of the extract as possible. The spent grains are removed and sold for cattle feed.</p>
<p class="steps">5. Boiling and Hopping</p>
<p>Boiling takes place in a large brew kettle under carefully controlled conditions. The process to obtain the desired extract from the hops usually takes about two hours. The hop resins contribute flavor, aroma and bitterness to the brew. Once the hops have flavored the brew, they are removed. Sometimes, highly fermentable syrup may be added to the kettle. Undesirable protein substances which have survived the journey from the mash mixer are coagulated, leaving the wort clear.</p>
<p class="steps">6. Hop Separation & Cooling</p>
<p>After the beer has taken on the flavor of the hops, the wort then goes to the hot wort tank. It’s then cooled, usually in a plate cooler. As the wort and a coolant flow past each other on opposite sides of stainless steel plates, the temperature of the wort drops from boiling to about 50°F to 60°F (a drop of more than 150°F) in a few seconds.</p>
<p class="steps">7. Fermentation</p>
<p>This is where all the magic happens – where the yeast (those living, single-cell fungi) break down the sugar in the wort to carbon dioxide and alcohol. It’s also where a lot of the vital flavor occurs. In all modern breweries, elaborate precautions are taken to ensure that the yeast remains pure and unchanged. Through the use of pure yeast culture plants, a particular beer flavor can be maintained year after year.
During fermentation, which lasts about seven to 10 days, the yeast multiplies until a creamy, frothy head appears on top of the brew. When the fermentation is over, the yeast is removed. At last, we have beer!</p>
<p class="steps">8. Bottling</p>
<p>A "crowning" machine integrated with the filler, places caps on the bottles. Emerging from the pasteurizer, the bottles are inspected, labelled, placed in boxes, stacked on pallets and carried by a lift-truck to the warehousing areas to await shipment. Also in the bottle shop may be the canning lines where beer is packaged in cans for selling.</p>
    </main>
<?php
///////////////////////////////////////////////////////////////////////
print PHP_EOL . '<!-- SECTION: 1a read first csv file -->' . PHP_EOL;
///////////////////////////////////////////////////////////////////////

$debug = false;
if(isset($_GET["debug"])){
     $debug = true; 
}

$myFolder2 = 'data/';

$myFileName2 = 'sopo_order_grains';

$fileExt2 = '.csv';

$filename2 = $myFolder2 . $myFileName2 . $fileExt2;

if ($debug) {
    print '<p>filename is ' . $filename2;
}

$file2=fopen($filename2, "r");

if($debug){
    if($file2){
       print '<p>File Opened Succesful.</p>';
    }else{
       print '<p>File Open Failed.</p>';
     }
} 

if($file2){
    if ($debug) {
        print '<p>Begin reading data into an array.</p>';
    }

    // read the header row, copy the line for each header row
    // you have.
    $headers2[] = fgetcsv($file2);

    if($debug) {
         print '<p>Finished reading headers.</p>';
         print '<p>My header array</p><pre>';
         print_r($headers2);
         print '</pre>';
     }
     while(!feof($file2)){
         $datas2[] = fgetcsv($file2);
     }
        if($debug) {
         print '<p>Finished reading data. File closed.</p>';
         print '<p>My data array<p><pre> ';
         print_r($datas2);
         print '</pre></p>';
     }
     
     fclose($file2);
}

///////////////////////////////////////////////////////////////////////
print PHP_EOL . '<!-- SECTION: 1b read second csv file -->' . PHP_EOL;
///////////////////////////////////////////////////////////////////////

$myFolder = 'data/';

$myFileName = 'sopo_order_hops';

$fileExt = '.csv';

$filename = $myFolder . $myFileName . $fileExt;

if ($debug) {
    print '<p>filename is ' . $filename;
}

$file=fopen($filename, "r");

if($debug){
    if($file){
       print '<p>File Opened Succesful.</p>';
    }else{
       print '<p>File Open Failed.</p>';
     }
} 

if($file){
    if ($debug) {
        print '<p>Begin reading data into an array.</p>';
    }

    // read the header row, copy the line for each header row
    // you have.
    $headers[] = fgetcsv($file);

    if($debug) {
         print '<p>Finished reading headers.</p>';
         print '<p>My header array</p><pre>';
         print_r($headers);
         print '</pre>';
     }
     while(!feof($file)){
         $datas[] = fgetcsv($file);
     }
        if($debug) {
         print '<p>Finished reading data. File closed.</p>';
         print '<p>My data array<p><pre> ';
         print_r($datas);
         print '</pre></p>';
     }
     
     fclose($file);
}

///////////////////////////////////////////////////////////////////////
print PHP_EOL . '<!-- SECTION: 1c read third csv file -->' . PHP_EOL;
///////////////////////////////////////////////////////////////////////

$debug = false;
if(isset($_GET["debug"])){
     $debug = true; 
}

$myFolder3 = 'data/';

$myFileName3 = 'sopo_order_yeast';

$fileExt3 = '.csv';

$filename3 = $myFolder3 . $myFileName3 . $fileExt3;

if ($debug) {
    print '<p>filename is ' . $filename3;
}

$file3=fopen($filename3, "r");

if($debug){
    if($file3){
       print '<p>File Opened Succesful.</p>';
    }else{
       print '<p>File Open Failed.</p>';
     }
} 

if($file3){
    if ($debug) {
        print '<p>Begin reading data into an array.</p>';
    }

    // read the header row, copy the line for each header row
    // you have.
    $headers3[] = fgetcsv($file3);

    if($debug) {
         print '<p>Finished reading headers.</p>';
         print '<p>My header array</p><pre>';
         print_r($headers3);
         print '</pre>';
     }
     while(!feof($file3)){
         $datas3[] = fgetcsv($file3);
     }
        if($debug) {
         print '<p>Finished reading data. File closed.</p>';
         print '<p>My data array<p><pre> ';
         print_r($datas3);
         print '</pre></p>';
     }
     
     fclose($file3);
}

///////////////////////////////////////////////////////////////////////
print PHP_EOL . '<!-- SECTION: 1c read fourth csv file -->' . PHP_EOL;
///////////////////////////////////////////////////////////////////////

$debug = false;
if(isset($_GET["debug"])){
     $debug = true; 
}

$myFolder4 = 'data/';

$myFileName4 = 'sopo_order_salts';

$fileExt4 = '.csv';

$filename4 = $myFolder4 . $myFileName4 . $fileExt4;

if ($debug) {
    print '<p>filename is ' . $filename4;
}

$file4=fopen($filename4, "r");

if($debug){
    if($file4){
       print '<p>File Opened Succesful.</p>';
    }else{
       print '<p>File Open Failed.</p>';
     }
} 

if($file4){
    if ($debug) {
        print '<p>Begin reading data into an array.</p>';
    }

    // read the header row, copy the line for each header row
    // you have.
    $headers4[] = fgetcsv($file4);

    if($debug) {
         print '<p>Finished reading headers.</p>';
         print '<p>My header array</p><pre>';
         print_r($headers4);
         print '</pre>';
     }
     while(!feof($file4)){
         $datas4[] = fgetcsv($file4);
     }
        if($debug) {
         print '<p>Finished reading data. File closed.</p>';
         print '<p>My data array<p><pre> ';
         print_r($datas4);
         print '</pre></p>';
     }
     
     fclose($file4);
}

?>

<p class="info">To keep transparency with our customers, we like to provide information for the ingredients we use in our beer like the hops, malt, and yeast to our customers so they know what's in their beer.</p>

<?php
///////////////////////////////////////////////////////////////////////
print PHP_EOL . '<!-- SECTION: 2a display first file data into table -->' . PHP_EOL;
///////////////////////////////////////////////////////////////////////
print '<table>';
foreach ($headers as $header){
     print '<tr>';
     foreach($header as $column){
        print '<th>'; 
        print $column;
        print '</th>';
    
     }
     print '</tr>';
}

foreach ($datas as $data){
     print'<tr>';
     foreach($data as $row){
         print '<td>';
         print $row;
         print '</td>';
    
     }
     print '</tr>';
  }
print '</table>';
if ($debug) {
    print '<p>End of processing.</p>';
}

///////////////////////////////////////////////////////////////////////
print PHP_EOL . '<!-- SECTION: 2a display second file data into table -->' . PHP_EOL;
///////////////////////////////////////////////////////////////////////
print '<table>';
foreach ($headers2 as $header2){
     print '<tr>';
     foreach($header2 as $column2){
        print '<th>'; 
        print $column2;
        print '</th>';
    
     }
     print '</tr>';
}

foreach ($datas2 as $data2){
     print'<tr>';
     foreach($data2 as $row2){
         print '<td>';
         print $row2;
         print '</td>';
    
     }
     print '</tr>';
  }
print '</table>';
if ($debug) {
    print '<p>End of processing.</p>';
}

///////////////////////////////////////////////////////////////////////
print PHP_EOL . '<!-- SECTION: 2c display third file data into table -->' . PHP_EOL;
///////////////////////////////////////////////////////////////////////
print '<table>';
foreach ($headers3 as $header3){
     print '<tr>';
     foreach($header3 as $column3){
        print '<th>'; 
        print $column3;
        print '</th>';
    
     }
     print '</tr>';
}

foreach ($datas3 as $data3){
     print'<tr>';
     foreach($data3 as $row3){
         print '<td>';
         print $row3;
         print '</td>';
    
     }
     print '</tr>';
  }
print '</table>';
if ($debug) {
    print '<p>End of processing.</p>';
}

///////////////////////////////////////////////////////////////////////
print PHP_EOL . '<!-- SECTION: 2c display fourth file data into table -->' . PHP_EOL;
///////////////////////////////////////////////////////////////////////
print '<table>';
foreach ($headers4 as $header4){
     print '<tr>';
     foreach($header4 as $column4){
        print '<th>'; 
        print $column4;
        print '</th>';
    
     }
     print '</tr>';
}

foreach ($datas4 as $data4){
     print'<tr>';
     foreach($data4 as $row4){
         print '<td>';
         print $row4;
         print '</td>';
    
     }
     print '</tr>';
  }
print '</table>';
if ($debug) {
    print '<p>End of processing.</p>';
}
?>

<?php include 'footer.php'; ?>