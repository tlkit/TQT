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
                'product_Code' => $product['product_Code'],
                'product_Name' => $product['product_Name'],
                'product_Avatar' => $product['product_Avatar'],
                'product_Price' => $product['product_Price'],
                'product_bulk_quantity' => $product['product_bulk_quantity'],
                'product_bulk_price' => $product['product_bulk_price'],
            );
        }
        if($cart[$product_id]['product_num'] >= $product['product_bulk_quantity'] && $product['product_bulk_quantity'] > 0){
            $cart[$product_id]['product_price_buy'] = $product['product_bulk_price'];
        }else{
            $cart[$product_id]['product_price_buy'] = $product['product_Price'];
        }
        Session::put('cart', $cart);
        $data['success'] = 1;
        $data['num_total'] = count($cart);
        $data['html'] = View::make('site.Web.cart')->with('cart',$cart)->render();
        return Response::json($data);
    }

    public function updateNumber(){
        $product_id = (int)Request::get('product_id',0);
        $product_num = (int)Request::get('product_num',0);
        $cart = Session::has('cart') ? Session::get('cart') : array();
        $data['success'] = 0;
        if(isset($cart[$product_id])){
            $cart[$product_id]['product_num'] = $product_num;
            if($cart[$product_id]['product_num'] >= $cart[$product_id]['product_bulk_quantity'] && $cart[$product_id]['product_bulk_quantity'] > 0){
                $cart[$product_id]['product_price_buy'] = $cart[$product_id]['product_bulk_price'];
            }else{
                $cart[$product_id]['product_price_buy'] = $cart[$product_id]['product_Price'];
            }
            Session::put('cart', $cart);
            $data['success'] = 1;
            $data['price'] = (int)$cart[$product_id]['product_price_buy'];
            $data['price_item'] = $cart[$product_id]['product_num'] * $cart[$product_id]['product_price_buy'];
            $total = 0;
            foreach($cart as $k => $v){
                $total += $v['product_num'] * $v['product_price_buy'];
            }
            $data['price_total'] = $total;
        }
        return Response::json($data);

    }

    public function removeProduct(){
        $product_id = (int)Request::get('product_id',0);
        $cart = Session::has('cart') ? Session::get('cart') : array();
        $data['success'] = 0;
        if(isset($cart[$product_id])){
            unset($cart[$product_id]);
            Session::put('cart', $cart);
            $data['success'] = 1;
            $total = 0;
            foreach($cart as $k => $v){
                $total += $v['product_num'] * $v['product_price_buy'];
            }
            $data['price_total'] = $total;
            $data['num_total'] = count($cart);
        }
        return Response::json($data);

    }

}