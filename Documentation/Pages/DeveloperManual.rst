.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


Developer Manual
================

The `FrontendFormProtectionService` can be used to generate and validate xsrf tokens.
Creating a hidden field and retrieving the sent token has to be handled separately, as this
is not part of this extension.

The function `generateToken($formName, $action = '', $formInstanceName = '')` can generate a token, that can be placed
in a hidden field in the form. You have to at least specify a form name, so that every form get a different token.
In addition to that, a form action and instance name can be specified, to generate different tokens for different
actions or even a unique token, each time a form is sent.

To validate a token, the function `validateToken($tokenId, $formName, $action = '', $formInstanceName = '')` can be used.
The parameters have to be exactly the same, as when the token was created.