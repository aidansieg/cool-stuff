<?php
include 'top.php';

//if ($debug) {

//print '<p>Post array:</p><pre>';
//print_r($_POST);
//print '</pre>';
//}

$firstName = "";

$lastName = "";

$email = "";

$gender = "Male";

$ale = true;
$lager = false;
$ipa = false;
$stout = false;

$brewerys = "None";

$suggestion = "";
///////////////////////////////////////////////////////////////////////
print PHP_EOL . '<!-- SECTION: 1c form error flags -->' . PHP_EOL;
///////////////////////////////////////////////////////////////////////
$firstNameERROR = false;
$lastNameERROR = false;
$emailERROR = false;
$genderERROR = false;
$beerERROR = false;
$totalChecked = 0;
$suggestionERROR = false;
$brewerysERROR = false;

$errorMsg = array();

$mailed = false;
///////////////////////////////////////////////////////////////////////
print PHP_EOL . '<!-- SECTION: 2 Process for when the form is submitted -->' . PHP_EOL;
///////////////////////////////////////////////////////////////////////

if (isset($_POST["btnSubmit"])) {

    $thisURL = $domain . $phpSelf;
    ///////////////////////////////////////////////////////////////////////
    print PHP_EOL . '<!-- SECTION: 2a Security -->' . PHP_EOL;
    ///////////////////////////////////////////////////////////////////////
    if (!securityCheck($thisURL)) {
        $msg = '<p>Sorry you cannot access this page.</p>';
        $msg .= '<p>Security breach detected and reported.</p>';
        die($msg);
    }
    ///////////////////////////////////////////////////////////////////////
    print PHP_EOL . '<!-- SECTION: 2b Sanitize (clean) data  -->' . PHP_EOL;
    ///////////////////////////////////////////////////////////////////////
    $firstName = htmlentities($_POST["txtFirstName"], ENT_QUOTES, "UTF-8");

    $lastName = htmlentities($_POST["txtLastName"], ENT_QUOTES, "UTF-8");

    $email = filter_var($_POST["txtEmail"], FILTER_SANITIZE_EMAIL);
    
    $gender = htmlentities($_POST["radGender"], ENT_QUOTES, "UTF-8");

    if (isset($_POST["chkAle"])) {
        $ale = true;
        $totalChecked++;
    } else {
        $ale = false;
    }

    if (isset($_POST["chkLager"])) {
        $lager = true;
        $totalChecked++;
    } else {
        $lager = false;
    }

    if (isset($_POST["chkIPA"])) {
        $ipa = true;
        $totalChecked++;
    } else {
        $ipa = false;
    }

    if (isset($_POST["chkStout"])) {
        $stout = true;
        $totalChecked++;
    } else {
        $stout = false;
    }
    
    $brewerys = htmlentities($_POST["lstBrewerys"], ENT_QUOTES, "UTF-8");
    
    $suggestion = htmlentities($_POST["txtSuggestion"], ENT_QUOTES, "UTF-8");

    ///////////////////////////////////////////////////////////////////////
    print PHP_EOL . '<!-- SECTION: 2c Validation -->' . PHP_EOL;
    ///////////////////////////////////////////////////////////////////////
    if ($firstName == "") {
        $errorMsg[] = "Please enter your first name";
        $firstNameERROR = true;
    } elseif (!verifyAlphaNum($firstName)) {
        $errorMsg[] = "Your first name appears to have an extra character.";
        $firstNameERROR = true;
    }

    if ($lastName == "") {
        $errorMsg[] = "Please enter your last name";
        $lastNameERROR = true;
    } elseif (!verifyAlphaNum($lastName)) {
        $errorMsg[] = "Your last name appears to have an extra character.";
        $lastNameERROR = true;
    }

    if ($email == "") {
        $errorMsg[] = 'Please enter your email address';
        $emailERROR = true;
    } elseif (!verifyEmail($email)) {
        $errorMsg[] = 'Your email address appears to be incorrect.';
        $emailERROR = true;
    }
    
    if ($gender != "Male" AND $gender != "Female" AND $gender != "Other") {
        $errorMsg[] = "Please select a gender";
        $genderERROR = true;
}
    
    if ($totalChecked < 1) {
        $errorMsg[] = "Please choose at least one type of beer";
        $beerERROR = true;
    }

    if ($suggestion != "") {
        if (!verifyAlphaNum($suggestion)) {
            $errorMsg[] = "Your comments appear to have extra characters that are not allowed.";
            $suggestionERROR = true;
        }
    }

    ///////////////////////////////////////////////////////////////////////
    print PHP_EOL . '<!-- SECTION: 2d Process Form - Passed Validation -->' . PHP_EOL;
    ///////////////////////////////////////////////////////////////////////
    if (!$errorMsg) {
        if ($debug)
            print '<p>Form is valid.</p>';
        ///////////////////////////////////////////////////////////////////////
        print PHP_EOL . '<!-- SECTION: 2e Save Data -->' . PHP_EOL;
        ///////////////////////////////////////////////////////////////////////
        // array used to hold form values that will be saved to a CSV file
        $dataRecord = array();

        // assign values to the dataRecord array
        $dataRecord[] = $firstName;
        $dataRecord[] = $lastName;
        $dataRecord[] = $email;
        
        $dataRecord[] = $gender;

        $dataRecord[] = $ale;
        $dataRecord[] = $lager;
        $dataRecord[] = $ipa;
        $dataRecord[] = $stout;
        
        $dataRecord[] = $brewerys;
        
        $dataRecord[] = $suggestion;

        // setup csv file
        $myFolder = 'data/';
        $myFileName = 'sopo_registration';
        $fileExt = '.csv';
        $filename = $myFolder . $myFileName . $fileExt;

        if ($debug)
        ///////////////////////////////////////////////////////////////////////
            print PHP_EOL . '<p>filename is ' . $filename;
        ///////////////////////////////////////////////////////////////////////
        // now we just open the file for append
        $file = fopen($filename, 'a');

        // write the forms informations
        fputcsv($file, $dataRecord);

        // close the file
        fclose($file);
        ///////////////////////////////////////////////////////////////////////
        print PHP_EOL . '<!-- SECTION: 2f create message -->' . PHP_EOL;
        ///////////////////////////////////////////////////////////////////////
        $message = '<h2>Your information:</h2>';

        foreach ($_POST as $htmlName => $value) {

            $message .= '<p>';

            $camelCase = preg_split('/(?=[A-Z])/', substr($htmlName, 3));
            foreach ($camelCase as $oneWord) {
                $message .= $oneWord . ' ';
            }

            $message .= ' = ' . htmlentities($value, ENT_QUOTES, "UTF-8") . '</p>';
        }

        $to = $email;
        $cc = '';
        $bcc = '';

        $from = 'Somers Point Brewing Company <customer.service@sopo.com>';

        $subject = 'SOPO email list';

        $mailed = sendMail($to, $cc, $bcc, $from, $subject, $message);
    } // end form is valid 
} // ends if form was submitted.
///////////////////////////////////////////////////////////////////////
print PHP_EOL . '<!-- SECTION 3 Display Form -->' . PHP_EOL;
///////////////////////////////////////////////////////////////////////
?>       
<main>     
    <article>
        <section class="email_mes">
        <?php
        ///////////////////////////////////////////////////////////////////////
        print PHP_EOL . '<!-- SECTION 3a  -->' . PHP_EOL;
        ///////////////////////////////////////////////////////////////////////
        if (isset($_POST["btnSubmit"]) AND empty($errorMsg)) {
            print '<h2>Thank you for signing up for the email list!</h2>';

            print '<p>For your records a copy of this data has ';
            if (!$mailed) {
                print "not";
            }

            print 'been sent:</p>';
            print '<p>To: ' . $email . '</p>';

            print $message;
            
         ?>
            </section>
            <?php
        } else {
            print '<h2 class="signup">Sign-up for our email list today!</h2>';

            if ($errorMsg) {
                print '<div id="errors">' . PHP_EOL;
                print '<h2>Your form has the following mistakes that need to be fixed.</h2>' . PHP_EOL;
                print '<ol>' . PHP_EOL;

                foreach ($errorMsg as $err) {
                    print '<li>' . $err . '</li>' . PHP_EOL;
                }

                print '</ol>' . PHP_EOL;
                print '</div>' . PHP_EOL;
            }
            ///////////////////////////////////////////////////////////////////////
            print PHP_EOL . '<!-- SECTION 3c html Form -->' . PHP_EOL;
            ///////////////////////////////////////////////////////////////////////
            ?>
        



            <form action = "<?php print $phpSelf; ?>"
                  id = "frmRegister"
                  method = "post">

                <fieldset class = "contact">
                    <legend>Contact Information</legend>
                    <p>
                        <label class="required" for="txtFirstName">First Name</label>
                        <input autofocus
    <?php if ($firstNameERROR) print 'class="mistake"'; ?>
                               id="txtFirstName"
                               maxlength="45"
                               name="txtFirstName"
                               onfocus="this.select()"
                               placeholder="Enter your first name"
                               tabindex="100"
                               type="text"
                               value="<?php print $firstName; ?>"
                               >
                    </p>

                    <p>
                        <label class="required" for="txtLastName">Last Name</label>
                        <input
    <?php if ($lastNameERROR) print 'class="mistake"'; ?>
                            id="txtLastName"
                            maxlength="45"
                            name="txtLastName"
                            onfocus="this.select()"
                            placeholder="Enter your last name"
                            tabindex="100"
                            type="text"
                            value="<?php print $lastName; ?>"
                            >
                    </p>

                    <p>
                        <label class = "required" for = "txtEmail">Email</label>
                        <input 
    <?php if ($emailERROR) print 'class="mistake"'; ?>
                            id = "txtEmail"
                            maxlength = "45"
                            name = "txtEmail"
                            onfocus = "this.select()"
                            placeholder = "Enter your email address"
                            tabindex = "120"
                            type = "text"
                            value = "<?php print $email; ?>"
                            >
                    </p>
                </fieldset>
                
                <fieldset class="radio <?php if ($genderERROR) print 'class="mistake"'; ?>">
    <legend>What is your gender?</legend>
    <p>    
        <label class="radio-field"><input type="radio" id="radGenderMale" name="radGender" value="Male" tabindex="572" 
<?php if ($gender == "Male") echo ' checked="checked" '; ?>>
            Male</label>
    </p>
    <p>
        <label class="radio-field"><input type="radio" id="radGenderFemale" name="radGender" value="Female" tabindex="572" 
<?php if ($gender== "Female") echo ' checked="checked" '; ?>>
            Female</label>
    </p>
    <p>
        <label class="radio-field"><input type="radio" id="radGenderOther" name="radGender" value="Other" tabindex="574" 
<?php if ($gender == "Other") echo ' checked="checked" '; ?>>
            Other</label>
    </p>
</fieldset>

                <fieldset class="checkbox <?php if ($beerERROR) print 'class="mistake"'; ?>">
                    <legend>Which type of beer do you prefer (you may pick more than one):</legend>

                    <p>
                        <label class="check-field">
                            <input <?php if ($ale) print 'class="checked"'; ?>
                                id="chkAle"
                                name="chkAle"
                                tabindex="420"
                                type="checkbox"
                                value="Ale"> Ale</label>
                    </p>

                    <p>
                        <label class="check-field">
                            <input <?php if ($lager) print " checked "; ?>
                                id="chkLager" 
                                name="chkLager" 
                                tabindex="430"
                                type="checkbox"
                                value="Lager"> Lager</label>
                    </p>

                    <p>
                        <label class="check-field">
                            <input <?php if ($ipa) print " checked "; ?>
                                id="chkIPA" 
                                name="chkIPA" 
                                tabindex="430"
                                type="checkbox"
                                value="IPA"> IPA</label>
                    </p>

                    <p>
                        <label class="check-field">
                            <input <?php if ($stout) print " checked "; ?>
                                id="chkStout" 
                                name="chkStout" 
                                tabindex="430"
                                type="checkbox"
                                value="Stout"> Stout</label>
                    </p>

                </fieldset>
                
                <fieldset  class="listbox <?php if ($seasonERROR) print 'class="mistake"'; ?>">
    
    <legend>How many New Jersey breweries have you visited?</legend>
        <select id="lstBrewery" 
                name="lstBrewerys" 
                tabindex="520" >
            <option <?php if ($brewerys == "None") print " selected "; ?>
                value="None">None</option>
            
            <option <?php if ($brewerys == "1-5") print " selected "; ?>
                value="1-5">1-5</option>

            <option <?php if ($brewerys == "6-10") print " selected "; ?>
                value="6-10">6-10</option>

            <option <?php if ($brewerys == "more than 10") print " selected "; ?>
                value="more than 10">more than 10</option>
        </select>
    
</fieldset>

                <fieldset class="textarea">
                    <p>
                        <label  class="required" for="txtSuggestion">Suggestion</label>
                        <textarea <?php if ($suggestionERROR) print 'class="mistake"'; ?>
                            id="txtSuggestion" 
                            name="txtSuggestion" 
                            onfocus="this.select()" 
                            tabindex="200"><?php print $suggestion; ?></textarea>
                    </p>
                </fieldset>


                <fieldset class="buttons">
                    <legend></legend>
                    <input class = "button" id = "btnSubmit" name = "btnSubmit" tabindex = "900" type = "submit" value = "Register" >
                </fieldset>     
            </form>
            <?php
        }
        ?>       
    </article>     
</main>
<?php include 'footer.php'; ?>
</body>     
</html>