<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * HTML View class for the HelloWorld Component
 */
class DDeliveryViewDDelivery extends JView
{
        // Overwriting JView display method
        function display($tpl = null) 
        {
                // Assign data to the view
                 JToolBarHelper::preferences('com_ddelivery');
 
                // Display the view
                parent::display($tpl);
        }
}