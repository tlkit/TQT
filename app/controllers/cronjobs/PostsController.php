<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 12/04/15
 * Time: 3:16 PM
 */

class PostsController extends \BaseController {
    private $linkAuth = null;
    private $linkNonce = null;
    private $linkPosts = null;
    private $keyReplace = 'seo-link';
    private $domainStorageReplace = 'static10.zamba.vn';

    private $arrWebsite = array();
    private $arrCategory = array();
    private $arrProjects = array();
    private $logRunAPI = array();
    private $keywordLimit = 50;

    public function __construct() {
        $this->arrWebsite = Website::getAll();
        $this->arrCategory = SeoCategory::getCategoryAll();
        $this->arrProjects = SeoProject::getProjectAll();
    }

    private function buildLinkApi($domain) {
        $this->linkAuth = sprintf("http://%s/api/auth/generate_auth_cookie/?username=admin&password=seozamba@123vcc&seconds=6000", $domain);
        $this->linkNonce = sprintf("http://%s/api/get_nonce/?controller=posts&method=create_post", $domain);
        $this->linkPosts = sprintf("http://%s/api/create_post", $domain);
    }

    /**
     * @desc: callAPIGetNonce
     * @param $cookieName
     * @param $cookie
     * @return mixed
     */
    private function callAPIGetNonce($cookieName, $cookie) {
        $ch = curl_init($this->linkNonce);
        $options = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array('Content-type: application/json', 'Cookie: ' . $cookieName . '=' . $cookie)
        );
        curl_setopt_array( $ch, $options );
        $result = curl_exec($ch);
        $result = json_decode($result, 1);
        curl_close($ch);
        return $result;
    }

    /**
     * @desc: callAPIPosts
     * @param $cookieName
     * @param $cookie
     * @param $nonce
     * @param $str
     * @return mixed
     */
    private function callAPIPosts($cookieName, $cookie, $nonce, $str) {
        $ch = curl_init( $this->linkPosts );
        $options = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array('Cookie: ' . $cookieName . '=' . $cookie),
            CURLOPT_POSTFIELDS => "nonce={$nonce}&{$str}"
        );
        curl_setopt_array( $ch, $options );
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    /**
     * @desc: getCookieAuth
     * @return array|mixed
     */
    private function getCookieAuth() {
        $cookie = file_get_contents($this->linkAuth);
        if(!empty($cookie)) {
            return json_decode($cookie, 1);
        }
        return array();
    }

    /**
     * @desc: getNonce
     * @param $cookieName
     * @param $cookie
     * @return string
     */
    private function getNonce($cookieName, $cookie) {
        $result = $this->callAPIGetNonce($cookieName, $cookie);
        return isset($result['nonce']) ? $result['nonce'] : '';
    }

    /**
     * @desc: buildBackLink
     * @param $keyword
     * @param $backlink
     * @param $data
     * @return array
     */
    private function buildBackLink($keyword, $data) {
        $backLink = $results = array();
        foreach($data as $i=>$itm01) {
            if($i == count($data) - 1) {
                $backLink[] = $itm01['seo_keyword_description_before'] . ' ' . $keyword . ' ' . $itm01['seo_keyword_description_after'];
            } else {
                foreach($data as $j=>$itm02) {
                    if($j != count($data) - 1) {
                        $backLink[] = $itm01['seo_keyword_description_before'] . ' ' . $keyword . ' ' . $itm02['seo_keyword_description_after'];
                    }
                }
            }
        }
        return array_reverse($backLink);
    }

    private function buildLink($domain, $slug) {
        return (sprintf('http://%s/%s', $domain, $slug));
    }
    /**
     * @desc: index
     */
    public function index() {
        try{
            $project_id = (int)Request::get('project_id');
            if($project_id <= 0 || !isset($this->arrProjects[$project_id])) {
                echo "Ma project khong ton tai"; die;
            }
            $campaign = new SeoCampaign();
            $arrCampaign = $campaign->getSeoCampaignById($project_id, $this->keywordLimit);
            $idxPosts = 0;
            $start_jobs = time();
            if(!empty($arrCampaign)) {
                foreach($arrCampaign as $itmCampain) {
                    $itmCampain = get_object_vars ($itmCampain);
                    $runLink = (int)$itmCampain['seo_keyword_max_link_vt'];
                    if($runLink > 0) {
                        if($runLink > 1) {
                            //$numLink = ceil(sqrt($runLink - 1));
                            $numLink = ((int)$itmCampain['seo_keyword_daily_link_vt'] > 0) ? (int)$itmCampain['seo_keyword_daily_link_vt'] : $itmCampain['seo_keyword_max_link_vt'];
                            $listDescKey = SeoKeyWord::getDescKey($numLink, $itmCampain['seo_keyword_category'], $itmCampain['seo_keyword_id']);
                        }
                        $listDescKey[] = array('seo_keyword_description_before' => $itmCampain['seo_keyword_description_before'], 'seo_keyword_description_after' => $itmCampain['seo_keyword_description_after']);
                        $arrBackLink = $this->buildBackLink($itmCampain['seo_keyword_key'], $listDescKey);
                        $limit = ($itmCampain['seo_keyword_daily_link_vt'] > 0) ? (int)$itmCampain['seo_keyword_daily_link_vt'] : (int)$itmCampain['seo_keyword_max_link_vt'];
                        $listPosts = Posts::getPostByCategoryID($itmCampain['seo_keyword_category'], $limit);
						if(!$listPosts->isEmpty()) {
                            $idxBackLink = 0;
                            foreach($listPosts as $itmPosts) {
                                if(empty($this->arrWebsite)) {
                                    Website::setValueIsRun();
                                    $this->arrWebsite = Website::getAll();
                                }
                                $f_key = key($this->arrWebsite);
                                $domain = '';
                                $domain = $this->arrWebsite[$f_key]->website_domain;
                                //Check authen posts.
                                $this->buildLinkApi($domain);
                                $arrCookie = $this->getCookieAuth();
                                $cookieName = isset($arrCookie['cookie_name']) ? $arrCookie['cookie_name'] : '';
                                $cookie = isset($arrCookie['cookie']) ? $arrCookie['cookie'] : '';
                                $nonce = $this->getNonce($cookieName, $cookie);
                                $posts_content = $itmPosts['posts_content'];
                                preg_match_all("/". $this->keyReplace ."/i", $posts_content, $matches);
                                $arrBackLinkReplace = array();
                                if(count($matches[0]) > 0) {
                                    for($i=1; $i <= count($matches[0]); $i++) {
                                        if($i == 1) {
                                            $arrBackLinkReplace[] = '<a href="' . $itmCampain['seo_keyword_landing_url'] .'" rel="nofollow">' . $arrBackLink[$idxBackLink] . '</a>';
                                        } else {
                                            $arrBackLinkReplace[] = '<a href="' . $itmCampain['seo_keyword_landing_url'] .'">' . $arrBackLink[$idxBackLink] . '</a>';
                                        }
                                        $idxBackLink++;
                                    }
                                    $posts_content = str_replace_array($this->keyReplace, $arrBackLinkReplace, $posts_content);
                                }
                                $posts_content = str_replace($this->domainStorageReplace, 'img.' . $domain, $posts_content);
                                $arrPosts = array(
                                    'slug' => urlencode(FunctionLib::safe_title($itmPosts['posts_title'])),
                                    'status' => 'publish',
                                    'title' => urlencode($itmPosts['posts_title']),
                                    'content' => urlencode($posts_content),
                                    'excerpt' => urlencode($itmPosts['posts_desc']),
                                    'date' => urlencode(date('Y-m-d H:i:s', $itmPosts['posts_created_at'])),
                                    'modified' => urlencode(date('Y-m-d H:i:s', $itmPosts['posts_updated_at'])),
                                    'categories' => (isset($this->arrCategory[$itmPosts['category_id']])) ? urlencode($this->arrCategory[$itmPosts['category_id']]) : '',
                                    'tags' => urlencode($itmPosts['posts_tags'])
                                );
                                $str = '';
                                $keys = array_keys($arrPosts);
                                foreach($keys as $v)
                                {
                                    $str .= $v . '='.$arrPosts[$v].'&';
                                }
                                $str = rtrim($str, '&');
                                $this->callAPIPosts($cookieName, $cookie, $nonce, $str);
                                $idxBackLink += 3;
                                Website::updData($this->arrWebsite[$f_key]->website_id, array('website_is_run'=>1));
                                $arrDataPostsUpd = array(
                                        'posts_link_website'=>$this->buildLink($domain, FunctionLib::safe_title($itmPosts['posts_title'])),
                                        'posts_is_run' => 1,
                                        'posts_time_run' => time(),
                                        'website_id' => $this->arrWebsite[$f_key]->website_id,
                                        'projects_id' => $itmCampain['seo_campaign_project_id'],
                                        'seo_keyword_id' => $itmCampain['seo_keyword_id']
                                );
                                Posts::updData($itmPosts['posts_id'], $arrDataPostsUpd);
                                unset($this->arrWebsite[$f_key]);

                                $idxPosts++;
                                $this->logRunAPI[$itmCampain['seo_campaign_id']]['idPosts'][] = $itmPosts['posts_id'];
                            }
                            $dataUpdate = array();
                            $dataUpdate['seo_keyword_run_link_vt'] = $runLink;
                            $dataUpdate['seo_keyword_max_link_vt'] = $itmCampain['seo_keyword_max_link_vt'] - $itmCampain['seo_keyword_daily_link_vt'];
                            $dataUpdate['seo_keyword_run_last_time'] = time();
                            SeoKeyWord::updData($itmCampain['seo_keyword_id'], $dataUpdate);
                        } else {
                            $this->logRunAPI[$itmCampain['seo_campaign_id']]['msg'][] = 'CampID:'.$itmCampain['seo_campaign_id'].', SeoKeyID:' .$itmCampain['seo_keyword_id']. ', Desc:khong co bai viet.';
                        }
                    } else {
                        $this->logRunAPI[$itmCampain['seo_campaign_id']]['msg'][] = 'CampID:'.$itmCampain['seo_campaign_id'].', SeoKeyID:' .$itmCampain['seo_keyword_id']. ', Desc:khong co backlink.';
                    }
                }
            } else {
                $this->logRunAPI[] = "Khong co campaign nao duoc thuc hien.";
            }
            $this->logRunAPI[] = "Co {$idxPosts} bai duoc day qua api";
            if($idxPosts > 0) {
                $dataSaveLog = array();
                $dataSaveLog['log_content'] = json_encode($this->logRunAPI);
                $dataSaveLog['log_type'] = 1;
                $dataSaveLog['log_run_time'] = time() - $start_jobs;
                $dataSaveLog['log_created_at'] = time();
                LogAPI::addData($dataSaveLog);
            }
        } catch (Exception $e) {
            $this->logRunAPI[] = $e->getMessage();
            $dataSaveLog = array();
            $dataSaveLog['log_content'] = json_encode($this->logRunAPI);
            $dataSaveLog['log_type'] = 1;
            $dataSaveLog['log_run_time'] = time() - $start_jobs;
            $dataSaveLog['log_created_at'] = time();
            LogAPI::addData($dataSaveLog);
        }
        echo '['.$idxPosts.'] - OK..Done'; exit();
    }
}
