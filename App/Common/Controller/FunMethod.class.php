<?php

namespace Common\Controller;

use FFMpeg\Coordinate\Dimension;
use FFMpeg\Coordinate\TimeCode;
use FFMpeg\FFMpeg;
use Think\Image;

class FunMethod
{
    //按固定比例裁剪图片
    public static function resizeImgFixed($filePath,$width=80,$height=80){
        $newFilePath = '';
        $image = new \Think\Image();
        if(is_file($filePath)){
            $arr_path = explode('.', $filePath);
            $las = array_pop($arr_path);
            $new_path = implode($arr_path, '.');
            $newFilePath = $new_path . '_'.$width.'_'.$height.'.png';
            if(!is_file($newFilePath)){
                $image->open($filePath);
                $image->thumb($width,$height,6)->save($newFilePath);
            }
        }

        if($newFilePath){
            $newFilePath = str_replace($_SERVER['DOCUMENT_ROOT'],'',$newFilePath);
        }
        return $newFilePath;
    }

    public static function videoInfo($video_path){
//        $ffMpeg_config = "[
//            'ffmpeg.binaries'  => 'D:/ffmpeg-3.3.3-win64-static/bin/ffmpeg.exe',
//            'ffprobe.binaries' => 'D:/ffmpeg-3.3.3-win64-static/bin/ffprobe.exe',
//            'timeout'          => 3600,
//            'ffmpeg.threads'   => 12,
//        ]";
        $ffMpeg_config = "[
            'ffmpeg.binaries'  => '/usr/bin/ffmpeg',
            'ffprobe.binaries' => '/usr/bin/ffprobe',
            'timeout'          => 3600,
            'ffmpeg.threads'   => 12,
        ]";
        $dirs = explode('.',$video_path);
        $dirs[count($dirs)-1] = 'png';
        $img_file = implode('.',$dirs);
        $ffMpeg =FFMpeg::create([
            'ffmpeg.binaries'  => '/usr/bin/ffmpeg',
            'ffprobe.binaries' => '/usr/bin/ffprobe',
            'timeout'          => 3600,
            'ffmpeg.threads'   => 12,
        ]);
        $video = $ffMpeg->open($video_path);
        $video->filters()->resize(new Dimension(320,240))->synchronize();
        $video->frame(TimeCode::fromSeconds(0))->save($img_file);
        $yy = $video->getFormat()->get('duration');
        $h = floor($yy/3600);

        if($h>0){
            $yy = $yy-$h*3600;
            if($h<10){
                $h = '0'.$h;
            }
        }else{
            $h = '00';
        }
        $i = floor($yy/60);
        if($i>0){
            $yy = $yy-$i*60;
            if($i<10){
                $i = '0'.$i;
            }
        }else{
            $i = '00';
        }
        $s=intval($yy);
        $m = floor(($yy-$s)*100);

        $result = array();
        $result['thumb'] = str_replace($_SERVER['DOCUMENT_ROOT'],'http://'.$_SERVER['HTTP_HOST'],$img_file);
        if($h == '00'){
             $result['duration'] = $i.':'.$s;//.':'.$m;
        }else{
             $result['duration'] = $h.':'.$i.':'.$s;//.':'.$m;
        }
       
        return $result;
    }
    public static function getIP()
    {
        if (isset($_SERVER)){
            if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
                $realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
            } else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
                $realip = $_SERVER["HTTP_CLIENT_IP"];
            } else {
                $realip = $_SERVER["REMOTE_ADDR"];
            }
        } else {
            if (getenv("HTTP_X_FORWARDED_FOR")){
                $realip = getenv("HTTP_X_FORWARDED_FOR");
            } else if (getenv("HTTP_CLIENT_IP")) {
                $realip = getenv("HTTP_CLIENT_IP");
            } else {
                $realip = getenv("REMOTE_ADDR");
            }
        }
        return $realip;
    }
    /**
     * 递归创建文件夹
     * @param $dir
     * @return bool
     * Date: 2017-03-25
     */
    public static function mkDirs($dir)
    {
        if (!is_dir($dir)) {
            if (!self::mkDirs(dirname($dir))) {
                return false;
            }
            if (!mkdir($dir, 0777)) {
                return false;
            }
        }
        return true;
    }

    /**
     * 对多位数组进行排序
     * @param $multi_array (数组)
     * @param $sort_key (需要传入的键名)
     * @param int $sort (排序类型)
     * @return array|bool
     * Date: 2017-02-27
     */
    public static function multiArraySort($multi_array, $sort_key, $sort = SORT_DESC)
    {
        if (is_array($multi_array)) {
            foreach ($multi_array as $row_array) {
                if (is_array($row_array)) {
                    $key_array[] = $row_array[$sort_key];
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
        array_multisort($key_array, $sort, $multi_array);
        return $multi_array;
    }


    /**
     * 根据日期，获取对应的周次
     * @param $time (2017-02-11)
     * @return bool|string
     * Date: 2017-02-23
     */
    public static function GetWeekByDate($date)
    {
        $time = strtotime($date);
        $weekarray = array("日", "一", "二", "三", "四", "五", "六");
        $w_n = date("w", $time);
        return '周' . $weekarray[$w_n];
    }

    /**
     * 返回上周日
     * @param $date
     * Date: 2017-02-14
     */
    public static function getLastWeekEnd1($date)
    {
        $zj = date('w', strtotime($date));
        $zj = $zj == 0 ? 0 : $zj;
        return date('Y-m-d', strtotime("$date -$zj days"));
    }

    /**
     * 返回本周六
     * @param $date
     * Date: 2017-02-14
     */
    public static function getCurWeekSaturday1($date)
    {
        $zj = date('w', strtotime($date));
        $zj = $zj == 0 ? 6 : 6 - $zj;
        return date('Y-m-d', strtotime("$date +$zj days"));
    }

    /**
     * 返回上周日
     * @param $date
     * Date: 2017-02-14
     */
    public static function getLastWeekEnd($date)
    {
        $zj = date('w', strtotime($date));
        $zj = $zj == 0 ? 7 : $zj;
        return date('Y-m-d', strtotime("$date -$zj days"));
    }

    /**
     * 返回本周六
     * @param $date
     * Date: 2017-02-14
     */
    public static function getCurWeekSaturday($date)
    {
        $zj = date('w', strtotime($date));
        $zj = $zj == 0 ? -1 : 6 - $zj;
        return date('Y-m-d', strtotime("$date +$zj days"));
    }

    /**
     * 返回本周一
     * @param $date
     * Date: 2017-02-14
     */
    public static function getCurWeekFirstDay($date)
    {
        $date = strtotime($date);
        return date('Y-m-d', ($date - ((date('w', $date) == 0 ? 7 : date('w', $date)) - 1) * 24 * 3600));
    }

    /**
     * 返回本周五
     * @param $date
     * Date: 2017-02-14
     */
    public static function getCurWeekFriDay($date)
    {
        $zj = date('w', strtotime($date));
        $zj = $zj == 0 ? -2 : 5 - $zj;
        return date('Y-m-d', strtotime("$date +$zj days"));
    }

    /**
     * 返回本周末
     * @param $date
     * Date: 2017-02-14
     */
    public static function getCurWeekLastDay($date)
    {
        $date = strtotime($date);
        return date('Y-m-d', ($date + (7 - (date('w', $date) == 0 ? 7 : date('w', $date))) * 24 * 3600));
    }

    /**
     * 返回当月日期数组
     * @param $date
     * @return array
     * Date: 2017-03-25
     */
    public static function GetMonthDateByDate($date)
    {
        $monthStart = self::getCurMonthFirstDay($date);
        $monthEnd = self::getCurMonthLastDay($date);
        $result = array();
        for ($i = 0; $i <= 30; $i++) {
            $nowDate = date('Y-m-d', strtotime("$monthStart +$i days"));
            if ($nowDate > $monthEnd) {
                break;
            }
            $result[] = $nowDate;
        }
        return $result;
    }

    /**
     * 返回当前时间月初
     * @param $date
     * @return bool|string
     */
    public static function getCurMonthFirstDay($date)
    {
        return date('Y-m-01', strtotime($date));
    }

    /**
     * 返回当前时间月末
     * @param $date
     * @return bool|string
     */
    public static function getCurMonthLastDay($date)
    {
        return date('Y-m-d', strtotime(date('Y-m-01', strtotime($date)) . ' +1 month -1 day'));
    }

    /**
     * 根据当前时间，获取在本年度的第几周
     * @param $date
     * Date: 2017-03-16
     */
    public static function getSchoolWeek()
    {
        $school_week = self::numToCapital(date("W"));
        return '第' . $school_week . '周';
    }

    /**
     * 数字转大写
     * @param $num
     * Date: 2017-03-16
     */
    public static function numToCapital($num)
    {
        $num = intval($num);
        $str = '';
        $numArr = array('一', '二', '三', '四', '五', '六', '七', '八', '九', '十');
        if ($num < 10) {
            $str = $numArr[$num - 1];
        } else if ($num >= 10 && $num < 20) {
            $y = $num % 10;
            $str = '十' . $numArr[$y - 1];
        } else if ($num >= 10 && $num < 100) {
            $s = floor($num / 10);
            $y = $num % 10;
            $s = intval($s);
            $str = $numArr[$s - 1] . '十' . $numArr[$y - 1];
        }
        return $str;
    }

    /**
     * 字符串截取
     * Date: 2017-03-16
     */
    public static function charIntercept($data, $length = 100)
    {
        $str = '';
        $ln = mb_strlen($data, "UTF-8");
        if ($ln > $length) {
            $str = mb_substr($data, 0, $length, "UTF-8") . '...';
        } else {
            $str = $data;
        }
        return $str;
    }

    /**
     * 根据时间区间，获取对应数组
     * Date: 2017-03-18
     */
    public static function getDateToArr($startDate, $endDate)
    {
        $result = array();
        $ln = (strtotime($endDate) - strtotime($startDate)) / 86400;
        $ln = floor($ln);
        for ($i = 0; $i <= $ln; $i++) {
            $result[] = date('Y-m-d', strtotime("$startDate +$i days"));
        }
        return $result;
    }

    public static function subStrToLen($str,$length)
    {
        $str_len = mb_strlen(trim($str), 'utf-8');
        if ($str_len > $length) {
            $act_length = $length-3;
            $str = mb_substr(trim($str), 0, $act_length, 'utf-8') . '...';
        } else {
            $str = trim($str);
        }
        return $str;
    }

    /**
     * app 视频上传
     * @return string 上传后的视频名
     */
    public static function app_upload_video($path, $maxSize = 52428800)
    {
        ini_set('max_execution_time', '0');
        // 去除两边的/
        $path = trim($path, '.');
        $path = trim($path, '/');
        $config = array(
            'rootPath' => './',         //文件上传保存的根路径
            'savePath' => './' . $path . '/',
            'exts' => array('mp4', 'avi', '3gp', 'rmvb', 'gif', 'wmv', 'mkv', 'mpg', 'vob', 'mov', 'flv', 'swf', 'mp3', 'ape', 'wma', 'aac', 'mmf', 'amr', 'm4a', 'm4r', 'ogg', 'wav', 'wavpack'),
            'maxSize' => $maxSize,
            'autoSub' => true,
        );
        $upload = new \Think\Upload($config);// 实例化上传类
        $info = $upload->upload();
        if ($info) {
            foreach ($info as $k => $v) {
                $data[] = trim($v['savepath'], '.') . $v['savename'];
            }
            return $data;
        }
    }


    /**
     * 返回文件格式
     * @param  string $str 文件名
     * @return string      文件格式
     */
    public static function file_format($str)
    {
        // 取文件后缀名
        $str = strtolower(pathinfo($str, PATHINFO_EXTENSION));
        // 图片格式
        $image = array('webp', 'jpg', 'png', 'ico', 'bmp', 'gif', 'tif', 'pcx', 'tga', 'bmp', 'pxc', 'tiff', 'jpeg', 'exif', 'fpx', 'svg', 'psd', 'cdr', 'pcd', 'dxf', 'ufo', 'eps', 'ai', 'hdri');
        // 视频格式
        $video = array('mp4', 'avi', '3gp', 'rmvb', 'gif', 'wmv', 'mkv', 'mpg', 'vob', 'mov', 'flv', 'swf', 'mp3', 'ape', 'wma', 'aac', 'mmf', 'amr', 'm4a', 'm4r', 'ogg', 'wav', 'wavpack');
        // 压缩格式
        $zip = array('rar', 'zip', 'tar', 'cab', 'uue', 'jar', 'iso', 'z', '7-zip', 'ace', 'lzh', 'arj', 'gzip', 'bz2', 'tz');
        // 文档格式
        $text = array('exe', 'doc', 'ppt', 'xls', 'wps', 'txt', 'lrc', 'wfs', 'torrent', 'html', 'htm', 'java', 'js', 'css', 'less', 'php', 'pdf', 'pps', 'host', 'box', 'docx', 'word', 'perfect', 'dot', 'dsf', 'efe', 'ini', 'json', 'lnk', 'log', 'msi', 'ost', 'pcs', 'tmp', 'xlsb');
        // 匹配不同的结果
        switch ($str) {
            case in_array($str, $image):
                return 'image';
                break;
            case in_array($str, $video):
                return 'video';
                break;
            case in_array($str, $zip):
                return 'zip';
                break;
            case in_array($str, $text):
                return 'text';
                break;
            default:
                return 'image';
                break;
        }
    }

    /**
     * 检测是否登录
     * @return boolean 是否登录
     */
    public static function check_login()
    {
        if (!empty($_SESSION['user']['uid'])) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 删除指定的标签和内容
     * @param array $tags 需要删除的标签数组
     * @param string $str 数据源
     * @param string $content 是否删除标签内的内容 0保留内容 1不保留内容
     * @return string
     */
    public static function strip_html_tags($tags, $str, $content = 0)
    {
        if ($content) {
            $html = array();
            foreach ($tags as $tag) {
                $html[] = '/(<' . $tag . '.*?>[\s|\S]*?<\/' . $tag . '>)/';
            }
            $data = preg_replace($html, '', $str);
        } else {
            $html = array();
            foreach ($tags as $tag) {
                $html[] = "/(<(?:\/" . $tag . "|" . $tag . ")[^>]*>)/i";
            }
            $data = preg_replace($html, '', $str);
        }
        return $data;
    }

    /**
     * 字符串截取，支持中文和其他编码
     * @param string $str 需要转换的字符串
     * @param string $start 开始位置
     * @param string $length 截取长度
     * @param string $suffix 截断显示字符
     * @param string $charset 编码格式
     * @return string
     */
    public static function re_substr($str, $start = 0, $length, $suffix = true, $charset = "utf-8")
    {
        if (function_exists("mb_substr"))
            $slice = mb_substr($str, $start, $length, $charset);
        elseif (function_exists('iconv_substr')) {
            $slice = iconv_substr($str, $start, $length, $charset);
        } else {
            $re['utf-8'] = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
            $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
            $re['gbk'] = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
            $re['big5'] = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
            preg_match_all($re[$charset], $str, $match);
            $slice = join("", array_slice($match[0], $start, $length));
        }
        $omit = mb_strlen($str) >= $length ? '...' : '';
        return $suffix ? $slice . $omit : $slice;
    }

    /**
     * 取得根域名
     * @param type $domain 域名
     * @return string 返回根域名
     */
    public static function getUrlToDomain($domain)
    {
        $re_domain = '';
        $domain_postfix_cn_array = array("com", "net", "org", "gov", "edu", "com.cn", "cn");
        $array_domain = explode(".", $domain);
        $array_num = count($array_domain) - 1;
        if ($array_domain[$array_num] == 'cn') {
            if (in_array($array_domain[$array_num - 1], $domain_postfix_cn_array)) {
                $re_domain = $array_domain[$array_num - 2] . "." . $array_domain[$array_num - 1] . "." . $array_domain[$array_num];
            } else {
                $re_domain = $array_domain[$array_num - 1] . "." . $array_domain[$array_num];
            }
        } else {
            $re_domain = $array_domain[$array_num - 1] . "." . $array_domain[$array_num];
        }
        return $re_domain;
    }

    /**
     * 按符号截取字符串的指定部分
     * @param string $str 需要截取的字符串
     * @param string $sign 需要截取的符号
     * @param int $number 如是正数以0为起点从左向右截  负数则从右向左截
     * @return string 返回截取的内容
     */
    /*  示例
        $str='123/456/789';
        cut_str($str,'/',0);  返回 123
        cut_str($str,'/',-1);  返回 789
        cut_str($str,'/',-2);  返回 456
        具体参考 http://www.baijunyao.com/index.php/Home/Index/article/aid/18
    */
    public static function cut_str($str, $sign, $number)
    {
        $array = explode($sign, $str);
        $length = count($array);
        if ($number < 0) {
            $new_array = array_reverse($array);
            $abs_number = abs($number);
            if ($abs_number > $length) {
                return 'error';
            } else {
                return $new_array[$abs_number - 1];
            }
        } else {
            if ($number >= $length) {
                return 'error';
            } else {
                return $array[$number];
            }
        }
    }

    /**
     * 发送邮件
     * @param  string $address 需要发送的邮箱地址 发送给多个地址需要写成数组形式
     * @param  string $subject 标题
     * @param  string $content 内容
     * @return boolean       是否成功
     */
    public static function send_email($address, $subject, $content)
    {
        $email_smtp = C('EMAIL_SMTP');
        $email_username = C('EMAIL_USERNAME');
        $email_password = C('EMAIL_PASSWORD');
        $email_from_name = C('EMAIL_FROM_NAME');
        $email_smtp_secure = C('EMAIL_SMTP_SECURE');
        $email_port = C('EMAIL_PORT');
        if (empty($email_smtp) || empty($email_username) || empty($email_password) || empty($email_from_name)) {
            return array("error" => 1, "message" => '邮箱配置不完整');
        }
        require_once './ThinkPHP/Library/Org/Nx/class.phpmailer.php';
        require_once './ThinkPHP/Library/Org/Nx/class.smtp.php';
        $phpmailer = new \Phpmailer();
        // 设置PHPMailer使用SMTP服务器发送Email
        $phpmailer->IsSMTP();
        // 设置设置smtp_secure
        $phpmailer->SMTPSecure = $email_smtp_secure;
        // 设置port
        $phpmailer->Port = $email_port;
        // 设置为html格式
        $phpmailer->IsHTML(true);
        // 设置邮件的字符编码'
        $phpmailer->CharSet = 'UTF-8';
        // 设置SMTP服务器。
        $phpmailer->Host = $email_smtp;
        // 设置为"需要验证"
        $phpmailer->SMTPAuth = true;
        // 设置用户名
        $phpmailer->Username = $email_username;
        // 设置密码
        $phpmailer->Password = $email_password;
        // 设置邮件头的From字段。
        $phpmailer->From = $email_username;
        // 设置发件人名字
        $phpmailer->FromName = $email_from_name;
        // 添加收件人地址，可以多次使用来添加多个收件人
        if (is_array($address)) {
            foreach ($address as $addressv) {
                $phpmailer->AddAddress($addressv);
            }
        } else {
            $phpmailer->AddAddress($address);
        }
        // 设置邮件标题
        $phpmailer->Subject = $subject;
        // 设置邮件正文
        $phpmailer->Body = $content;
        // 发送邮件。
        if (!$phpmailer->Send()) {
            $phpmailererror = $phpmailer->ErrorInfo;
            return array("error" => 1, "message" => $phpmailererror);
        } else {
            return array("error" => 0);
        }
    }

    /**
     * 获取一定范围内的随机数字
     * 跟rand()函数的区别是 位数不足补零 例如
     * rand(1,9999)可能会得到 465
     * rand_number(1,9999)可能会得到 0465  保证是4位的
     * @param integer $min 最小值
     * @param integer $max 最大值
     * @return string
     */
    public static function rand_number($min = 1, $max = 999999)
    {
        return sprintf("%0" . strlen($max) . "d", mt_rand($min, $max));
    }

    /**
     * 获取星期方法
     * @param $date
     * @param bool $flag
     * @return bool|string
     * Date: 2017-03-25
     */
    public static function getWeek($date, $flag = false)
    {
        //强制转换日期格式
        $date_str = date('Y-m-d', strtotime($date));
        //封装成数组
        $arr = explode("-", $date_str);
        //参数赋值
        //年
        $year = $arr[0];
        //月，输出2位整型，不够2位右对齐
        $month = sprintf('%02d', $arr[1]);
        //日，输出2位整型，不够2位右对齐
        $day = sprintf('%02d', $arr[2]);
        //时分秒默认赋值为0；
        $hour = $minute = $second = 0;
        //转换成时间戳
        $strap = mktime($hour, $minute, $second, $month, $day, $year);
        //获取数字型星期几
        $number_wk = date("w", $strap);
        //自定义星期数组
        $weekArr = array("星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六");
        //获取数字对应的星期
        return $flag ? $weekArr[$number_wk] : $number_wk;
    }

    /**
     * 生成一定数量的随机数，并且不重复
     * @param integer $number 数量
     * @param string $len 长度
     * @param string $type 字串类型
     * 0 字母 1 数字 其它 混合
     * @return string
     */
    public static function build_count_rand($number, $length = 4, $mode = 1)
    {
        if ($mode == 1 && $length < strlen($number)) {
            //不足以生成一定数量的不重复数字
            return false;
        }
        $rand = array();
        for ($i = 0; $i < $number; $i++) {
            $rand[] = rand_string($length, $mode);
        }
        $unqiue = array_unique($rand);
        if (count($unqiue) == count($rand)) {
            return $rand;
        }
        $count = count($rand) - count($unqiue);
        for ($i = 0; $i < $count * 3; $i++) {
            $rand[] = rand_string($length, $mode);
        }
        $rand = array_slice(array_unique($rand), 0, $number);
        return $rand;
    }

    /**
     * 生成不重复的随机数
     * @param  int $start 需要生成的数字开始范围
     * @param  int $end 结束范围
     * @param  int $length 需要生成的随机数个数
     * @return array       生成的随机数
     */
    public static function get_rand_number($start = 1, $end = 10, $length = 4)
    {
        $connt = 0;
        $temp = array();
        while ($connt < $length) {
            $temp[] = rand($start, $end);
            $data = array_unique($temp);
            $connt = count($data);
        }
        sort($data);
        return $data;
    }

    /**
     * 实例化page类
     * @param  integer $count 总数
     * @param  integer $limit 每页数量
     * @return subject       page类
     */
    public static function new_page($count, $limit = 10)
    {
        return new \Org\Nx\Page($count, $limit);
    }

    /**
     * 获取分页数据
     * @param  subject $model model对象
     * @param  array $map where条件
     * @param  string $order 排序规则
     * @param  integer $limit 每页数量
     * @return array            分页数据
     */
    public static function get_page_data($model, $map, $order = '', $limit = 10)
    {
        $map['is_deleted'] = 0;
        $count = $model->where($map)->count();
        $page = self::new_page($count, $limit);
        // 获取分页数据
        $list = $model->where($map)->order($order)->limit($page->firstRow . ',' . $page->listRows)->select();
        $data = array('data' => $list, 'page' => $page->show());
        return $data;
    }

    /**
     * 使用curl获取远程数据
     * @param  string $url url连接
     * @return string      获取到的数据
     */
    public static function curl_get_contents($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);                //设置访问的url地址
        // curl_setopt($ch,CURLOPT_HEADER,1);               //是否显示头部信息
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);               //设置超时
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);   //用户访问代理 User-Agent
        curl_setopt($ch, CURLOPT_REFERER, $_SERVER['HTTP_HOST']);        //设置 referer
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);          //跟踪301
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);        //返回结果
        $r = curl_exec($ch);
        curl_close($ch);
        return $r;
    }

    /**
     * 将路径转换加密
     * @param  string $file_path 路径
     * @return string            转换后的路径
     */
    public static function path_encode($file_path)
    {
        return rawurlencode(base64_encode($file_path));
    }

    /**
     * 将路径解密
     * @param  string $file_path 加密后的字符串
     * @return string            解密后的路径
     */
    public static function path_decode($file_path)
    {
        return base64_decode(rawurldecode($file_path));
    }

    /**
     * 不区分大小写的in_array()
     * @param  string $str 检测的字符
     * @param  array $array 数组
     * @return boolear       是否in_array
     */
    public static function in_iarray($str, $array)
    {
        $str = strtolower($str);
        $array = array_map('strtolower', $array);
        if (in_array($str, $array)) {
            return true;
        }
        return false;
    }

    /**
     * 传入时间戳,计算距离现在的时间
     * @param  number $time 时间戳
     * @return string     返回多少以前
     */
    public static function wordTime($time,$flag=false)
    {
        $time = (int)substr($time, 0, 10);
        $int = time() - $time;
        $str = '';
        if ($int <= 2) {
            $str = sprintf('刚刚更新', $int);
        } elseif ($int < 60) {
            $str = sprintf('%d秒前更新', $int);
        } elseif ($int < 3600) {
            $str = sprintf('%d分钟前更新', floor($int / 60));
        } elseif ($int < 86400) {
            $str = sprintf('%d小时前更新', floor($int / 3600));
        } elseif ($int < 1728000) {
            $str = sprintf('%d天前更新', floor($int / 86400));
        } else {
            if($flag){
                $str = date('Y-m-d', $time);
            }else{
                $str = date('Y-m-d H:i:s', $time);
            }            
        }
        return $str;
    }

    /**
     * 生成缩略图
     * @param  string $image_path 原图path
     * @param  integer $width 缩略图的宽
     * @param  integer $height 缩略图的高
     * @return string             缩略图path
     */
    public static function crop_image($image_path, $width = 170, $height = 170)
    {
        $image_path = str_replace($_SERVER['DOCUMENT_ROOT'], '', $image_path);
        $image_path = trim($image_path, '.');
        $min_path = str_replace('.', '_' . $width . '_' . $height . '.', $image_path);
        $image = new \Think\Image();
        $image_path = $_SERVER['DOCUMENT_ROOT'] . $image_path;
        $min_path = $_SERVER['DOCUMENT_ROOT'] . $min_path;
        $image->open($image_path);
        // 生成一个居中裁剪为$width*$height的缩略图并保存
        $image->thumb($width, $height, \Think\Image::IMAGE_THUMB_CENTER)->save($min_path);

        return $min_path;
    }

    /**
     * 功能：Base64转图片
     * @param $imgData (base64数据包)
     */
    public static function base64ToImage($imgData, $flag = false)
    {
        $time = date('Y-m-d');
        $filepathDir = $_SERVER['DOCUMENT_ROOT'] . '/Upload/mobile/' . $time;
        if (!is_dir($filepathDir)) {
            /*新建文件夹*/
            mkdir($filepathDir, 0777);
        }

        //匹配出图片的格式
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $imgData, $result)) {
            $type = $result[2];

            $file_name = $time . time() . '.' . $type;
            $filepath = $filepathDir . '/' . $file_name;
            if (!file_put_contents($filepath, base64_decode(str_replace($result[1], '', $imgData)))) {
                /*文件保存失败*/
                return '';
            } else {
                if (!$flag) {
                    $filepath = self::crop_image($filepath, 80, 80);
                }
                $filepath = str_replace($_SERVER['DOCUMENT_ROOT'], '', $filepath);
                return $filepath;
            }
        } else if ($imgData) {
            $filepath = $filepathDir . '/' . time() . '.jpg';
            if (!file_put_contents($filepath, base64_decode($imgData))) {
                /*文件保存失败*/
                return '';
            } else {
                if (!$flag) {
                    $filepath = self::crop_image($filepath, 80, 80);
                }
                $filepath = str_replace($_SERVER['DOCUMENT_ROOT'], '', $filepath);
                return $filepath;
            }
        }
    }

    /**
     * 功能：图片转Base64
     * @param $file  文件地址
     * @return string
     */
    public static function imageToBase64($file)
    {
        header('Content-type:text/html;charset=utf-8');
        $img = '';
        $info = getimagesize($file);
        $file_content = chunk_split(base64_encode(file_get_contents($file)));
        if ($file_content) {
            $img = 'data:' . $info['mime'] . ';base64,' . $file_content;
        }
        return $img;
    }

    /**
     * 过滤用户头像，没有时返回默认值
     * Date: 2017-03-09
     */
    public static function filterHeaderUrl($header_url)
    {
        $defaultHeaderUrl = '/Public/images/default_header_80_80.png';
        $header_url = empty($header_url) ? $defaultHeaderUrl : $header_url;
        return 'http://' . $_SERVER['HTTP_HOST'] . $header_url;
    }

    public static function GetNowTimestamp()
    {
        return time();
    }

    public static function getNowTime()
    {
        return date("Y-m-d H:i:s");
    }

    public static function formatTimestampToDate($timestamp)
    {
        return date("Y-m-d H:i:s", $timestamp);
    }

    /**
     * 中文数组排序
     * @param $data
     * @param int $type (1、一维数组 2、二维数组)
     * @param $key (键值)
     * @return array
     * Date: 2017-03-12
     */
    public static function chineseSort($data, $type = 1, $key)
    {
//    $shopData = array(
//        array('id'=>1,'name'=>'张三','sex'=>2),
//        array('id'=>2,'name'=>'李四','sex'=>2),
//        array('id'=>3,'name'=>'晨晨1','sex'=>2),
//        array('id'=>4,'name'=>'波仔1','sex'=>2),
//        array('id'=>5,'name'=>'晨晨2','sex'=>2),
//        array('id'=>6,'name'=>'波仔2','sex'=>2),
//        array('id'=>7,'name'=>'晨晨3','sex'=>2),
//        array('id'=>8,'name'=>'波仔3','sex'=>2),
//        array('id'=>9,'name'=>'王武','sex'=>2),
//    );

        $result = array();
        foreach ($data as $_key => $value) {
            if ($type == 1) {
                $name = $value;
            } else {
                $name = $value[$key];
            }
            $snameFirstChar = self::_getFirstCharter($name); //取出门店的第一个汉字的首字母
            $snameFirstChar = $snameFirstChar ? $snameFirstChar : 'TT';
            $result[$snameFirstChar][] = $value;//以这个首字母作为key
        }
        ksort($result); //对数据进行ksort排序，以key的值升序排序
        return $result;
    }

    /**
     * 去除数组空项
     * @param $data
     * Date: 2017-03-18
     */
    public static function trimArr($data,$flag=false)
    {
        foreach ($data as $key => $value) {
            if (empty($value)) {
                unset($data[$key]);
            }
        }
        if(!$flag) {
            $data = array_values($data);
        }
        return $data;
    }

    /**
     * 取汉字的第一个字的首字母
     * @param $str
     * @return string|null
     */
    public static function _getFirstCharter($str)
    {
        if (empty($str)) {
            return '';
        }
        $fchar = ord($str{0});
        if ($fchar >= ord('A') && $fchar <= ord('z')) return strtoupper($str{0});
        $s1 = iconv('UTF-8', 'gb2312', $str);
        $s2 = iconv('gb2312', 'UTF-8', $s1);
        $s = $s2 == $str ? $s1 : $str;
        $asc = ord($s{0}) * 256 + ord($s{1}) - 65536;
        if ($asc >= -20319 && $asc <= -20284) return 'A';
        if ($asc >= -20283 && $asc <= -19776) return 'B';
        if ($asc >= -19775 && $asc <= -19219) return 'C';
        if ($asc >= -19218 && $asc <= -18711) return 'D';
        if ($asc >= -18710 && $asc <= -18527) return 'E';
        if ($asc >= -18526 && $asc <= -18240) return 'F';
        if ($asc >= -18239 && $asc <= -17923) return 'G';
        if ($asc >= -17922 && $asc <= -17418) return 'H';
        if ($asc >= -17417 && $asc <= -16475) return 'J';
        if ($asc >= -16474 && $asc <= -16213) return 'K';
        if ($asc >= -16212 && $asc <= -15641) return 'L';
        if ($asc >= -15640 && $asc <= -15166) return 'M';
        if ($asc >= -15165 && $asc <= -14923) return 'N';
        if ($asc >= -14922 && $asc <= -14915) return 'O';
        if ($asc >= -14914 && $asc <= -14631) return 'P';
        if ($asc >= -14630 && $asc <= -14150) return 'Q';
        if ($asc >= -14149 && $asc <= -14091) return 'R';
        if ($asc >= -14090 && $asc <= -13319) return 'S';
        if ($asc >= -13318 && $asc <= -12839) return 'T';
        if ($asc >= -12838 && $asc <= -12557) return 'W';
        if ($asc >= -12556 && $asc <= -11848) return 'X';
        if ($asc >= -11847 && $asc <= -11056) return 'Y';
        if ($asc >= -11055 && $asc <= -10247) return 'Z';
        return null;
    }

    /**
     * 获取随机字符串
     * @param int $length
     * @return string
     */
    public static function getNoncestr($length = 16)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    /**
     * 检测是否是手机访问
     */
    public static function isMobile()
    {
        $useragent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
        $useragent_commentsblock = preg_match('|\(.*?\)|', $useragent, $matches) > 0 ? $matches[0] : '';
        function _is_mobile($substrs, $text)
        {
            foreach ($substrs as $substr)
                if (false !== strpos($text, $substr)) {
                    return true;
                }
            return false;
        }

        $mobile_os_list = array('Google Wireless Transcoder', 'Windows CE', 'WindowsCE', 'Symbian', 'Android', 'armv6l', 'armv5', 'Mobile', 'CentOS', 'mowser', 'AvantGo', 'Opera Mobi', 'J2ME/MIDP', 'Smartphone', 'Go.Web', 'Palm', 'iPAQ');
        $mobile_token_list = array('Profile/MIDP', 'Configuration/CLDC-', '160×160', '176×220', '240×240', '240×320', '320×240', 'UP.Browser', 'UP.Link', 'SymbianOS', 'PalmOS', 'PocketPC', 'SonyEricsson', 'Nokia', 'BlackBerry', 'Vodafone', 'BenQ', 'Novarra-Vision', 'Iris', 'NetFront', 'HTC_', 'Xda_', 'SAMSUNG-SGH', 'Wapaka', 'DoCoMo', 'iPhone', 'iPod');

        $found_mobile = _is_mobile($mobile_os_list, $useragent_commentsblock) ||
            _is_mobile($mobile_token_list, $useragent);
        if ($found_mobile) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 获取当前访问的设备类型
     * @return integer 1：其他  2：iOS  3：Android
     */
    public static function getDeviceType()
    {
        //全部变成小写字母
        $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
        $type = 1;
        //分别进行判断
        if (strpos($agent, 'iphone') !== false || strpos($agent, 'ipad') !== false) {
            $type = 2;
        }
        if (strpos($agent, 'android') !== false) {
            $type = 3;
        }
        return $type;
    }

    /**
     * 生成二维码
     * @param  string $url url连接
     * @param  integer $size 尺寸 纯数字
     */
    public static function qrcode($url, $size = 4)
    {
        Vendor('Phpqrcode.phpqrcode');
        \QRcode::png($url, false, QR_ECLEVEL_L, $size, 2, false, 0xFFFFFF, 0x000000);
    }
}