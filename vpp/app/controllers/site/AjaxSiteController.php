<?php

/**
 * Created by PhpStorm.
 * User: tuanna
 * Date: 27/06/2016
 * Time: 6:22 SA
 */
class AjaxSiteController extends BaseController
{
    public function __construct()
    {

    }

    public function addCart(){
        $product_id = (int)Request::get('product_id',0);
        $product_num = (int)Request::get('product_num',0);
        $data['success'] = 0;
        $product = Product::find($product_id);
        $product = $product->toArray();
        if(!$product || ($product && $product['product_Status'] != 1)){
            $data['mess'] = 'Không tìm thấy sản phẩm bạn đặt mua';
            return Response::json($data);
        }
        $cart = Session::has('cart') ? Session::get('cart') : array();
        if(isset($cart[$product_id])){
            $cart[$product_id]['product_num'] += $product_num;
        }else{
            $cart[$product_id] = array(
                'product_id' => $product_id,
                'product_num' => $product_num,
                'product_Name' => $product['product_Name'],
                'product_Avatar' => $product['product_Avatar'],
                'product_Price' => $product['product_Price'],
            );
        }
        if($cart[$product_id]['product_num'] >= $product['product_bulk_quantity'] && $product['product_bulk_quantity'] > 0){
            $cart[$product_id]['product_price_buy'] = $product['product_bulk_price'];
        }else{
            $cart[$product_id]['product_price_buy'] = $product['product_Price'];
        }
        Session::put('cart', $cart);
        $data['success'] = 1;
        $data['html'] = View::make('site.SiteLayouts.cart')->with('cart',$cart);
        return Response::json($data);
    }

}