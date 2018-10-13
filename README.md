## Features

- No javascript tracking: fast, elegant and adblock-proof solution;
- Different actions: click, hover, check (a checkbox) and keep-hovering;
- Descriptive: Every action to be tracked can have it's natural language description as *User clicked on search box* ;
- Automatically detects and log: Browser, screen orientation, screen size;
- Ignore some agents as *googlebot* and *bingbot* ;
- Ignore IP addresses with wildcard support;
- Support table prefix so you can use the database you already have without problems;
- Use sessions to track user navigation;

![](https://img.shields.io/badge/PHP-5.4%2B-ff69b4.svg) ![](https://img.shields.io/badge/MySQL-5.7%2B-ff69b4.svg) ![](https://img.shields.io/github/license/mashape/apistatus.svg)  [![GitHub issues](https://img.shields.io/github/issues/lucaasleaal/csstrackr.svg)](https://github.com/lucaasleaal/csstrackr/issues) [![GitHub forks](https://img.shields.io/github/forks/lucaasleaal/csstrackr.svg)](https://github.com/lucaasleaal/csstrackr/network) [![GitHub stars](https://img.shields.io/github/stars/lucaasleaal/csstrackr.svg)](https://github.com/lucaasleaal/csstrackr/stargazers) [![Twitter](https://img.shields.io/twitter/url/https/github.com/lucaasleaal/csstrackr.svg?style=social)](https://twitter.com/intent/tweet?text=Wow:&url=https%3A%2F%2Fgithub.com%2Flucaasleaal%2Fcsstrackr) 


## How to use

1 - Clone or download the repository and unzip it.

2 - Install composer in your computer if you do not already have it (it is VERY easy I promise) and run the command "composer upgrade" inside the CSSTrackr folder. That command will download the dependencies.

3 - Create a database to store user data, if you do not have it yet. You can find the SQL code to create the two needed tables inside the database.sql file in this repository.

4 - You need to setup your DB connection (edit config.php);

5 - You need to setup your trackers with css selectors (edit config.php);

6 - Include the auto-generated css file in your webpage header:
```html
<link rel="stylesheet" href="csstrackr/csstrackr.css.php" type="text/css" media="all">
```

## Query examples

1 - Get the top 10 actions:

```sql
SELECT
value, COUNT(*) as QTY
FROM action
GROUP BY value
ORDER BY COUNT(*) DESC
LIMIT 10
```
2 - Get the top 10 viewport width:

```sql
SELECT
viewport_width, COUNT(*) AS QTY
FROM session
GROUP BY viewport_width
ORDER BY COUNT(*) DESC
LIMIT 10
```
3 - Get the top 10 browsers:

```sql
SELECT
browser, COUNT(*) AS QTY
FROM session
GROUP BY browser
ORDER BY COUNT(*) DESC
LIMIT 10
```
