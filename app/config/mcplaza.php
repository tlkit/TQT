<?php

/**
 * @config: mcplaza
 * @desc: config status global.
 */
return(
        array(
            'FLAG_SEND_SMS' => true,
            'FLAG_SEND_EMAIL' => true,

            'SOURCE_DETAIL' => 1,

            //Action
            'ACTION_CREATE_ORDER' => 1,
            'ACTION_SEND_SMS' => 2,
            'ACTION_SEND_EMAIL' => 3,
            'ACTION_ACTIVE_COUPON' => 4,
            'ACTION_RETURN_ORDER' => 5,

            //Vung tao action
            'TYPE_FRONTEND' => 1,
            'TYPE_SHOP' => 2,
            'TYPE_BACKEND' => 3,
        )
    );
?>
