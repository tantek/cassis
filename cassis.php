<?php  
function js() { return false; } if (php_min_version("5.1.0")) { date_default_timezone_set("UTC"); } 
function php_min_version($s) { $s = explode(".", $s); $phpv = explode(".", phpversion()); for ($i=0; $i < count($s); $i+=1) { if ($s[$i] > $phpv[$i]) { return false; } } return true; } 
function preg_matches($p, $s) { $m = array(); if (preg_match_all($p, $s, $m, PREG_PATTERN_ORDER) !== FALSE) { return $m[0]; } else { return array(); } } 
function preg_match_1($p, $s) { $m = array(); if (preg_match($p, $s, $m) !== FALSE) { return $m[0]; } else { return null; } } 
function date_get_full_year($d = "") { if ($d == "") { $d = new DateTime(); } return $d->format('Y'); } 
function date_get_timestamp($d = "") { if ($d == "") { $d = new DateTime(); } return $d->format('U'); } 
function date_get_ordinal_days($d) { return 1 + $d->format('z'); } 
function date_get_rfc3339($d) { return $d->format('c'); } 
function getFullYear($d = "") { return date_get_full_year($d); }   
function strcat() {   $r = ""; $isjs = js(); $args = $isjs ? arguments : func_get_args(); for ($i=count($args)-1; $i>=0; $i-=1) { $r = $isjs ? $args[$i] + $r : $args[$i] . $r; } return $r; } 
function number($s) { return $s - 0; } 
function string($n) { if (js()) { if (typeof($n)==="number") { return Number($n).toString(); } else if (typeof($n)==="undefined") { return ""; } else { return $n.toString(); } } else { return "" . $n; } } 
function str_pad_left($s1, $n, $s2) { $s1 = string($s1); $s2 = string($s2); if (js()) { $n -= strlen($s1); while ($n >= strlen($s2)) { $s1 = strcat($s2, $s1); $n -= strlen($s2); } if ($n > 0) { $s1 = strcat(substr($s2, 0, $n), $s1); } return $s1; } else { return str_pad($s1, $n, $s2, STR_PAD_LEFT); } } 
function trim_slashes($s) { if ($s[0]==="/") { return substr($s, 1, strlen($s)-2); } return $s; } 
function preg_replace_1($p, $r, $s) { if (js()) { return $s.replace(new RegExp(trim_slashes($p), "i"), $r); } else { $r = preg_replace($p, $r, $s, 1); if ($r !== null) { return $r; } else { return $s; } } } 
function ctype_email_local($s) { return (preg_match("/^[a-zA-Z0-9_%+-]+$/", $s)); } 
function ctype_uri_scheme($s) { return (preg_match("/^[a-zA-Z][a-zA-Z0-9+.-]*$/", $s)); } 
function num_to_sxg($n) {   $m = "0123456789ABCDEFGHJKLMNPQRSTUVWXYZ_abcdefghijkmnopqrstuvwxyz"; $p = ""; $s = ""; if ($n==="" || $n===0) { return "0"; } if ($n<0) { $n = -$n; $p = "-"; } while ($n>0) { if(!js() && function_exists('bcmod')) { $d = bcmod($n, 60); $s = $m[$d] . $s; $n = bcdiv(bcsub($n, $d), 60); } else { $d = $n % 60; $s = strcat($m[$d], $s); $n = ($n-$d)/60; } } return strcat($p, $s); } 
function num_to_sxgf($n, $f) { if (!$f) { $f=1; } return str_pad_left(num_to_sxg($n), $f, "0"); } 
function sxg_to_num($s) {   $j = strlen($s); $m = 1; $n = 0; if ($s[0]==="-") { $m = -1; $j-=1; $s = substr($s, 1, $j); } for ($i=0; $i<$j; $i+=1) { $c = ord($s[$i]); if ($c>=48 && $c<=57) { $c=$c-48; } else if ($c>=65 && $c<=72) { $c-=55; } else if ($c===73 || $c===108) { $c=1; } else if ($c>=74 && $c<=78) { $c-=56; } else if ($c===79) { $c=0; } else if ($c>=80 && $c<=90) { $c-=57; } else if ($c===95 || $c===45) { $c=34; } else if ($c>=97 && $c<=107) { $c-=62; } else if ($c>=109 && $c<=122) { $c-=63; } else { break; } if(!js() && function_exists('bcadd')) { $n = bcadd(bcmul(60, $n), $c); } else { $n = 60*$n + $c; } } return $n*$m; } 
function sxg_to_numf($s, $f) { if ($f===undefined) { $f=1; } return str_pad_left(sxg_to_num($s), $f, "0"); } 
function numtosxg($n) { return num_to_sxg($n); } 
function numtosxgf($n, $f) { return num_to_sxgf($n, $f); } 
function sxgtonum($s) { return sxg_to_num($s); } 
function sxgtonumf($s, $f) { return sxg_to_numf($s, $f); } 
function date_create_ymd($s) {   if (!$s) { return (js() ? new Date() : new DateTime()); } if (js()) { if (substr($s,4,1)==='-') { $s=strcat(substr($s,0,4), substr($s,5,2), substr($s,8,2)); } $d = new Date(substr($s,0,4),substr($s,4,2)-1,substr($s,6,2)); $d.setHours(0); return $d; } else { return date_create(strcat($s, " 00:00:00")); } } 
function date_create_timestamp($s) { if (js()) { return new Date(1000*$s); } else { return new DateTime(strcat("@", string($s))); } } 
function dt_to_time($dt) { $dt = explode("T", $dt); if (count($dt)==1) { $dt = explode(" ", $dt); } return (count($dt)>1) ? $dt[1] : "0:00"; } 
function dt_to_date($dt) { $dt = explode("T", $dt); if (count($dt)==1) { $dt = explode(" ", $dt); } return $dt[0]; } 
function dt_to_ordinal_date($dt) { return ymd_to_yd(dt_to_date($dt)); } 
function isleap($y) { return ($y % 4 === 0 && ($y % 100 !== 0 || $y % 400 === 0)); } 
function ymdp_to_d($y, $m, $d) {   $md = array( array(0,31,59,90,120,151,181,212,243,273,304,334), array(0,31,60,91,121,152,182,213,244,274,305,335)); return $md[number(isleap($y))][$m-1] + number($d); } 
function ymd_to_d($d) { if (substr($d, 4, 1)==='-') { return ymdp_to_d(substr($d,0,4),substr($d,5,2),substr($d,8,2)); } else { return ymdp_to_d(substr($d,0,4),substr($d,4,2),substr($d,6,2)); } } 
function ymdp_to_yd($y, $m, $d) { return strcat(str_pad_left($y, 4, "0"), '-', str_pad_left(ymdp_to_d($y, $m, $d), 3, "0")); } 
function ymd_to_yd($d) { if (substr($d, 4, 1)==='-') { return ymdp_to_yd(substr($d,0,4),substr($d,5,2),substr($d,8,2)); } else { return ymdp_to_yd(substr($d,0,4),substr($d,4,2),substr($d,6,2)); } } 
function bim_from_od($d) { return 1+floor(($d-1)/61); } 
function date_get_bim() {   $args = js() ? arguments : func_get_args(); return bim_from_od( date_get_ordinal_days( date_create_ymd((count($args) > 0) ? $args[0] : 0))); } 
function get_nm_str($m) {   $a = array("New January", "New February", "New March", "New April", "New May", "New June", "New July", "New August", "New September", "New October", "New November", "New December"); return $a[($m-1)]; } 
function nm_from_od($d) { return ((($d-1) % 61) > 29) ? 2+2*(bim_from_od($d)-1) : 1+2*(bim_from_od($d)-1); } 
function date_get_ordinal_date() {   $args = js() ? arguments : func_get_args(); $d = date_create_ymd((count($args) > 0) ? $args[0] : 0); return strcat(date_get_full_year($d), '-', str_pad_left(date_get_ordinal_days($d), 3, "0")); } 
function y_to_days($y) { return floor( (date_get_timestamp(date_create_ymd(strcat($y, "-01-01"))) - date_get_timestamp(date_create_ymd("1970-01-01")))/86400); } 
function ymd_to_days($d) { return yd_to_days(ymd_to_yd($d)); } 
function ymd_to_sd($d) { return num_to_sxg(ymd_to_days($d)); } 
function ymd_to_sdf($d, $f) { return num_to_sxgf(ymd_to_days($d), $f); } 
function ydp_to_ymd($y, $d) {   $md = array( array(0,31,59,90,120,151,181,212,243,273,304,334,365), array(0,31,60,91,121,152,182,213,244,274,305,335,366)); $d -= 1; $m = trunc($d / 29); if ($md[isleap($y) - 0][$m] > $d) $m -= 1; $d = $d - $md[isleap($y)-0][$m] + 1; $m += 1; return strcat($y, '-', str_pad_left($m, 2, '0'), '-', str_pad_left($d, 2, '0')); } 
function yd_to_ymd($d) { return ydp_to_ymd(substr($d, 0, 4), substr($d, 5, 3)); } 
function yd_to_days($d) { return y_to_days(substr($d, 0, 4)) - 1 + number(substr($d, 5, 3)); } 
function yd_to_sd($d) { return num_to_sxg(yd_to_days($d)); } 
function yd_to_sdf($d, $f) { return num_to_sxgf(yd_to_days($d), $f); } 
function days_to_yd($d) {   $d = date_create_timestamp( date_get_timestamp( date_create_ymd("1970-01-01")) + $d*86400); $y = date_get_full_year($d); $a = date_create_ymd(strcat($y, "-01-01")); return strcat($y, "-", str_pad_left( 1 + floor(( date_get_timestamp($d) - date_get_timestamp($a))/86400), 3, "0")); } 
function sd_to_yd($d) { return days_to_yd(sxg_to_num($d)); } 
function ymdptod($y,$m,$d) { return ymdp_to_d($y,$m,$d); } 
function ymdptoyd($y,$m,$d) { return ymdp_to_yd($y,$m,$d); } 
function ymdtoyd($d) { return ymd_to_yd($d); } 
function bimfromod($d) { return bim_from_od($d); } 
function getnmstr($m) { return get_nm_str($m); } 
function nmfromod($d) { return nm_from_od($d); } 
function ymdtodays($d) { return ymd_to_days($d); } 
function ymdtosd($d) { return ymd_to_sd($d); } 
function ymdtosdf($d,$f) { return ymd_to_sdf($d, $f); } 
function ydtodays($d) { return yd_to_days($d); } 
function ydtosd($d) { return yd_to_sd($d); } 
function ydtosdf($d,$f) { return yd_to_sdf($d, $f); } 
function daystoyd($d) { return days_to_yd($d); } 
function sdtoyd($d) { return sd_to_yd($d); } 
function is_http_header($s) { return (preg_match_1('/^[a-zA-Z][-\\w]*:/',$s)!==null); } 
function web_address_to_uri($wa, $addhttp) { if (!$wa || (substr($wa, 0, 7) === 'http://') || (substr($wa, 0, 8) === 'https://') || (substr($wa, 0, 6) === 'irc://')) { return $wa; } if ((substr($wa, 0, 7) === 'Http://') || (substr($wa, 0, 8) === 'Https://')) { return strcat('h', substr($wa, 1, strlen($wa))); } if (substr($wa,0,1) === '@') { return strcat('https://twitter.com/', substr($wa, 1, strlen($wa))); } if ($addhttp) { $wa = strcat('http://', $wa); } return $wa; } 
function uri_clean($uri) { $uri = web_address_to_uri($uri, false); if (substr($uri, 0, 7) === 'http://') { $uri = explode('://', $uri); $uri = array_slice($uri, 1); $uri = implode('://', $uri); } return str_ireplace("%3A", ":", str_ireplace("%2F", "/", rawurlencode($uri))); } 
function protocol_of_uri($uri) { if (offset(':', $uri) === 0) { return ""; } $uri = explode(':', $uri, 2); if (!ctype_uri_scheme($uri[0])) { return ""; } return strcat($uri[0], ':'); } 
function relative_uri_hash($uri) { if (offset(':', $uri) === 0) { return ""; } $uri = explode(':', $uri, 2); if (!ctype_uri_scheme($uri[0])) { return ""; } return $uri[1]; } 
function hostname_of_uri($uri) { $uri = explode('/', $uri, 4); if (count($uri) > 2) { $uri = $uri[2]; if (offset(':', $uri) !== 0) { $uri = explode(':', $uri, 2); $uri = $uri[0]; } return $uri; } return ''; } 
function sld_of_uri($uri) { $uri = hostname_of_uri($uri); $uri = explode('.', $uri); if (count($uri) > 1) { return $uri[count($uri) - 2]; } return ""; } 
function path_of_uri($uri) { $uri = explode('/', $uri, 4); if (count($uri) > 3) { $uri = array_slice($uri, 3); $uri = strcat('/', implode('/', $uri)); if (offset('?', $uri) !== 0) { $uri = explode('?', $uri, 2); $uri = $uri[0]; } if (offset('#', $uri) !== 0) { $uri = explode('#', $uri, 2); $uri = $uri[0]; } return $uri; } return '/'; } 
function prepath_of_uri($uri) { $uri = explode('/', $uri); $uri = array_slice($uri, 0, 3); return implode('/', $uri); } 
function segment_of_uri($n, $u) { $u = path_of_uri($u); $u = explode('/', $u); if ($n>=0 && $n<count($u)) return $u[$n]; else return ""; } 
function fragment_of_uri($u) { if (offset('#', $u) !== 0) { $u = explode('#', $u, 2); return $u[1]; } return ""; } 
function is_http_uri($uri) { $uri = explode(':', $uri, 2); return !!strncmp($uri[0], 'http', 4); } 
function get_absolute_uri($uri, $base) { if (protocol_of_uri($uri) != "") { return $uri; } if (substr($uri, 0, 2) === '//') { return strcat(protocol_of_uri($base), $uri); } if (substr($uri, 0, 1) === '/') { return strcat(prepath_of_uri($base), $uri); } return strcat(prepath_of_uri($base), path_of_uri($base), $uri); } 
function webaddresstouri($wa, $addhttp) { return web_address_to_uri($wa, $addhttp); } 
function uriclean($uri) { return uri_clean($uri); } 
function is_html_type($ct) { $ct = explode(';', $ct, 2); $ct = $ct[0]; return ($ct === 'text/html' || $ct === 'application/xhtml+xml'); } 
function num_to_hxt($n) {   $m = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"; $s = ""; if ($n === undefined || $n === 0) { return "0"; } while ($n>0) { $d = $n % 36; $s = strcat($m[$d], $s); $n = ($n-$d)/36; } return $s; } 
function num_to_hxtf($n, $f) { if ($f === undefined) { $f=1; } return str_pad_left(num_to_hxt($n), $f, "0"); } 
function hxt_to_num($h) {   $j = strlen($h); $n = 0; for ($i=0; $i<$j; $i+=1) { $c = ord($h[$i]); if ($c>=48 && $c<=57) { $c=$c-48; } else if ($c>=65 && $c<=90) { $c-=55; } else if ($c>=97 && $c<=122) { $c-=87; } else { $c = 0; } $n = 36*$n + $c; } return $n; } 
function numtohxt($n) { return num_to_hxt($n); } 
function numtohxtf($n,$f) { return num_to_hxtf($n, $f); } 
function hxttonum($h) { return hxt_to_num($h); } 
function num_to_isbn10($n) {   $n = string($n); $d = 0; $f = 2; for ($i=strlen($n)-1; $i>=0; $i-=1) { $d += $n[$i]*$f; $f += 1; } $d = 11-($d % 11); if ($d===10) {$d="X";} else if ($d===11) {$d="0";} else {$d=string($d);} return strcat(str_pad_left($n, 9, "0"), $d); } 
function numtoisbn10($n) { return num_to_isbn10($n); } 
function trunc($n) { return floor($n); } 
function offset($n, $h) { $n = strpos($h, $n); if ($n === false) { return 0; } else { return $n+1; } } 
function contains($h, $n) { return strpos($h, $n)!==false; } 
function last_character_of($s) { return (strlen($s) > 0) ? $s[strlen($s)-1] : ''; } 
function line_1_of($s) {   $r = preg_match_1('/^[\\w\\W]*?[\\n\\r]+?/', $s); if ($r === null) { return $s; } return substr($r, 0, strlen($r)-1); } 
function delete_line_1_of($s) { if (preg_match_1('/^[\\w\\W]*?[\\n\\r]+?/', $s) === null) { return ''; } return preg_replace_1('/^[\\w\\W]*?[\\n\\r]+?/', '', $s); } 
function xp_has_class($s) { return strcat("//*[contains(concat(' ',@class,' '),' ",$s," ')]"); } 
function xpr_has_class($s) { return strcat(".//*[contains(concat(' ',@class,' '),' ",$s," ')]"); } 
function xp_has_id($s) { return strcat("//*[@id='", $s, "']"); } 
function xp_attr_starts_with($a, $s) { return strcat("//*[starts-with(@", $a, ",'", $s, "')]"); } 
function xp_has_rel($s) { return strcat("//*[@href and contains(concat(' ',@rel,' '),' ", $s, " ')]"); } 
function xpr_has_rel($s) { return strcat(".//*[@href and contains(concat(' ',@rel,' '),' ", $s, " ')]"); } 
function xpr_attr_starts_with_has_rel($a, $s, $r) { return strcat(".//*[@href and contains(concat(' ',@rel,' '),' ", $r, " ') and starts-with(@", $a, ",'", $s, "')]"); } 
function xpr_attr_starts_with_has_class($a, $s, $c) { return strcat(".//*[contains(concat(' ',@class,' '),' ", $c, " ') and starts-with(@", $a, ",'", $s, "')]"); } 
function vcp_dt_readable($d) {   $d = explode("T", $d); $r = ""; if (count($d)>1) { $r = explode("-", $d[1]); if (count($d)==1) { $r = explode("+", $d[1]); } if (count($d)>1) { $r = strcat('<time class="value" datetime="',$d[1],'">', $r[0],'</time> on '); } else { $r = strcat('<time class="value">', $d[1], '</time> on '); } } return strcat($r, '<time class="value">', $d[0], '</time>'); } 
function xphasclass($s) { return xp_has_class($s); } 
function xprhasclass($s) { return xpr_has_class($s); } 
function xphasid($s) { return xp_has_id($s); } 
function xpattrstartswith($a, $s) { return xp_attr_starts_with($a, $s); } 
function xphasrel($s) { return xp_has_rel($s); } 
function xprhasrel($s) { return xpr_has_rel($s); } 
function xprattrstartswithhasrel($a, $s, $r) { return xpr_attr_starts_with_has_rel($a, $s, $r); } 
function xprattrstartswithhasclass($a, $s, $c) { return xpr_attr_starts_with_has_class($a, $s, $c); } 
function vcpdtreadable($d) { return vcp_dt_readable($d); } 
function whistle_short_path($p) { return strcat(substr($p, 9, 1), ((substr($p, 9, 1)!=='t') ? "/" : ""), yd_to_sdf(substr($p, 0, 8), 3), num_to_sxg(substr($p, 10, 3))); } 
function html_unesc_amp_only($s) { return str_ireplace('&amp;', '&', $s); } 
function html_esc_amper_once($s) { return str_ireplace('&', '&amp;', html_unesc_amp_only($s)); } 
function html_esc_amp_ang($s) { return str_ireplace('<', '&lt;', str_ireplace('>', '&gt;', html_esc_amper_once($s))); } 
function ellipsize_to_word($s, $max, $e, $min) {   if (strlen($s)<=$max) { return $s; } $elen = strlen($e); $slen = $max-$elen; if ($e==='...') { for ($i=1; $i<=$elen+1; $i+=1) { if (substr($s, $max-$i, 2)===': ') { return substr($s, 0, $max-$i+1); } } } if ($min) { while ($slen>$min && !contains('@$ -~*()_+[]{}|;,<>', $s[$slen-1])) { $slen-=1; } } if ($s[$slen-1]==='/' && $slen > 2) { if ($s[$slen-2]===':') { $slen-=1; } if ($s[$slen-2]==='/') { $slen-=2; } } if ($s[$slen-1]===':' && $slen > 5 && substr($s, $slen-5, 5)==='http:') { $slen -= 5; } else if ($s[$slen-1]==='p' && $slen > 4 && substr($s, $slen-4, 4)==='http') { $slen -= 4; } else if ($s[$slen-1]==='t' && $slen > 4 && (substr($s, $slen-3, 4)==='http' || substr($s, $slen-3, 4)===' htt')) { $slen -= 3; } else if ($s[$slen-1]==='h' && $slen > 4 && substr($s, $slen-1, 4)==='http') { $slen -= 1; } if ($slen > 0 && contains('@$', $s[$slen-1])) { $slen-=1; } while ($slen > 1 && contains('.!?', $s[$slen-1])) { $slen-=2; } if ($slen > 2 && contains("\n\r ", $s[$slen-1])) { while (contains("\n\r ", $s[$slen-2]) && $slen > 2) { --$slen; } } if ($slen < 1) { return $e; } if ($e==='...' && substr($s, $slen-2, 2)===': ') { return substr($s, 0, $slen); } return strcat(substr($s, 0, $slen), $e); } 
function trim_leading_urls($s) { $r = trim($s); while (substr($r, 0, 5) == 'http:' || substr($r, 0, 6) == 'https:') { $ws = offset(' ', $r); $rs = offset("\r", $r); if ($rs == 0) { $rs = offset("\n", $r); } if ($rs != 0 && $rs < $ws) { $ws = $rs; } if ($ws == 0) { return $s; } $r = substr($r, $ws, strlen($r)-$ws); } $r = trim($r); return ((strlen($r) > 0) ? $r : $s); } 
function auto_space($s) { if ($s[0] === ' ') { $s = strcat('&#xA0;', substr($s, 1, strlen($s)-1)); } return str_ireplace(array("\r\n", "\r", "\n ", "\n", "  "), array("\n", "\n", '<br class="auto-break"/>&#xA0;', '<br class="auto-break"/>', ' &#xA0;'), $s); } 
function auto_link_re() { return '/(?:\\@[_a-zA-Z0-9]{1,17})(?:\\.[a-zA-Z0-9][-a-zA-Z0-9]*)*|(?:(?:(?:(?:http|https|irc)?:\\/\\/(?:(?:[!$&-.0-9;=?A-Z_a-z]|(?:\\%[a-fA-F0-9]{2}))+(?:\\:(?:[!$&-.0-9;=?A-Z_a-z]|(?:\\%[a-fA-F0-9]{2}))+)?\\@)?)?(?:(?:(?:[a-zA-Z0-9][-a-zA-Z0-9]*\\.)+(?:(?:aero|arpa|asia|a[cdefgilmnoqrstuwxz])|(?:biz|blog|b[abdefghijmnorstvwyz])|(?:cat|com|coop|c[acdfghiklmnoruvxyz])|(?:design|dev|d[ejkmoz])|(?:edu|e[cegrstu])|(?:fyi|f[ijkmor])|(?:gov|g[abdefghilmnpqrstuwy])|h[kmnrtu]|(?:info|int|i[delmnoqrst])|j[emop]|k[eghimnrwyz]|l[abcikrstuvy]|(?:mil|museum|m[acdeghklmnopqrstuvwxyz])|(?:name|net|n[acefgilopruz])|(?:org|om)|(?:pro|p[aefghklmnrstwy])|qa|(?:rocks|r[eouw])|(?:space|s[abcdeghijklmnortuvyz])|(?:tech|tel|travel|t[cdfghjklmnoprtvwz])|u[agkmsyz]|v[aceginu]|(?:wtf|w[fs])|xyz|y[etu]|z[amw]))|(?:(?:25[0-5]|2[0-4][0-9]|[0-1][0-9]{2}|[1-9][0-9]|[1-9])\\.(?:25[0-5]|2[0-4][0-9]|[0-1][0-9]{2}|[1-9][0-9]|[0-9])\\.(?:25[0-5]|2[0-4][0-9]|[0-1][0-9]{2}|[1-9][0-9]|[0-9])\\.(?:25[0-5]|2[0-4][0-9]|[0-1][0-9]{2}|[1-9][0-9]|[0-9])))(?:\\:\\d{1,5})?)(?:\\/(?:(?:[!#&-;=?-Z_a-z~])|(?:\\%[a-fA-F0-9]{2}))*)?)(?=\\b|\\s|$)/'; } 
function auto_link() {   $isjs = js(); $args = $isjs ? arguments : func_get_args(); if (count($args) === 0) { return ''; } $t = $args[0]; $do_embed = (count($args) > 1) && ($args[1]!==false); $do_link = (count($args) < 3) || ($args[2]!==false); $re = auto_link_re(); $ms = preg_matches($re, $t); if (!$ms) { return $t; } $mlen = count($ms); $sp = preg_split($re, $t); $t = ""; $sp[0] = string($sp[0]); for ($i=0; $i<$mlen; $i+=1) { $mi = $ms[$i]; $spliti = $sp[$i]; $t = strcat($t, $spliti); $sp[$i+1] = string($sp[$i+1]); if (substr($sp[$i+1], 0, 1)==='/') { $sp[$i+1] = substr($sp[$i+1], 1, strlen($sp[$i+1])-1); $mi = strcat($mi, '/'); } $spe = substr($spliti, -2, 2); if ((!$spe || !preg_match('/(?:\\=[\\"\\\']?|t;)/', $spe)) && substr(trim($sp[$i+1]), 0, 3)!=='</a' && (!contains( '@charset@font@font-face@import@media@namespace@page@supports@ABCDEFGHIJKLMNOPQ@', strcat($mi, '@')))) { $afterlink = ''; $afterchar = substr($mi, -1, 1); while (contains('.!?,;"\')]}', $afterchar) && ($afterchar!==')' || !contains($mi,'('))) { $afterlink = strcat($afterchar, $afterlink); $mi = substr($mi, 0, -1); $afterchar = substr($mi, -1, 1); } $fe = 0; if ($do_embed && strlen($mi) > 5) { $fe = strtolower( (substr($mi, -4, 1) === '.') ? substr($mi, -4, 4) : substr($mi, -5, 5)); } $wmi = web_address_to_uri($mi, true); $prot = protocol_of_uri($wmi); $hn = hostname_of_uri($wmi); $pa = path_of_uri($wmi); $ih = is_http_uri($wmi); $ahref = '<span class="figure" style="text-align:left">'; $enda = '</span>'; if ($do_link) { $ahref = strcat('<a class="auto-link figure" href="', $wmi, '">'); $enda = '</a>'; } if ($fe && ($fe === '.jpeg' || $fe === '.jpg' || $fe === '.png' || $fe === '.gif' || $fe === '.svg')) { $alt = strcat('a ', (offset('photo', $mi) != 0) ? 'photo' : substr($fe, 1)); $t = strcat($t, $ahref, '<img class="auto-embed" alt="', $alt, '" src="', $wmi, '"/>', $enda, $afterlink); } else if ($fe && ($fe === '.mp4' || $fe === '.mov' || $fe === '.ogv' || $fe === '.webm')) { $t = strcat($t, $ahref, '<video class="auto-embed" ', 'controls="controls" src="', $wmi, '"></video>', $enda, $afterlink); } else if ($hn === 'vimeo.com' && ctype_digit(substr($pa, 1))) { if ($do_link) { $t = strcat($t, '<a class="auto-link" href="', 'https:', relative_uri_hash($wmi), '">', $mi, '</a> '); } if ($do_embed) { $t = strcat($t, '<iframe class="vimeo-player auto-embed figure" width="480" height="385" style="border:0" src="', 'https://player.vimeo.com/video/', substr($pa, 1), '"></iframe>', $afterlink); } } else if ($hn === 'youtu.be' || (($hn === 'youtube.com' || $hn === 'www.youtube.com') && ($yvid = offset('watch?v=', $mi)) !== 0)) { if ($hn === 'youtu.be') { $yvid = substr($pa, 1); } else { $yvid = explode('&', substr($mi, $yvid+7)); $yvid = $yvid[0]; } if ($do_link) { $t = strcat($t, '<a class="auto-link" href="', 'https:', relative_uri_hash($wmi), '">', $mi, '</a> '); } if ($do_embed) { $t = strcat($t, '<iframe class="youtube-player auto-embed figure" width="480" height="385" style="border:0"  src="', 'https://www.youtube.com/embed/', $yvid, '"></iframe>', $afterlink); } } else if ($mi[0] === '@' && $do_link && !contains($mi, '.')) { if ($sp[$i+1][0] === '.' && $spliti != '' && ctype_email_local(substr($spliti, -1, 1))) { $t = strcat($t, $mi, $afterlink); } else { $t = strcat($t, '<a class="auto-link h-cassis-username" href="', $wmi, '">', $mi, '</a>', $afterlink); } } else if ($do_link) { if ($mi[0] === '@') { $wmi = web_address_to_uri(substr($mi, 1), true); } $t = strcat($t, '<a class="auto-link" href="', $wmi, '">', $mi, '</a>', $afterlink); } else { $t = strcat($t, $mi, $afterlink); } } else { $t = strcat($t, $mi); } } return strcat($t, $sp[$mlen]); } 
function get_auto_linked_urls($s) { $s = explode('href="', $s); $irtn = count($s); if ($irtn < 2) { return array(); } $r = array(); for ($i=1; $i<$irtn; $i++) { $r[$i-1] = substr($s[$i], 0, offset('"', $s[$i])-1); } return $r; } 
function get_in_reply_to_urls($s) {   $s = explode('in-reply-to: ', $s); $irtn = count($s); if ($irtn < 2) { return array(); } $r = array(); $re = auto_link_re(); for ($i=1; $i<$irtn; $i++) { $ms = preg_matches($re, $s[$i]); $msn = count($ms); if ($ms) { $sp = preg_split($re, $s[$i]); $j = 0; $afterlink = ''; while ($j<$msn && $afterlink == '' && ($sp[$j] == '' || ctype_space($sp[$j]))) { $m = $ms[$j]; if ($m[0] != '@') { $ac = substr($m, -1, 1); while (contains('.!?,;"\')]}', $ac) && ($ac != ')' || !contains($m, '('))) { $afterlink = strcat($ac, $afterlink); $m = substr($m, 0, -1); $ac = substr($m, -1, 1); } if (substr($m, 0, 6) === 'irc://') { } else { $r[count($r)] = web_address_to_uri($m, true); } } $j++; } } } return $r; } 
function tw_text_proxy() {   $isjs = js(); $args = $isjs ? arguments : func_get_args(); if (count($args) === 0) { return ''; } $t = $args[0]; $re = auto_link_re(); $ms = preg_matches($re, $t); if (!$ms) { return $t; } $mlen = count($ms); $sp = preg_split($re, $t); $t = ""; $sp[0] = string($sp[0]); for ($i=0; $i<$mlen; $i++) { $mi = $ms[$i]; $spliti = $sp[$i]; $t = strcat($t, $spliti); $sp[$i+1] = string($sp[$i+1]); if (substr($sp[$i+1], 0, 1)=='/') { $sp[$i+1] = substr($sp[$i+1], 1, strlen($sp[$i+1])-1); $mi = strcat($mi, '/'); } $spe = substr($spliti, -2, 2); if ($mi[0] !== '@' ) { $afterlink = ''; $afterchar = substr($mi, -1, 1); while (contains('.!?,;"\')]}', $afterchar) && ($afterchar !== ')' || !contains($mi, '('))) { $afterlink = strcat($afterchar, $afterlink); $mi = substr($mi, 0, -1); $afterchar = substr($mi, -1, 1); } $prot = protocol_of_uri($mi); $proxy_url = ''; if ($prot === 'irc:') { $proxy_url = $mi; } else { $proxy_url = 'https://j.mp/0011235813'; } $t = strcat($t, $proxy_url, $afterlink); } else { $t = strcat($t, $mi); } } return strcat($t, $sp[$mlen]); } 
function note_length_check($note, $maxlen, $username) {   if ($maxlen < 1) { return 0; } $note_size_chk_u = $username ? 6 + strlen(string($username)) : 0; $note_size_chk_n = strlen(string($note)) + $note_size_chk_u; if ($note_size_chk_n === $maxlen) { return 200; } if ($note_size_chk_n < $maxlen) { return 206; } if ($note_size_chk_n - $note_size_chk_u < $maxlen) { return 207; } if ($note_size_chk_n - $note_size_chk_u === $maxlen) { return 208; } return 413; } 
function tw_length_check($t, $maxlen, $username) { return note_length_check(tw_text_proxy($t), $maxlen, $username); } 
function tw_url_to_status_id($u) { if (!$u) return 0; $u = explode("/", string($u)); if (($u[2] != "twitter.com" && $u[2] != "mobile.twitter.com") || $u[4] != "status" || !ctype_digit($u[5])) { return 0; } return $u[5]; } 
function tw_url_to_username($u) { if (!$u) return 0; $u = explode("/", string($u)); if ($u[2] != "twitter.com" || $u[4] != "status" || !ctype_digit($u[5])) { return 0; } return $u[3]; } 
function fb_url_to_event_id($u) { if (!$u) return 0; $u = explode("/", string($u)); if (($u[2] != "fb.com" && $u[2] != "facebook.com" && $u[2] != "www.facebook.com") || $u[3] != "events" || !ctype_digit($u[4])) { return 0; } return $u[4]; } 
