<?php
/** Portable two-level navigation configuration and escaped rendering. */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
function hhParseNavigation($raw) {
    $raw=trim((string)$raw); if($raw==='')return [];
    $items=json_decode($raw,true);
    if(json_last_error()!==JSON_ERROR_NONE)$items=json_decode('['.$raw.']',true);
    if(json_last_error()!==JSON_ERROR_NONE||!is_array($items))throw new InvalidArgumentException('菜单配置不是有效JSON');
    if(isset($items['name']))$items=[$items];
    if(count($items)>60)throw new InvalidArgumentException('一级菜单最多60项');
    $normalize=function($item,$child=false) use (&$normalize){
        if(!is_array($item))throw new InvalidArgumentException('菜单项格式错误');
        $name=trim((string)($item['name']??''));$link=trim((string)($item['link']??''));
        if($name==='')throw new InvalidArgumentException('请填写菜单名称');
        if(preg_match('/[\x00-\x20\\\\]/',$link))throw new InvalidArgumentException('链接不能包含空格、控制字符或反斜杠');
        $scheme=parse_url($link,PHP_URL_SCHEME);
        if(($scheme&&!in_array(strtolower($scheme),['http','https'],true))||substr($link,0,2)==='//')throw new InvalidArgumentException('链接仅支持http、https或站内路径');
        $result=['name'=>$name,'link'=>$link,'target'=>($item['target']??'')==='_blank'?'_blank':'_self'];
        $children=$item['sub']??[];
        if(!is_array($children)||count($children)>60)throw new InvalidArgumentException('二级菜单格式错误或超过60项');
        if($child&&$children)throw new InvalidArgumentException('菜单最多支持两级');
        if($children){$result['sub']=[];foreach($children as $row)$result['sub'][]=$normalize($row,true);}
        if($link===''&&empty($result['sub']))throw new InvalidArgumentException('末级菜单必须填写链接');
        return $result;
    };
    return array_map($normalize,$items);
}
function hhNavigationUrl($link) {
    if($link==='')return '#';
    if(preg_match('~^https?://~i',$link)||substr($link,0,1)==='#')return $link;
    return rtrim((string)\Utils\Helper::options()->siteUrl,'/').'/'.ltrim($link,'/');
}
function getCustomMenu($currentUrl='') {
    try{$items=hhParseNavigation(\Utils\Helper::options()->navbarInfo);}catch(InvalidArgumentException $e){return '';}
    $escape=function($s){return htmlspecialchars((string)$s,ENT_QUOTES,'UTF-8');};
    $active=function($url)use($currentUrl){if($url==='#')return false;$a=parse_url($url);$b=parse_url($currentUrl);return strtolower($a['host']??'')===strtolower($b['host']??'')&&rtrim($a['path']??'/','/')===rtrim($b['path']??'/','/')&&($a['query']??'')===($b['query']??'');};
    $anchor=function($item,$class='')use($escape){$url=hhNavigationUrl($item['link']);return '<a class="'.$escape($class).'" href="'.$escape($url).'" target="'.$escape($item['target']).'"'.($item['target']==='_blank'?' rel="noopener noreferrer"':'').' title="'.$escape($item['name']).'">'.$escape($item['name']);};
    $html='';foreach($items as $item){$children=$item['sub']??[];$on=$active(hhNavigationUrl($item['link']));foreach($children as $child)$on=$on||$active(hhNavigationUrl($child['link']));$html.='<li class="nav-item">'.$anchor($item,'nav-a'.($on?' active':''));if($children)$html.='<i class="iconfont nav-icon icon-xiala" aria-hidden="true"></i>';$html.='</a>';if($children){$html.='<div class="pt-md-4 sub-menu"><ul class="d-md-flex flex-md-wrap p-md-2">';foreach($children as $child)$html.='<li class="p-2'.($active(hhNavigationUrl($child['link']))?' active':'').'">'.$anchor($child).'</a></li>';$html.='</ul></div>';}$html.='</li>';}
    return $html;
}
