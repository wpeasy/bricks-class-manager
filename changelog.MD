# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [0.0.1] Initial Release


## [0.0.2] Update

### Changes
- Imported variables now sort alphabetically
- Wrap click to copy variables in var().e.g. --test copied as var(--test)

## [0.0.3] Update

### Updates
- Added "Variables" Tab to main page for easier access.

## [0.0.4] Fixes

### Fixes
- Changed class regex to better extract classes.
<pre><code>
/\.([^\d][0-9a-z-A-Z_\-]+[^.,{])/
</code></pre>

## [0.0.5] Fixes

### Fixes
- Some users reported ',' being caught in regex for classes. I was not able to replicate this. I added a trim to remove unwanted characters.
WPG_BSC/Parsers/Parser.php : Line 40:
$class = trim($class, ",.][{}" );
- Changed whitespace break in "Details". Long lines cause collapse of the class list
