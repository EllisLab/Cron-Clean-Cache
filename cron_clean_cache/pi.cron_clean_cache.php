<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
Copyright (C) 2005 - 2015 EllisLab, Inc.

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

/**
 * Cron_clean_cache Class
 *
 * @package			ExpressionEngine
 * @category		Plugin
 * @author			EllisLab
 * @copyright		Copyright (c) 2004 - 2015, EllisLab, Inc.
 * @link			https://github.com/EllisLab/Cron-Clean-Cache
 */

class Cron_clean_cache {

	public $return_data = '';
	public $limit       = 150;		// # of files to delete
	public $count       = 0;		// # of Files Deleted

	/**
	 * Constructor
	 *
	 * @access	public
	 * @return	void
	 */
    function __construct()
    {
        $which = (ee()->TMPL->fetch_param('which') !== FALSE) ? ee()->TMPL->fetch_param('which') : 'all';
        $this->limit = (ee()->TMPL->fetch_param('limit') !== FALSE) ? ee()->TMPL->fetch_param('limit') : $this->limit;

        $default = array('page', 'tag', 'db', 'sql', 'all');

        if (in_array($which, $default))
        {
        	ee()->functions->clear_caching($which, '', TRUE);
			return;
        }

		$which = $this->security_check($which);
die();
		if (! is_dir(SYSPATH.'cache/'.$which))
		{
			ee()->logger->developer('Cron Clean Cache: '.SYSPATH.'cache/'.$which.' is not a directory');

			return true;
		}

	  	$this->delete_directory(SYSPATH.'cache/'.$which);
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
		ee()->functions->delete_directory($path);
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

}
