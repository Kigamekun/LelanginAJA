<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- <link rel="stylesheet" href="./web/modern-normalize.css"> -->
    <!-- <link rel="stylesheet" href="./web/web-base.css"> -->
    <!-- <link rel="stylesheet" href="./invoice.css"> -->
    <!-- <script type="text/javascript" src="./web/scripts.js"></script> -->
</head>

<body>
    <style>
        /*! modern-normalize v1.0.0 | MIT License | https://github.com/sindresorhus/modern-normalize */
        /* These styles are only for rendering in a browser */
        /*
  Common invoice styles. These styles will work in a browser or using the HTML
  to PDF anvil endpoint.
*/

        body {
            font-size: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table tr td {
            padding: 0;
        }

        table tr td:last-child {
            text-align: right;
        }

        .bold {
            font-weight: bold;
        }

        .right {
            text-align: right;
        }

        .large {
            font-size: 1.75em;
        }

        .total {
            font-weight: bold;
            color: #fb7578;
        }

        .logo-container {
            margin: 20px 0 70px 0;
        }

        .invoice-info-container {
            font-size: 0.875em;
        }

        .invoice-info-container td {
            padding: 4px 0;
        }

        .client-name {
            font-size: 1.5em;
            vertical-align: top;
        }

        .line-items-container {
            margin: 70px 0;
            font-size: 0.875em;
        }

        .line-items-container th {
            text-align: left;
            color: #999;
            border-bottom: 2px solid #ddd;
            padding: 10px 0 15px 0;
            font-size: 0.75em;
            text-transform: uppercase;
        }

        .line-items-container th:last-child {
            text-align: right;
        }

        .line-items-container td {
            padding: 15px 0;
        }

        .line-items-container tbody tr:first-child td {
            padding-top: 25px;
        }

        .line-items-container.has-bottom-border tbody tr:last-child td {
            padding-bottom: 25px;
            border-bottom: 2px solid #ddd;
        }

        .line-items-container.has-bottom-border {
            margin-bottom: 0;
        }

        .line-items-container th.heading-quantity {
            width: 50px;
        }

        .line-items-container th.heading-price {
            text-align: right;
            width: 100px;
        }

        .line-items-container th.heading-subtotal {
            width: 100px;
        }

        .payment-info {
            width: 38%;
            font-size: 0.75em;
            line-height: 1.5;
        }

        .footer {
            margin-top: 100px;
        }

        .footer-thanks {
            font-size: 1.125em;
        }

        .footer-thanks img {
            display: inline-block;
            position: relative;
            top: 1px;
            width: 16px;
            margin-right: 4px;
        }

        .footer-info {
            float: right;
            margin-top: 5px;
            font-size: 0.75em;
            color: #ccc;
        }

        .footer-info span {
            padding: 0 5px;
            color: black;
        }

        .footer-info span:last-child {
            padding-right: 0;
        }

        .page-container {
            display: none;
        }


        .web-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        /*
Document
========
*/

        /**
Use a better box model (opinionated).
*/

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        /**
Use a more readable tab size (opinionated).
*/

        :root {
            -moz-tab-size: 4;
            tab-size: 4;
        }

        /**
1. Correct the line height in all browsers.
2. Prevent adjustments of font size after orientation changes in iOS.
*/

        html {
            line-height: 1.15;
            /* 1 */
            -webkit-text-size-adjust: 100%;
            /* 2 */
        }

        /*
Sections
========
*/

        /**
Remove the margin in all browsers.
*/

        body {
            margin: 0;
        }

        /**
Improve consistency of default fonts in all browsers. (https://github.com/sindresorhus/modern-normalize/issues/3)
*/

        body {
            font-family:
                system-ui,
                -apple-system,
                /* Firefox supports this but not yet `system-ui` */
                'Segoe UI',
                Roboto,
                Helvetica,
                Arial,
                sans-serif,
                'Apple Color Emoji',
                'Segoe UI Emoji';
        }

        /*
Grouping content
================
*/

        /**
1. Add the correct height in Firefox.
2. Correct the inheritance of border color in Firefox. (https://bugzilla.mozilla.org/show_bug.cgi?id=190655)
*/

        hr {
            height: 0;
            /* 1 */
            color: inherit;
            /* 2 */
        }

        /*
Text-level semantics
====================
*/

        /**
Add the correct text decoration in Chrome, Edge, and Safari.
*/

        abbr[title] {
            text-decoration: underline dotted;
        }

        /**
Add the correct font weight in Edge and Safari.
*/

        b,
        strong {
            font-weight: bolder;
        }

        /**
1. Improve consistency of default fonts in all browsers. (https://github.com/sindresorhus/modern-normalize/issues/3)
2. Correct the odd 'em' font sizing in all browsers.
*/

        code,
        kbd,
        samp,
        pre {
            font-family:
                ui-monospace,
                SFMono-Regular,
                Consolas,
                'Liberation Mono',
                Menlo,
                monospace;
            /* 1 */
            font-size: 1em;
            /* 2 */
        }

        /**
Add the correct font size in all browsers.
*/

        small {
            font-size: 80%;
        }

        /**
Prevent 'sub' and 'sup' elements from affecting the line height in all browsers.
*/

        sub,
        sup {
            font-size: 75%;
            line-height: 0;
            position: relative;
            vertical-align: baseline;
        }

        sub {
            bottom: -0.25em;
        }

        sup {
            top: -0.5em;
        }

        /*
Tabular data
============
*/

        /**
1. Remove text indentation from table contents in Chrome and Safari. (https://bugs.chromium.org/p/chromium/issues/detail?id=999088, https://bugs.webkit.org/show_bug.cgi?id=201297)
2. Correct table border color inheritance in all Chrome and Safari. (https://bugs.chromium.org/p/chromium/issues/detail?id=935729, https://bugs.webkit.org/show_bug.cgi?id=195016)
*/

        table {
            text-indent: 0;
            /* 1 */
            border-color: inherit;
            /* 2 */
        }

        /*
Forms
=====
*/

        /**
1. Change the font styles in all browsers.
2. Remove the margin in Firefox and Safari.
*/

        button,
        input,
        optgroup,
        select,
        textarea {
            font-family: inherit;
            /* 1 */
            font-size: 100%;
            /* 1 */
            line-height: 1.15;
            /* 1 */
            margin: 0;
            /* 2 */
        }

        /**
Remove the inheritance of text transform in Edge and Firefox.
1. Remove the inheritance of text transform in Firefox.
*/

        button,
        select {
            /* 1 */
            text-transform: none;
        }

        /**
Correct the inability to style clickable types in iOS and Safari.
*/

        button,
        [type='button'],
        [type='reset'],
        [type='submit'] {
            -webkit-appearance: button;
        }

        /**
Remove the inner border and padding in Firefox.
*/

        ::-moz-focus-inner {
            border-style: none;
            padding: 0;
        }

        /**
Restore the focus styles unset by the previous rule.
*/

        :-moz-focusring {
            outline: 1px dotted ButtonText;
        }

        /**
Remove the additional ':invalid' styles in Firefox.
See: https://github.com/mozilla/gecko-dev/blob/2f9eacd9d3d995c937b4251a5557d95d494c9be1/layout/style/res/forms.css#L728-L737
*/

        :-moz-ui-invalid {
            box-shadow: none;
        }

        /**
Remove the padding so developers are not caught out when they zero out 'fieldset' elements in all browsers.
*/

        legend {
            padding: 0;
        }

        /**
Add the correct vertical alignment in Chrome and Firefox.
*/

        progress {
            vertical-align: baseline;
        }

        /**
Correct the cursor style of increment and decrement buttons in Safari.
*/

        ::-webkit-inner-spin-button,
        ::-webkit-outer-spin-button {
            height: auto;
        }

        /**
1. Correct the odd appearance in Chrome and Safari.
2. Correct the outline style in Safari.
*/

        [type='search'] {
            -webkit-appearance: textfield;
            /* 1 */
            outline-offset: -2px;
            /* 2 */
        }

        /**
Remove the inner padding in Chrome and Safari on macOS.
*/

        ::-webkit-search-decoration {
            -webkit-appearance: none;
        }

        /**
1. Correct the inability to style clickable types in iOS and Safari.
2. Change font properties to 'inherit' in Safari.
*/

        ::-webkit-file-upload-button {
            -webkit-appearance: button;
            /* 1 */
            font: inherit;
            /* 2 */
        }


        summary {
            display: list-item;
        }
    </style>

    <div class="web-container">


        <center>

            <span>
                <img style="height: 88px" src="https://i.ibb.co/drXdby8/sneat.png">
                <h3>LelanginAJA</h3>
            </span>
        </center>
        <table class="invoice-info-container">
            <tr>
                <td rowspan="2" class="client-name">
                    Client Name
                </td>
                <td>
                    {{ $data->user->name }}
                </td>
            </tr>
            <tr>
                <td>
                    {{ $data->user->state }}
                </td>
            </tr>
            <tr>
                <td>
                    Invoice Date: <strong>{{ date('d F Y', strtotime(now())) }}</strong>
                </td>
                <td>
                    {{ $data->user->address }}
                </td>
            </tr>
            <tr>
                <td>
                    Invoice No: <strong>INV-{{ $data->transaction_id }}</strong>
                </td>
                <td>
                    {{ $data->user->email }}
                </td>
            </tr>
        </table>


        <table class="line-items-container">
            <thead>
                <tr>
                    <th class="heading-quantity">No</th>
                    <th class="heading-description">Name</th>
                    <th class="heading-price">Start From</th>
                    <th class="heading-subtotal">Bid</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>{{ $data->product->name }}</td>
                    <td class="right">Rp.{{ number_format($data->product->start_from, 0, ',', '.') }}</td>
                    <td class="bold">Rp.{{ number_format($data->auction_price, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>


        <table class="line-items-container has-bottom-border">
            <thead>
                <tr>
                    <th>Payment Info</th>
                    <th>Due By</th>
                    <th>Total Due</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="payment-info">
                        <div>
                            Payment Status: <strong>{{ $data->payment_status_message }}</strong>
                        </div>

                    </td>
                    <td class="">{{ date('d F Y', strtotime(now())) }}</td>
                    <td class="large total">Rp.{{ number_format($data->auction_price, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <div class="footer">
            <div class="footer-info">
                <span>reksa.prayoga1012@gmail.com</span> |
                <span>+62 89533 149 3506</span> |
                <span>lelanginaja.com</span>
            </div>
            <div class="footer-thanks">

            </div>
        </div>

    </div>



</body>

</html>