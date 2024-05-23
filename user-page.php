<?php
require 'php/dbconnection.php';
include 'php/sessioncheck.php';
check_user_role(1);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>AdU Cats</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- LINKS -->
        <link rel="stylesheet" href="style/user-page.css">
    </head>
    <body>
        <header class="logo">
            <img src="img/Cat-2.png" alt="logo_cat">
            <h1>Adoption</h1>
        </header>
            <div class="hline"></div>
            <h3>Donation</h3>

        <!-- SECTION 1: Donation -->
        <section class="records">
            <div class="record-content">
                <table class="table">
                   <!-- HEADER  -->
                    <tr class="table-header">
                        <th>Donation #</th>
                        <th>Date</th>
                    </tr>
                    <!-- CONTENTS -->
                    <tr class="product-contents">
                        <td>ABC</td>
                        <td>May 19, 2024</td>
                    </tr>
                    <tr class="product-contents">
                        <td>EFG</td>
                        <td>May 20, 2024</td>
                    </tr>
                    <tr class="product-contents">
                        <td>HIJ</td>
                        <td>May 21, 2024</td>
                    </tr>
                </table>
              </div>
        </section>

        <h3>Adoption</h3>
        <!-- SECTION 2: Adoption -->
        <section class="records">
            <div class="record-content">
                <table class="table">
                   <!-- HEADER  -->
                    <tr class="table-header">
                        <th>Adoption #</th>
                        <th>Date</th>
                    </tr>
                    <!-- CONTENTS -->
                    <tr class="product-contents">
                        <td>ABC</td>
                        <td>May 19, 2024</td>
                    </tr>
                    <tr class="product-contents">
                        <td>EFG</td>
                        <td>May 20, 2024</td>
                    </tr>
                    <tr class="product-contents">
                        <td>HIJ</td>
                        <td>May 21, 2024</td>
                    </tr>
                </table>
              </div>
        </section>
    </body>
</html>