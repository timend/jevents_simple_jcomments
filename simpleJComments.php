
<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.plugin.plugin' );

// Lets load the language file
$lang = JFactory::getLanguage();
$lang->load("plg_jevents_simple_jcomments", JPATH_ADMINISTRATOR);

class plgJEventsSimpleJComments extends JPlugin
{
    function onDisplayCustomFields(&$row){        
        if (file_exists(JPATH_SITE.'/components/com_jcomments/jcomments.php')) {
            require_once(JPATH_SITE.'/components/com_jcomments/jcomments.php');
            $row->_jcomments = JComments::showComments($row->rp_id(), 'com_jevents', $row->content());
            $row->_jcommentsCount = "<div class=\"simple_jcomments_counter\">". 
                        JComments::getCommentsCount($row->rp_id(), 'com_jevents'). " Kommentar(e)</div>";
            return $row->_jcomments;
        }		
    }	

    function onDisplayCustomFieldsMultiRow($rows)
    {
        //TODO: Optimize if necessary
        foreach($rows as $row) {
            $this->onDisplayCustomFields($row);
        }
    }

    static function fieldNameArray($layout='detail')
    {
        if ($layout != "detail" && $layout != "list") {
            return array();
        }
        
        $labels = array();
        $values = array();
        $labels[] = JText::_("JEV_SIMPLE_JCOMMENTS_ENABLE", true);
        $values[] = "JEV_SIMPLE_JCOMMENTS_ENABLE";
        $labels[] = JText::_("JEV_SIMPLE_JCOMMENTS_COUNT", true);
        $values[] = "JEV_SIMPLE_JCOMMENTS_COUNT";

        $return = array();
        $return['group'] = JText::_("JEV_SIMPLE_JCOMMENTS", true);
        $return['values'] = $values;
        $return['labels'] = $labels;

        return $return;

    }
    
    static function substitutefield($row, $code)
    {
        if ($code == "JEV_SIMPLE_JCOMMENTS_ENABLE") {
            return $row->_jcomments;			
        } else if ($code == "JEV_SIMPLE_JCOMMENTS_COUNT") {
            return $row->_jcommentsCount;		
        }
    }
}
