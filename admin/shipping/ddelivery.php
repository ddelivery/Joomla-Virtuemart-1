<?php
if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );

class ddelivery{
    var $classname = "ddelivery",

        $debug = false ,

        $error = false,
        $err_msg = "",
        $xml_request = "",
        $xml_response = "",
        $fp,  // socket handle

        $xml_response_tree = array(),
        $shipping_methods = array(),
        $shipping_comment = "" ,

        $to_city = "",
        $to_provState = "",
        $to_country = "",
        $to_postal_code = "" ;

    function list_rates( &$d ){
        global $VM_LANG, $CURRENCY_DISPLAY;

        $d["ship_to_info_id"] = vmGet( $_REQUEST, "ship_to_info_id" );
        /** Read current Configuration ***/
        require_once(CLASSPATH ."shipping/".$this->classname.".cfg.php");

        $dbst = new ps_DB;
        $q  = "SELECT * from #__{vm}_user_info, #__{vm}_country WHERE user_info_id='" . $d["ship_to_info_id"]."' AND ( country=country_2_code OR country=country_3_code)";
        $dbst->query($q);
        $dbst->next_record();

        $cart = $_SESSION['cart'];
        $dboi = new ps_DB;
        $base = JFactory::getURI()->base(true);
        $path = $base.implode('/',array('','administrator','components','com_ddelivery',''));
	    //echo $path;
        $doc = JFactory::getDocument();
        $doc->addStyleSheet($path.'ddelivery'.DS.'assets'.DS.'demo-modals.css');
        $doc->addStyleSheet($path.'ddelivery'.DS.'assets'.DS.'the-modal.css');
        ?>
        
        <script src="<?php echo $path; ?>html/js/jquery-1.9.1.min.js"></script>
        <script type="text/javascript" src="<?php echo $path; ?>ddelivery/assets/jquery.the-modal.js"></script>
        <script src="<?php echo $path; ?>html/js/ddelivery.js"></script>
        
        

        <div class="modal" id="test-modal" style="display: none">
            <div id="ddelivery"></div>
            <?php
            /*
            ?>
            <a href="javascript:DDeliveryStart()">Выбрать способ доставки</a>
            <?php
            */
            ?>
        </div>
        
        <div style="float: left;">
        <input type="radio" name="shipping_rate_id" id="ddelivery_rate_id" style="float: left;" value="" />
        <img style="padding: 1px; height:25px; margin-right:10px; float:left;" src="<?php echo $path.'ddelivery'.DS.'assets'.DS; ?>DDlogo.png" />
        <input type="hidden" id="ddelivery_order_id" name="ddelivery_order_id" value="<?php echo $_SESSION['DIGITAL_DELIVERY']['ORDER_ID']; ?>" />
        <span id="dd_info"><?php
	    if (!$_SESSION['']) echo '';
        else echo 'Выберите способ доставки ';
        ?></span>
        <span style="font-size:small;"><a href="javascript:void(0)" class="trigger">Выберите способ доставки</a></span>
        <span id="dd_price" style="float:right; margin-left: 5px;">
            <?php echo ($_SESSION[''])?'':''; ?>    
        </span>
        </div>
        
        <script>
            // attach modal close handler
            function closePopup()
            {
                jQuery(function($){
                    $.modal().close();
                })
            }
            function DDeliveryStart(){

                jQuery('#test-modal').modal().open();

                var params = {
                    orderId: jQuery('#ddelivery_order_id').val()
                };
                var callback = {
                    close: function(){
                        closePopup();
                    },
                    change: function(data) {
                        closePopup();
                        console.log(params);
                        jQuery('#ddelivery_order_id').val(data.orderId);
                        params.orderId = data.orderId;
                        
                        jQuery('#dd_info').html(data.comment+ '.');
                        jQuery('#dd_price').html('<strong>Стоимость:</strong> '+data.clientPrice+' руб.');
                        jQuery('#ddelivery_rate_id').val(encodeURIComponent("ddelivery|"+data.comment+"|"+data.orderId+"|"+data.clientPrice));
                        jQuery('#ddelivery_rate_id').attr('checked',true);
                       } 
                    
                };
                var url = '<?php echo $path; ?>/ddelivery/ajax.php?<?php isset($_GET['XDEBUG_SESSION_START']) ? 'XDEBUG_SESSION_START='.(int)$_GET['XDEBUG_SESSION_START'] : ''?> ';
                console.log(url);
                DDelivery.delivery('ddelivery', url, params, callback);
            }
            //console.log(jQuery('input:radio[name=shipping_rate_id]').length );
            jQuery(document).ready(function(){
                if (jQuery('input:radio[name=shipping_rate_id]').length == 1){
                
                jQuery('#ddelivery_rate_id').attr('checked','true');
                jQuery('#ddelivery_rate_id').css('display','none');
                jQuery('input:image').click(function(){
                    location.reload(false);
                });
                }    
            });
            
            <?if(!empty($_GET['fast'])):?>
            DDeliveryStart();
            <?endif;?>
        </script>

        <script type="text/javascript">
            jQuery(function($) {
                $('body').on('click', '.trigger', function(e){
                    e.preventDefault();
                    DDeliveryStart();
                });
            });
        </script>
        <?php
        //echo 'DDelivery';
    }


    function show_configuration() {
        echo 'ddelivery configuration';

    }
    
    function get_rate( &$d ) {

	$shipping_rate_id = $d["shipping_rate_id"];
	$is_arr = explode("|", urldecode(urldecode($shipping_rate_id)) );
	$order_shipping = $is_arr[3];

	return $order_shipping;

	}
    
    function get_tax_rate() {

		/** Read current Configuration ***/
		require_once(CLASSPATH ."shipping/".$this->classname.".cfg.php");

		$shipping_rate_id = $d["shipping_rate_id"];
    	$is_arr = explode("|", urldecode(urldecode($shipping_rate_id)) );
    	$order_shipping = $is_arr[4];
    
    	return $order_shipping;
	}
    
    
}

