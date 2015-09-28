
<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.plugin.plugin' );

// Lets load the language file
$lang = JFactory::getLanguage();
$lang->load("plg_simple_jcomments", JPATH_ADMINISTRATOR);

class plgJEventsSimpleJComments extends JPlugin
{
	function onDisplayCustomFields(&$row){
            if (file_exists(JPATH_SITE.'/components/com_jcomments/jcomments.php')) {
                    require_once(JPATH_SITE.'/components/com_jcomments/jcomments.php');
                    $row->_jcomments = JComments::showComments($row->rp_id(), 'com_jevents', $row->content());
                    return $row->_jcomments;
            }		
	}	
        
	static function fieldNameArray($layout='detail')
	{
            if ($layout != "detail")
                    return array();
            $labels = array();
            $values = array();
            $labels[] = JText::_("JEV_JCOMMENTS", true);
            $values[] = "JEV_JCOMMENTS_ENABLE";

            $return = array();
            $return['group'] = JText::_("JEV_JCOMMENTS", true);
            $return['values'] = $values;
            $return['labels'] = $labels;

            return $return;

	}
        static function substitutefield($row, $code)
	{
            if ($code == "JEV_JCOMMENTS_ENABLE")
            {
                return $row->_jcomments;			
            }
	}

}
