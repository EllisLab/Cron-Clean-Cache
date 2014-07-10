# Cron-Clean-Cache

Used with the Cron plugin to automatically clean out a directory located in the
`/system/cache/` directory of your ExpressionEngine site. Does not allow you to
specify multiple directories for the simple reason that deleting files actually
does take time and it is a far better idea to have a different cron (and time)
for each directory you want to clear.

## Parameters

- `which=""` - specify which directory in the /system/cache/ directory of your site
that you wanted deleted. ExpressionEngine comes, by default, with four cache
directories (db_cache, sql_cache, tag_cache, page_cache), which you can specify
without the '_cache' suffix. For example, just specify which="db".
- `limit=""` - Limit the number of files to be deleted. If your site is popular and
has a lot of caching, you do not want the plugin chugging away while a person
tries to view your site. So, there is a limit to how many files this plugin
will delete at one time. The default is 150.

## Examples

Clear out the db_cache directory every morning at 5am.

    {exp:cron minute="0" hour="5" which="db_cache" plugin="cron_clean_cache"}{/exp:cron}

## Change Log

- 1.1
	- Updated plugin to be 2.0 compatible
