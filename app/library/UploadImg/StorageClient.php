<?php
/**
 * Created by JetBrains PhpStorm.
 * User: TuanNguyenAnh
 * Date: 6/18/14
 * Time: 10:42 AM
 * To change this template use File | Settings | File Templates.
 */
class StorageClient
{
    private static $instance;
    var $domain = 'http://upload.zamba.vn/';
    var $secretKey = 'fa2f6455a1329ed251153aad37a46f8da2a451b6';
    var $namespace = 'plaza/';
    var $errors = array();
    private function __construct()
    {

    }

    /**
     *
     * @return SoStorageClient
     */
    static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new StorageClient();
        }
        return self::$instance;
    }

    function browse($dirname = '')
    {
        $params = array('dirname' => $dirname);
        $content = $this->getContent('ls', $params);
        return $content;
    }

    function createDir($dirname)
    {
        $params = array('dirname' => $dirname);
        $content = $this->getContent('make_dir', $params);
        return $content;
    }

    function removeDir($dirname)
    {
        $params = array('dirname' => $dirname);
        $content = $this->getContent('remove_dir', $params);
        return $content;
    }

    function upload($filename, $filedata, $overwrite = false)
    {
        if (empty($filename) || empty($filedata)) {
            return false;
        }
        // prepare data
        $data = array(
            'filename' => $this->namespace.$filename,
            'secret_key' => $this->secretKey,
        );
        //return $data;
        if (strpos($filedata, 'http://') === 0
            || strpos($filedata, 'https://') === 0
        ) {
            $data['source'] = $filedata;
        } else {
            if (strpos($filedata, '@') !== 0 && class_exists('CurlFile', false) === false) {
                $filedata = '@'.$filedata;
            }elseif(strpos($filedata, '@') === 0 && class_exists('CurlFile', false) === true){
                $filedata = preg_replace('@','',$filedata,1);
            }
            //$data['filedata'] = $filedata;
        }

        if ($overwrite === true) {
            $data['overwrite'] = 1;
        }
        //return $data;
        $fullUrl = $this->domain . 'upload';

        // start upload
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $fullUrl);
        curl_setopt($curl, CURLOPT_VERBOSE, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        //curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        $data['filedata'] = class_exists('CurlFile', false) ? new CurlFile($filedata, 'image/png') : $filedata;
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
      // var_dump($data);die;
        $result = curl_exec($curl);
        curl_close($curl);
        //
        return $result;
        if ($result == 'OK') {
            return true;
        }
//        System::sendEBEmail(
//            'leader@solo.vn',
//            'Lỗi upload ảnh - ' . date('d-M-Y'),
//            '<br/>
//			 FILE: ' . __FILE__ . ' <br/>
//			 Time ' . date('d-M-Y H:i:s') . ' <br/>
//			 <b><pre>Kết quả up load = ' . $result . '</b><br/>' .
//                'File :' . print_r($_FILES, true) . '<br/>' .
//                'Session :' . print_r($_SESSION, true) . '<br/>' .
//                'Argument :' . print_r(func_get_args(), true) . '<br/>' .
//                print_r($_REQUEST, true) . '</pre><hr/><hr/><hr/>
//		 	<br/>--end'
//        );
        return json_decode($result);
    }

    /**
     * Xoa file
     * @param String $filename Duong dan file
     * @return Object
     */
    function remove($filename)
    {
        $params = array('filename' => $filename);
        $content = $this->getContent('delete', $params);
        return $content;
    }

    /**
     * Doi ten file
     * @param String $source File can doi ten
     * @param String $des Ten file moi (gom day du duong dan)
     * @return Object
     */
    function rename($source, $des)
    {
        $params = array('from' => $source, 'to' => $des);
        $content = $this->getContent('rename', $params);
        return $content;
    }

    function getFileInfo($filename)
    {
        $params = array('filename' => $filename);
        $content = $this->getContent('get_file_info', $params);
        return $content;
    }

    private function getContent($url, $params = array())
    {
        // Build url
        $fullUrl = $this->domain . $url;

        // Build query string
        $params = array_merge($params, array('secret_key' => $this->secretKey));
        $tmp = array();
        foreach ($params as $k => $v) {
            $tmp[] = $k . "=" . urlencode($v);
        }
        $fullUrl .= '?' . implode('&', $tmp);
        //
        $content = false;
        set_error_handler(
            create_function(
                '$severity, $message, $file, $line',
                'throw new ErrorException($message, $severity, $severity, $file, $line);'
            )
        );
        try {
            $content = file_get_contents($fullUrl);
        } catch (Exception $e) {
//			echo '<pre>';
            $this->errors[] = $e->getTraceAsString();
//			echo '</pre>';
            return false;
        }
        restore_error_handler();

        return json_decode($content);
    }

    function isExists($file)
    {
        $params = array('filename' => $file);
        $content = $this->getContent('get_file_info', $params);
//		echo '<pre>'; print_r($content); echo '</pre>';
        if ($content === false) {
            return false;
        }
        return true;
    }

    function printError()
    {
        if (!empty($this->errors)) {
            echo '<pre>';
            print_r($this->errors);
            echo '</pre>';
        }
    }
}
