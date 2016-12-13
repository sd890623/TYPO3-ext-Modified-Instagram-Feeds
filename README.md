# TYPO3-ext-Modified-Instagram-Feeds

This project is a TYPO3 CMS system extension.
It basically allows users to load global instagram pictures with certain hashtags and list selected ones onto their TYPO3 based website.

The extension generates a standalone backend panel where the functionality resides.
The extension allows multiple campaigns to be created, which can be listed seperately in different pages.
In each campaign, user can fetch pictures from the Instagram API and then choose the ones they want to list on certain web page. 

In the backend, the extension is extbase based, which is a PHP framework (including ORM idea to manipulate database). And upon fetching records from Instagram API, the records are synchronized into local databases so as to improve the performance. 
In the front end (also including interface of the CMS backend module), Angular1 is used as JS framework (source files are under /instafeed/Resources/Public). This project consumes Instagram API and include all CRUD behaviors.