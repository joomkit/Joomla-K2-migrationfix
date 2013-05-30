<?php
/**
 * @version  	$Id: index.php 10381 2008-06-01 03:35:53Z pasamio $
 * @package		Joomla
 * @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */
// Set flag that this is a parent file
define('_JEXEC', 1);
define('JPATH_BASE', dirname(__FILE__));
define('DS', DIRECTORY_SEPARATOR);
require_once ( JPATH_BASE . DS . 'includes' . DS . 'defines.php' );
require_once ( JPATH_BASE . DS . 'includes' . DS . 'framework.php' );
$mainframe =  JFactory::getApplication('site');
$mainframe->initialise();


//$uid = '';
//$aclevel ='';
$uid = (int)JRequest::getVar('userid');
$aclevel = (int)JRequest::getVar('accesslevel'); 

$db = JFactory::getDBO();

$query = 'SELECT id,username,email'
        . ' FROM #__users'
        . ' WHERE usertype = "Super Users" or usertype = "Administrator" or usertype = "Manager"'
        . ' ORDER BY id';
$db->setQuery($query);

$result = $db->loadObjectList();

// add a first option to the list without looking at the database result
$options[] = JHTML::_('select.option', '', JText::_('Choose a userid'));

//now fill the array with your database result
foreach ($result as $key => $value) :
    $options[] = JHTML::_('select.option', $value->id, JText::_('[' . $value->id . '] ' . $value->username . ' [' . $value->email . ']'));
endforeach;
//print_r($options);
//echo JHTML::_('select.genericlist', $options,'myfilter', 'class="inputbox"  multiple="multiple"','value','text');
$userlist = JHTML::_('select.genericlist', $options, 'userid', array('class' => 'input-xlarge', 'option.attr' => 'data'));


?>

<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
        <script type="text/javascript" src="http://twitter.github.io/bootstrap/assets/js/bootstrap-tab.js"></script>

        <link href="http://twitter.github.io/bootstrap/assets/css/bootstrap.css" rel="stylesheet">  
        <link href="http://twitter.github.io/bootstrap/assets/css/bootstrap-responsive.css" rel="stylesheet">

        <style>
            #wrap {
                max-width: 940px;
                padding-left: 0px;
                padding-right: 0px;
                padding-top: 0px;
                margin: 0 auto;
            }
        </style>

      
        
                                        <script type="text/javascript">
                                            
                                          
                                            jQuery(document).ready(function() {
                                                  
                                                var $tabContent = $(".tab-pane"),
                                                    $tabs = $("ul#tabs li"),
                                                    tabId ;
                                                $("#submit").click(function() {
                                                    //alert('click');
                                                    $(".progress").show();
                                                    $(".bar").attr('style','width:10%');
                                                });
                                                
                                                $tabContent.hide();
                                                $("ul#tabs li:first").addClass("active").show();
                                                $tabContent.first().show();

                                                $tabs.click(function() {
                                                    var $this = $(this);
                                                    $tabs.removeClass("active");
                                                    $this.addClass("active");
                                                    $tabContent.hide();
                                                    var activeTab = $this.find("a").attr("href");
                                                    $(activeTab).show();
                                                    return false;
                                                });
                                                // Grab the ID of the .tab-content that the hash is referring to
                                                tabId = $(window.location.hash).closest('.tab-pane').attr('id');
                                               // alert(tabId);
                                                // Find the anchor element to "click", and click it
                                                $tabs.find('a[href=#' + tabId + ']').click();
                                            });
                                            

                                        </script> 
    </head>
    <body>

        <div id="wrap" class="container">
            <div class="row-fluid">
                <div class="container-fluid">   
                    <div class="row-fluid">
                        <div class="span12">
                            <img src="http://c5.joomkit.com/themes/joomkit/img/joomkt-logo.gif">
                            <h2>Joomla 2.5 K2 post migration help/fix</h2> 
                            <div id="msg" class="alert alert-error">
                                <h4>Warning</h4>
                                        <p>Please dont use this if you have not backed up your target database</p>
                                        </div>
                                        <div id="content">
                                            <ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
                                                <li><a class="active" href="#doit" data-toggle="tab">OK I wanna do it</a></li>
                                                <li ><a href="#read" data-toggle="tab">Please read</a></li>
                                                <li><a href="#what" data-toggle="tab">What does it do?</a></li>
                                                

                                            </ul>
                                            <div id="" class="tab-content">
                                                <div class="tab-pane active" id="doit">

                                                    <p>       
                                                       
                                                    <form id="form" class="form-horizontal" method="post" action="<?php echo $PHP_SELF; ?>">

                                                            <!-- Form Name -->
                                                            <div class="progress progress-striped active">
                                                                <div id="pbar" class="bar" style="width: 0%;"></div>
                                                            </div>
                                                        <?php echo fixit($uid, $aclevel); ?>    
                                                            <div id="cfix">
                                                            <fieldset>
                                                            <!-- Select Basic -->
                                                            <div class="control-group">
                                                                <label class="control-label" for="selectbasic">Select User id to associate with K2 items</label>
                                                                <div class="controls">
                                                                    <?php echo $userlist; ?>
                                                                </div>
                                                            </div>


                                                            <!-- Text input-->
                                                            <div class="control-group">
                                                                <label class="control-label" for="accesslevel">Access Level</label>
                                                                <div class="controls">
                                                                    <select id="accesslevel" name="accesslevel" class="input-mini">
                                                                        <option value="">--</option>
                                                                        <option value="0">0</option>
                                                                        <option value="1">1</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <!-- Button -->
                                                            <div class="control-group">
                                                                <label class="control-label" for="submit">Do it</label>
                                                                <div class="controls">
                                                                    <button id="submit" name="submit" class="btn btn-success">Push</button>
                                                                </div>
                                                            </div>

                                                        </fieldset>
                                                            </div>
                                                    </form></p>
                                                </div>

                                                <div class="tab-pane " id="read">
                                                    <h4>Who is this for?</h4>
                                                    <p>This file is for the purpose of trying to fix Joomla menu items that link to K2 content after a migration from Joomla 1.5 to 2.5</p>
                                                    <p>If after migrating your 2.5 menu shows K2 component not found like the image below then this fix might help you.</p>
                                                    <p>If you have multiple authors for K2 items then this will probably NOT be for you 
                                                        as it will replace the owner/user/modified by id of k2 items with a single user id <span class="label label-warning">you have been warned</span>
                                                    </p>
                                                    <p>
                                                        <img src="http://www.joomkit.com/migratehelp/k2_menu_items_missing.png" />
                                                    </p>
                                                </div>
                                                <div class="tab-pane" id="what">
                                                    <h4>What does this do?</h4>
                                                    <p>Simple really it does 5 things</p>
                                                    <ol>
                                                        <li>Connects to your 2.5 database via core config</li>
                                                        <li>Updates k2 items with user id of your choosing so they can be accessed 
                                                        <span class="label label-warning">
                                                                They all get same user id!
                                                            </span></li>
                                                        <li>Updates k2 Categories to make sure they all published - <span class="label label-warning">
                                                                They all get published!
                                                            </span></li>
                                                        <li>Looks in extensions table to see what the K2 extension id is</li>
                                                        <li>Updates k2 items in the menu table with the correct extension id</li>
                                                    </ol>
                                                    <p>This form lets you </p>
                                                </div>
                                                
                                            </div>
                                        </div>






                                        </div>
                                        </div>
                                        </div>  
            </div>
           </div>
                                        </body>
                                        </html>
 <?php

    
 function fixit($uid, $aclevel){
     
     
          global $mainframe;                                  
          
    if ((!$uid) || ($aclevel <  0))  return false;
    
   
        //items
        $db = JFactory::getDBO();
        $query = "UPDATE #__k2_items SET `created_by` = $uid, `modified_by` = $uid, `access` = $aclevel ";

        $db->setQuery($query);
        
         if(!$result = $db->query()):
            echo '<p><pre><span class="label label-danger">Items update - Whoops: is K2 installed?</span><br>'. $db->stderr().'</pre></p>';

            echo "<script>document.getElementById('pbar').style.width = '2%';</script>";
            return;
            else:
                echo "<script>document.getElementById('pbar').style.width = '20%';</script>";
        endif;


        //category

        $query = "UPDATE #__k2_categories SET `access` = $aclevel  ;";
        $db->setQuery($query);

        if(!$result = $db->query()):
            echo '<p><span class="alert alert-danger">Category update - Whoops:<span><br><pre>'. $db->stderr().'</pre></p>';
            return;
            else:
                echo "<script>document.getElementById('pbar').style.width = '40%';</script>";
        endif;

        //find K2 etension id
        
        $db = &JFactory::getDBO();
        $query = "SELECT `extension_id` from #__extensions WHERE `element` = 'com_k2'";

        $db->setQuery($query);
        if(!$extid = $db->loadObject() ):
            
            echo '<p><span class="alert alert-danger">Cant find K2 extension id:<span><br><pre>'. $db->stderr().'</pre></p>';
            return;
            else:
                echo "<script>document.getElementById('pbar').style.width = '80%';</script>";
     

        endif;
//var_dump($extid);


//   $query = "UPDATE #__menu SET `component_id` = $extid->extension_id WHERE `link` LIKE '%com_k2%';";
        $query = "UPDATE #__menu SET `component_id` = 0 WHERE `link` LIKE '%com_k2%';";

        $db->setQuery($query);
        
        if(!$result = $db->query()):
            echo '<p><span class="alert alert-danger">Could not update menu:<span><br><pre>'. $db->stderr().'</pre></p>';
            return;
            else:
                
               echo "<script>
                     jQuery(document).ready(function() {
                    $(\"#cfix\").fadeOut(300, function(){ 
                        $(this).remove();
                    }); 
                     
                    });</script>";
                echo "<script>document.getElementById('pbar').style.width = '50%';</script>";
                sleep(2);
                echo "<script>document.getElementById('pbar').style.width = '100%';</script>";
                sleep(2);
                 echo '<p><span class="alert alert-success">Finished - go login and check<span></p>';
                 
        endif;

    //endif;
        
 }
 ?>
