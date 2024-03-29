# Cron-Clean-Cache

This plugin requires the [Cron plugin](https://github.com/EllisLab/Cron). See that add-on for documentation on use of the base plugin.

Used with the Cron plugin to automatically clean out a directory located in the `/system/cache/` directory of your ExpressionEngine site. Does not allow you to
specify multiple directories for the simple reason that deleting files actually does take time and it is a far better idea to have a different cron (and time) for each directory you want to clear.

**Note: This plugin is for caches using the File driver only.**

## Usage

### plugin="cron_clean_cache"

#### Example Usage

Clear out the db_cache directory every morning at 5am.

    {exp:cron minute="0" hour="5" which="db_cache" plugin="cron_clean_cache"}{/exp:cron}

#### Parameters

- `which=""` - specify which directory in the /system/cache/ directory of your site
that you wanted deleted. ExpressionEngine comes, by default, with four cache
directories (db_cache, sql_cache, tag_cache, page_cache), which you can specify
without the '_cache' suffix. For example, just specify which="db".
- `limit=""` - Limit the number of files to be deleted. If your site is popular and
has a lot of caching, you do not want the plugin chugging away while a person
tries to view your site. So, there is a limit to how many files this plugin
will delete at one time. The default is 150.

## Change Log

- 1.3
	- Updated license information
	- Added add-on icon
	- Added check to make sure directory exists
- 1.2
	- Updated plugin to be 3.0 compatible
- 1.1
	- Updated plugin to be 2.0 compatible
