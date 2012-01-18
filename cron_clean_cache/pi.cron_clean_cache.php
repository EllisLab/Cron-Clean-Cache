<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
Copyright (C) 2005 - 2011 EllisLab, Inc.

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL
ELLISLAB, INC. BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

Except as contained in this notice, the name of EllisLab, Inc. shall not be
used in advertising or otherwise to promote the sale, use or other dealings
in this Software without prior written authorization from EllisLab, Inc.
*/

$plugin_info = array(
						'pi_name'			=> 'Clean Cache Directories',
						'pi_version'		=> '1.1',
						'pi_author'			=> 'Paul Burdick',
						'pi_author_url'		=> 'http://www.expressionengine.com/',
						'pi_description'	=> 'Cron based cache cleaner',
						'pi_usage'			=> Cron_clean_cache::usage()
					);

/**
 * Cron_clean_cache Class
 *
 * @package			ExpressionEngine
 * @category		Plugin
 * @author			ExpressionEngine Dev Team
 * @copyright		Copyright (c) 2005 - 2011, EllisLab, Inc.
 * @link			http://expressionengine.com/downloads/details/cron_clean_cache_directories/
 */

class Cron_clean_cache {


    var $return_data	= '';
    var $limit			= 150;		// # of files to delete
    var $count			= 0;		// # of Files Deleted
    
	/**
	 * Constructor
	 *
	 * @access	public
	 * @return	void
	 */
    function Cron_clean_cache()
    {
        $this->EE =& get_instance();

        $which = ($this->EE->TMPL->fetch_param('which') !== FALSE) ? $this->EE->TMPL->fetch_param('which') : 'all';
        $this->limit = ($this->EE->TMPL->fetch_param('limit') !== FALSE) ? $this->EE->TMPL->fetch_param('limit') : $this->limit;
    
        $default = array('page', 'tag', 'db', 'sql', 'all');
        
        if (in_array($which, $default))
        {
        	$this->EE->functions->clear_caching($which, '', TRUE);
			return;
        }

		$which = $this->security_check($which);
        
	  	$this->delete_directory(APPPATH.'cache/'.$which);	
           
    }

    // --------------------------------------------------------------------
    
	/**
	 * Delete directories
	 *
	 * @access   public
	 * @param    string
	 * @return   void
	 */
    function delete_directory($path)
    {
		$this->EE->functions->delete_directory($path);
    }

	// --------------------------------------------------------------------
    
	/**
	 * Folder name security
	 *
	 *
	 * @access   public
	 * @param    string
	 * @return   string
	 */
    function security_check($str)
    {
        $bad = array(
						"<!--",
						"-->",
						"../",
						"./",
						"'",
						'"',
						'&',
						'$',
						'=',
						';',
						'?',
						'/',
						"%20",
						"%22",
						"%3c",		// <
						"%253c", 	// <
						"%3e", 		// >
						"%0e", 		// >
						"%28", 		// (  
						"%29", 		// ) 
						"%2528", 	// (
						"%26", 		// &
						"%24", 		// $
						"%3f", 		// ?
						"%3b", 		// ;
						"%3d"		// =
        			);
        			
        $str = str_replace($bad, '', $str);   
    
    	return $str;
	}

	// --------------------------------------------------------------------
	
	/**
	 * Usage
	 *
	 * Plugin Usage
	 *
	 * @access	public
	 * @return	string
	 */
	function usage()
	{

		ob_start(); 
		?>

		Used with the Cron plugin to automatically clean out a directory located in the 
		/system/cache/ directory of your ExpressionEngine site. Does not allow you to 
		specify multiple directories for the simple reason that deleting files actually
		does take time and it is a far better idea to have a different cron (and time)
		for each directory you want to clear.

		============================
		 PARAMETERS
		============================

		which="" - specify which directory in the /system/cache/ directory of your site
		that you wanted deleted.  ExpressionEngine comes, by default, with four cache 
		directories (db_cache, sql_cache, tag_cache, page_cache), which you can specify 
		without the '_cache' suffix.  For example, just specify which="db".

		limit="" - Limit the number of files to be deleted.  If your site is popular and
		has a lot of caching, you do not want the plugin chugging away while a person
		tries to view your site.  So, there is a limit to how many files this plugin
		will delete at one time.  The default is 150.

		============================
		 EXAMPLES
		============================

		Clear out the db_cache directory every morning at 5am.

		{exp:cron minute="0" hour="5" which="db_cache" plugin="cron_clean_cache"}{/exp:cron}


		Version 1.1
		******************
		- Updated plugin to be 2.0 compatible


		<?php
		
		$buffer = ob_get_contents();
	
		ob_end_clean(); 

		return $buffer;
	}

	// --------------------------------------------------------------------
	
}
// END CLASS

/* End of file pi.cron_clean_cache.php */
/* Location: ./system/expressionengine/third_party/cron_clean_cache/pi.cron_clean_cache.php */