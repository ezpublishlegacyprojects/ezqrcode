==========
eZ QR Code
==========

Author: Bertrand Dunogier, eZ Systems

Synopsis
========

This extension provides an API as well as the ezpublish features to generate QR Codes based on content.

What are QR Codes
=================
QR Codes are two dimensional bar codes, created by Denso-Wave in 1994 (thank you Wikipedia). These codes can contain a
large variety of data: URLs, vCards, geographical data, etc, and have been picked up by google for Android based
devices. As an example, you can see on http://code.google.com/ that any downloadable file has a QR code image.

QR codes can be scanned using a hand held device, which will then propose an action based on the decrypted data:
open an URL, install an app, etc.

This extension
==============

Google chart API
----------------

The current implementation only uses the google chart API. This very simple API allows you to provide an URL with a few
fields regarding the desired chart, and get an image in return. While this is far from perfect when it comes to data
privacy, it does the job.

Implementation
--------------
ezqrcode is very simple at the moment.

It has a base class, eZQRCode, that can be used to set all the available parameters: size, error correction, data, etc.
Based on this, the class will return the URL for the image on chart.apis.google.com.

This class is currently only implemented in a template operator named qrcode::

    {'http://share.ez.no/'|qrcode( "200x200" )}

Will return a link to the QR code for the URL share.ez.no.