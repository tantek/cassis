<!-- cassis.js Copyright 2008-2011 Tantek Çelik http://tantek.com   -->
<!-- http://cassisproject.com conceived 2008-254, created 2009-299  -->
<!-- http://creativecommons.org/licenses/by-sa/3.0/                 -->
/* if you see this in the browser, you need to wrap your include of cassis.js with calls to ob_start and ob_end_clean, e.g. use the following in your PHP: ob_start(); include 'cassis.js'; ob_end_clean(); <?php 
// --------------------------------------------------------------------
// cassis0js.php - processed only by PHP. Use only // comments here.


// global configuration

if (php_min_version("5.1.0")) {
  date_default_timezone_set("UTC");
}

function php_min_version($s) {
  $s = explode(".",$s);
  $phpv = explode(".",phpversion());
  for ($i=0;$i<count($s);$i++) {
    if ($s[$i]>$phpv[$i]) {
      return false; 
    }
  }
  return true;
}


// date time functions

function date_get_full_year($d = "") {
 if ($d == "") {
   $d = new DateTime();
 }
 return $d->format('Y');
} 

function date_get_timestamp($d) { 
 return $d->format('U'); // $d->getTimestamp(); // in PHP 5.3+
}

function date_get_ordinal_days($d) {
 return 1+$d->format('z');
}

function date_get_rfc3339($d) {
 return $d->format('c');
}


// old wrappers. transition code away from them, do not use them in new code.
function getFullYear($d = "") {  
  // 2010-020 obsoleted. Use date_get_full_year instead
  return date_get_full_year($d);
}

// end cassis0js.php
// --------------------------------------------------------------------
/*/ // this comment inverter switches from PHP only to javascript only
// --------------------------------------------------------------------
// cassis0php.js - processed only by javascript. Use only // comments.


// arrays

function array() { // makes an array from as many items as you want to give it.
  return arguments;
}


// math and numerical functions

function floor(n) {
  return Math.floor(n);
}

function intval(n) {
  return parseInt(n);
}

function is_array(a) {
  return (typeof(a)=="object" && (a instanceof Array));
}


Array.min = function(a){ // from http://ejohn.org/blog/fast-javascript-maxmin/
  return Math.min.apply(Math, a);
};

function min() {
 var m = arguments;
 if (m.length < 1) {
   return false;
 } 
 if (m.length == 1) {
   m = m[0];
   if (!is_array(m)) {
     return m;
   }
 }
 return Array.min(m);
}

function ctype_digit(s) {
 return /^[0-9]+$/.test(s);
}


// date time functions

function date_create(s) {
 d = new Date();
 d.parse(s);
 return d;
}

function date_get_full_year(d) {
 if (arguments.length < 1) {
   d = new Date();
 }
 return d.getFullYear();
}

function date_get_timestamp($d) {
 return floor($d.getTime()/1000);
}

function date_get_rfc3339($d) {
  return strcat($d.getFullYear(),'-',
                str_pad_left(1+$d.getUTCMonth(),2,"0"),'-',
                str_pad_left($d.getDate(),2,"0"),'T',
                str_pad_left($d.getUTCHours(),2,"0"),':',
                str_pad_left($d.getUTCMinutes(),2,"0"),':',
                str_pad_left($d.getUTCSeconds(),2,"0"),'Z');
}

// newcal

function date_get_ordinal_days($d) {
  return ymdptod($d.getFullYear(),1+$d.getMonth(),$d.getDate());
}


// character and string functions 

function ord(s) {
 return s.charCodeAt(0);
}

function strlen(s) {
 return s.length;
} 

function substr(s,o,n) {
 var m = strlen(s);
 if (Math.abs(o)>=m) return false;
 if (o<0) o=m+o;
 if (n<0) n=m-o+n;
 if (n===undefined) n=m-o;
 return s.substring(o,o+n);
}

function strpos(h,n,o) {
 // clients must triple-equal test ===false for no match!
 // consider using offset(n,h) instead (0 - not found, else 1-based index)
 if (arguments.length == 2) {
  o = 0;
 }
 o = h.indexOf(n,o);
 if (o==-1) { return false; }
 else { return o; }
}

function strncmp(s1,s2,n) {
 s1 = substr(s1+'',0,n);
 s2 = substr(s2+'',0,n);
 return (s1==s2) ? 0 :
        ((s1 < s2) ? -1 : 1);
}

function explode(d,s,n) {
 if (arguments.length == 2) {
   return s.split(d);
 }
 return s.split(d,n);
}

function implode(d,a) {
 return a.join(d);
}

function rawurlencode(s) {
 return encodeURIComponent(s);
}

function htmlspecialchars(s) {
 var c= [["&","&amp;"],["<","&lt;"],[">","&gt;"],["'","&#039;"],['"',"&quot;"]];
 for (i=0;i<c.length;i++) {
  s = s.replace(new RegExp(c[i][0],"g"),c[i][1]); // s.replace(c[i][0],c[i][1]);
 }
 return s;
}

function str_ireplace(a,b,s) {
 return s.replace(new RegExp(a,"gi"),b);
}

function preg_match(p,s) {
  return (s.match(trim_slashes(p)) ? 1 : 0);
}

function preg_split(p,s) {
  return s.split(new RegExp(trim_slashes(p),"gi"));
}

function trim() {
 var m = arguments;
 var s = m[0];
 var c = count(m)>1 ? m[1] : " \t\n\r\f\x00\x0b\xa0";
 var i = 0;
 var j = strlen(s);
 while (contains(c,s[i]) && i<j) {
   i++;
 }
 --j;
 while (j>i && contains(c,s[j])) {
   --j;
 }
 if (j>i) {
   return substr(s,i,j-i+1);
 }
 else {
   return '';
 }
}

function rtrim() {
 var m = arguments;
 var s = m[0];
 var c = count(m)>1 ? m[1] : " \t\n\r\f\x00\x0b\xa0";
 var j = strlen(s)-1;
 while (j>=0 && contains(c,s[j])) {
   --j;
 }
 if (j>=0) {
   return substr(s,0,j+1);
 }
 else {
   return '';
 }
}



// array functions

function count(a) {
 return a.length;
}


// more javascript-only php-equivalent functions here 


// javascript-only framework functions
// from http://www.quirksmode.org/js/events_properties.html#target
function targetelement(e) {
  var targ;
	if (!e) var e = window.event;
	if (e.target) targ = e.target;
	else if (e.srcElement) targ = e.srcElement;
	if (targ.nodeType == 3) // defeat Safari bug
		targ = targ.parentNode;
	return targ;
}

function doevent(el,evt) {
  if (evt=="click" && el.tagName=='A') {
  // note: dispatch/fireEvent not work FF3.5+/IE8+ on [a href] w "click" event
    window.location = el.href; // workaround
    return true;
  }
  if (document.createEvent) {
    var eo = document.createEvent("HTMLEvents");
    eo.initEvent(evt, true, true);
    return !el.dispatchEvent(eo);
  } 
  else if (document.createEventObject) {
    return el.fireEvent("on"+evt);
  }
}


// old wrappers. transition code away from them, do not use them in new code.
//function getFullYear(d) {       // use date_get_full_year instead
//  return date_get_full_year(d);
//}


// end cassis0php.js
// --------------------------------------------------------------------

/**/ // unconditional comment closer enters PHP+javascript processing
/* ------------------------------------------------------------------ */
/* cassis0.js - processed by both PHP and javascript */

function js() {
 return ("00"==false);
}

// character and string functions 

function strcat() { // takes as many strings as you want to give it.
 $strcatr = "";
 $isjs = js();
 $args = $isjs ? arguments : func_get_args();
 for ($strcati=count($args)-1; $strcati>=0; $strcati--) {
    $strcatr = $isjs ? $args[$strcati] + $strcatr : $args[$strcati] . $strcatr;
 }
 return $strcatr;
}

function string($n) {
 if (js()) { 
   if (typeof($n)=="number")
     return Number($n).toString(); 
   else if (typeof($n)=="undefined")
     return "";
   else return $n.toString();
 }
 else { return "" . $n; }
}

function str_pad_left($s1,$n,$s2) {
 if (js()) {
   $n -= strlen($s1);
   while ($n >= strlen($s2)) { 
     $s1 = strcat($s2,$s1); 
     $n -= strlen($s2);
   }
   if ($n > 0) {
     $s1 = strcat(substr($s2,0,$n),$s1);
   }
   return $s1;
 }
 else { return str_pad($s1,$n,$s2,STR_PAD_LEFT); }
}

function trim_slashes($s) {
  if ($s[0]=="/") { // strip unnecessary / delimiters that PHP regexp funcs want
    return substr($s,1,strlen($s)-2);
  }
  return $s;
}

function preg_matches($p,$s) {
  if (js()) {
    return $s.match(new RegExp(trim_slashes($p),"gi"));
  }
  else {
    $m = array();
    if (preg_match_all($p, $s, $m, PREG_PATTERN_ORDER) !== FALSE) {
      return $m[0];
    }
    else {
      return array();
    }
  }
}


/* end cassis0.js */


/* ------------------------------------------------------------------ */


/* newbase60 */

function num_to_sxg($n) {
 $s = "";
 $p = "";
 $m = "0123456789ABCDEFGHJKLMNPQRSTUVWXYZ_abcdefghijkmnopqrstuvwxyz";
 if ($n==="" || $n===0) { return "0"; }
 if ($n<0) {
   $n = 0-$n;
   $p = "-";
 }
 while ($n>0) {
   $d = $n % 60;
   $s = strcat($m[$d],$s);
   $n = ($n-$d)/60;
 }
 return strcat($p,$s);
}

function num_to_sxgf($n, $f) {
 if (!$f) { $f=1; }
 return str_pad_left(num_to_sxg($n), $f, "0");
}

function sxg_to_num($s) {
 $n = 0;
 $m = 1;
 $j = strlen($s);
 if ($s[0]=="-") {
   $m= -1;
   $j--;
   $s = substr($s,1,$j);
 }
 for ($i=0;$i<$j;$i++) { // iterate from first to last char of $s
   $c = ord($s[$i]); //  put current ASCII of char into $c  
   if ($c>=48 && $c<=57) { $c=$c-48; }
   else if ($c>=65 && $c<=72) { $c-=55; }
   else if ($c==73 || $c==108) { $c=1; } // typo capital I, lowercase l to 1
   else if ($c>=74 && $c<=78) { $c-=56; }
   else if ($c==79) { $c=0; } // error correct typo capital O to 0
   else if ($c>=80 && $c<=90) { $c-=57; }
   else if ($c==95 || $c==45) { $c=34; } // _ underscore and correct dash - to _
   else if ($c>=97 && $c<=107) { $c-=62; }
   else if ($c>=109 && $c<=122) { $c-=63; }
   else { $c = 0; } // treat all other noise as 0
   $n = 60*$n + $c;
 }
 return $n*$m;
}

function sxg_to_numf($s, $f) {
 if ($f===undefined) { $f=1; }
 return str_pad_left(string(sxg_to_num($s)), $f, "0");
}

/* == compat functions only == */
function numtosxg($n) {
  return num_to_sxg($n);
}

function numtosxgf($n, $f) {
  return num_to_sxgf($n, $f);
}

function sxgtonum($s) {
  return sxg_to_num($s);
}

function sxgtonumf($s, $f) {
  return sxg_to_numf($s, $f);
}
/* == end compat functions == */

/* end newbase60 */



/* ------------------------------------------------------------------ */


/* date and time */

function date_create_ymd($s) {
 if (js()) { 
   if (substr($s,4,1)=='-') {
      $s=strcat(strcat(substr($s,0,4),substr($s,5,2)),substr($s,8,2));
   }
   $d = new Date(substr($s,0,4),substr($s,4,2)-1,substr($s,6,2));
   $d.setHours(0); // was setUTCHours, avoiding bc JS has no default timezone
   return $d;
 }
 else { return date_create(strcat($s," 00:00:00")); }
}

function date_create_timestamp($s) {
 if (js()) {
   return new Date(1000*$s);
 }
 else {
   return new DateTime(strcat("@",string($s)));
 }
}

// function date_get_timestamp($d) { } // defined in PHP/JS specific code above.

// function date_get_rfc3339($d) { } // defined in PHP/JS specific code above.

/* end date and time */


/* ------------------------------------------------------------------ */


/* newcal */

function isleap($y) {
  return ($y % 4 == 0 && ($y % 100 != 0 || $y % 400 == 0));
}

function ymdptod($y,$m,$d) {
  $md = array(
         array(0,31,59,90,120,151,181,212,243,273,304,334),
         array(0,31,60,91,121,152,182,213,244,274,305,335));
  return $md[isleap($y)-0][$m-1]+($d-0);
}

function ymdptoyd($y,$m,$d) {
  return strcat(str_pad_left($y,4,"0"),'-', str_pad_left(string(ymdptod($y,$m,$d)),3,"0"));
}

function ymdtoyd($d) {
  if (substr($d,4,1)=='-') {
    return ymdptoyd(substr($d,0,4),substr($d,5,2),substr($d,8,2));
  }
  else {
    return ymdptoyd(substr($d,0,4),substr($d,4,2),substr($d,6,2));
  }
}

// function date_get_ordinal_days($d) {} // defined in PHP/JS specific code.

function date_get_bim() {
 $arguments = js() ? arguments : func_get_args();

 return bimfromod(date_get_ordinal_days(
         (count($arguments) > 0) ? $arguments[0]
                                 : (js() ? new Date() : new DateTime())
        ));
} 


function getnmstr($m) {
  $a = array("New January", "New February", "New March", "New April", "New May", "New June", "New July", "New August", "New September", "New October", "New November", "New December");
  return $a[($m-1)];
}

function bimfromod($d) {
  return 1+floor(($d-1)/61);
}

function nmfromod($d) {
  return ((($d-1) % 61) > 29) ? 2+2*(bimfromod($d)-1) : 1+2*(bimfromod($d)-1);
}

function date_get_ordinal_date(/* $d = "" */) {
 $arguments = js() ? arguments : func_get_args();
 $d = (count($arguments) > 0) ? $arguments[0]
                                 : (js() ? new Date() : new DateTime());
 return strcat(date_get_full_year($d), '-',
               str_pad_left(date_get_ordinal_days($d), 3, "0"));
}

/* end newcal */


/* begin epochdays */

// convert ymd to epoch days and sexagesimal epoch days (sd)

function ymdtodays($d) {
  return floor((date_get_timestamp(date_create_ymd($d))-date_get_timestamp(date_create_ymd("1970-01-01")))/86400);
}

function ymdtosd($d) {
  return numtosxg(ymdtodays($d));
}

function ymdtosdf($d,$f) {
  return numtosxgf(ymdtodays($d),$f);
}

// convert ordinal date (YYYY-DDD) to epoch days and sexagesimal epoch days (sd)

function ydtodays($d) {
  return ymdtodays(strcat(substr($d,0,4),'-01-01'))-1+substr($d,5,3);
}

function ydtosd($d) {
  return numtosxg(ydtodays($d));
}

function ydtosdf($d,$f) {
  return numtosxgf(ydtodays($d),$f);
}

// convert epoch days or sexagesimal epoch days (sd) to ordinal date

function daystoyd($d) {
  $d = date_create_timestamp(date_get_timestamp(date_create_ymd("1970-01-01")) + $d*86400);
  $y = date_get_full_year($d);
  $a = date_create_ymd(strcat($y,"-01-01"));
  return strcat($y, strcat("-", str_pad_left(string(1+floor((date_get_timestamp($d)-date_get_timestamp($a))/86400)), 3, "0")));
}

function sdtoyd($d) {
  return daystoyd(sxgtonum($d));
}

/* end epochdays */


/* ------------------------------------------------------------------ */


/* webaddress */

function webaddresstouri($wa, $addhttp) {
  if ($wa=='' || (substr($wa, 0,7) == "http://") || (substr($wa, 0,8) == "https://")) {
    return $wa;
  }
  
  if (substr($wa,0,1) == "@") {
    return strcat("http://twitter.com/",substr($wa,1,strlen($wa)));
  }

  if ($addhttp) {
    $wa = strcat("http://",$wa);
  }
  return $wa;
}

function uriclean($uri) {
  $uri = webaddresstouri($uri);
  // prune the optional http:// for a neater param
  if (substr($uri, 0,7) == "http://") {
    $uri = explode("://",$uri,2);
    $uri = $uri[1];
  }
  // URL encode
  return str_ireplace("%2F","/",rawurlencode($uri));
}

/* end webaddress */


/* ------------------------------------------------------------------ */


/* hexatridecimal */

function numtohxt($n) {
 $s = "";
 $m = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
 if ($n===undefined || $n===0) { return "0"; }
 while ($n>0) {
   $d = $n % 36;
   $s = strcat($m[$d],$s);
   $n = ($n-$d)/36;
 }
 return $s;
}

function numtohxtf($n,$f) {
 if ($f===undefined) { $f=1; }
 return str_pad_left(numtohxt($n), $f, "0");
}

function hxttonum($h) {
 $n = 0;
 $j = strlen($h);
 for ($i=0;$i<$j;$i++) { // iterate from first to last char of $h
   $c = ord($h[$i]); //  put current ASCII of char into $c  
   if ($c>=48 && $c<=57) { $c=$c-48; } // 0-9
   else if ($c>=65 && $c<=90) { $c-=55; } // A-Z
   else if ($c>=97 && $c<=122) { $c-=87; } // a-z case-insensitive treat as A-Z
   else { $c = 0; } // treat all other noise as 0
   $n = 36*$n + $c;
 }
 return $n;
}

/* end hexatridecimal */


/* ------------------------------------------------------------------ */


/* ISBN-10 */

function numtoisbn10($n) {
 $n=string($n);
 $d=0;
 $f=2;
 for ($i=strlen($n)-1;$i>=0;$i--) {
  $d += $n[$i]*$f;
  $f++;  
 }
 $d = 11-($d % 11);
 if ($d==10) {$d="X";}
 else if ($d==11) {$d="0";}
 else {$d=string($d);}
 return strcat(str_pad_left(string($n),9,"0"),$d);
}
/* end ISBN-10 */


/* ------------------------------------------------------------------ */


/* ASIN */

function asintorsxg($a) { // ASIN to reversible sexagesimal; prefix ISBN-10 w ~
 $a = amazontoasin($a); // extract ASIN from Amazon URL if necessary
 if ($a[0]=='B') {
   $a=numtosxg(hxttonum(substr($a,1,9)));
 }
 else {
   $a = implode("",explode("-",$a)); // eliminate presentational hyphens
   if (strlen($a)>10 && substr($a,0,3)=="978") {
     $a = substr($a,3,9);
   }
   else {
     $a = substr($a,0,9);
   }
   $a = strcat("~",numtosxg($a));
 }
 return $a;
}

function amazontoasin($a) {
 // idempotent
 if (preg_match("/[\.\/]+/",$a)) {
   $a = explode("/",$a);
   for ($i=count($a)-1; $i>=0; $i--) {
     if (preg_match("/^[0-9A-Za-z]{10}$/",$a[$i])) {
       $a = $a[$i];
       break;
     }
   }
   if ($i==-1) { // no ASIN was found in URL
     $a=""; // reset $a to a string (instead of an array)
   }
 }
 return $a;
}

/* end ASIN */


/* ------------------------------------------------------------------ */


/* HyperTalk */

function trunc($n) { /* just an alias from BASIC days */
 return floor($n);
}

function offset($n,$h) {
 $n = strpos($h,$n);
 if ($n===false) { return 0; }
 else            { return $n+1; }
}

function contains($h,$n) {
 // actual HT syntax: haystack contains needle, e.g. if ("abc" contains "b")
 return !(strpos($h,$n)===false);
}

/* end HyperTalk */


/* ------------------------------------------------------------------ */


/* XPath */

function xphasclass($s) {
  return strcat("//*[contains(concat(' ',@class,' '),' ",$s," ')]");
}

function xprhasclass($s) {
  return strcat(".//*[contains(concat(' ',@class,' '),' ",$s," ')]");
}

function xphasid($s) {
  return strcat("//*[@id='",$s,"']");
}

function xpattrstartswith($a,$s) {
  return strcat("//*[starts-with(@",$a,",'",$s,"')]");
}

function xphasrel($s) {
  return strcat("//*[contains(concat(' ',@rel,' '),' ",$s," ')]");
}

function xprhasrel($s) {
  return strcat(".//*[contains(concat(' ',@rel,' '),' ",$s," ')]");
}

function xprattrstartswithhasrel($a,$s,$r) {
  return strcat(".//*[contains(concat(' ',@rel,' '),' ",$r," ') and starts-with(@",$a,",'",$s,"')]");
}

/* end XPath */


/* ------------------------------------------------------------------ */


/* microformats */

/* value class pattern readable date time from ISO8601 datetime */
function vcpdtreadable($d) {
  $d = explode("T", $d);
  $r = "";
  if (count($d)>1) { 
     $r = strcat('<span class="value">',$d[1],'</span> on ');
  }
  return strcat($r,'<span class="value">',$d[0],'</span>');
}

/* end microformats */


/* ------------------------------------------------------------------ */


/* whistle */

// algorithmic URL shortener core
// YYYY/DDD/tnnn to tdddss 
// ordinal date, type, decimal #, to sexagesimal epoch days, sexagesimal #
function whistle_short_path($p) {
  return strcat(substr($p,9,1),
                ((substr($p,9,1)!='t') ? "/" : ""),
                ydtosdf(substr($p,0,8),3),
                numtosxg(substr($p,10,3)));
}
/* end whistle */


/* ------------------------------------------------------------------ */


/* falcon */

function html_unesc_amp_only($s) {
  return str_ireplace('&amp;','&',$s);
}

function html_esc_amper_once($s) {
  return str_ireplace('&','&amp;',html_unesc_amp_only($s));
}

function html_esc_amp_ang($s) {
  return str_ireplace('<','&lt;',
          str_ireplace('>','&gt;',html_esc_amper_once($s)));
}

function ellipsize_to_word($s, $max, $e, $min) {
  if (strlen($s)<=$max) {
    return $s; // no need to ellipsize
  }

  $slen = $max-strlen($e);

  if ($min) {
    // if a non-zero minimum is provided, then
    // find previous space or word punctuation to break at.
    // do not break at %`'"&.!?^ - reasons why to be documented.
    while ($slen>$min && !contains('@$ -~*()_+[]\{}|;,<>',$s[$slen-1])) {
      --$slen;
    }
  }
  // at this point we've got a min length string, 
  // so only do minimum trimming necessary to avoid a punctuation error.
  
  // trim slash after colon or slash
  if ($s[$slen-1]=='/' && $slen > 2) {
    if ($s[$slen-2]==':') {
      --$slen;    
    }
    if ($s[$slen-2]=='/') {
      $slen -= 2;
    }
  }

  //if trimmed at a ":" in a URL, trim the whole thing
    //or trimmed at "http", trim the whole URL
  if ($s[$slen-1]==':' && $slen > 5 && substr($s,$slen-5,5)=='http:') {
    $slen -= 5;
  }
  else if ($s[$slen-1]=='p' && $slen > 4 && substr($s,$slen-4,4)=='http') {
    $slen -= 4;
  }
  
  
  //if char immediately before ellipsis would be @$ then trim it as well
  if ($slen > 0 && contains('@$',$s[$slen-1])) {
    --$slen;
  }
 
  //while char immed before ellipsis would be a sentence terminator, trim 2 more
  while ($slen > 1 && contains('.!?',$s[$slen-1])) {
    $slen-=2;
  }

  if ($slen < 1) { // somehow shortened too much
    return $e; // or ellipsis by itself filled/exceeded max, return ellipsis.
  }

  return strcat(substr($s,0,$slen),$e);
}

function auto_link(/*$t*/) {
  $isjs = js();
  $args = $isjs ? arguments : func_get_args();
  if (count($args) == 0) {
    return '';
  }
  $t = $args[0];
  $do_embed = (count($args) > 1) && ($args[1]!=false);
  // ccTLD compresed regular expression clauses (re)created.
  // .mobi and .jobs deliberately excluded to avoid encouraging layer violations
  // part of $re derived from Android Open Source Project under Apache 2.0
  // with a bunch of subsequent fixes/improvements (e.g. ttk.me/t44H2)
  // and added support for auto_linking @-names to Twitter (except CSS @-rules).
  // thus this entire function in particular is also Apache 2.0 licensed
  //  http://www.apache.org/licenses/LICENSE-2.0
  // - Tantek 2010-046
  // P.S. This function is idempotent and works on plain text or typical markup.
  $re = '/(?:\\@[_a-zA-Z0-9]{1,17})|(?:(?:(?:https?:\\/\\/(?:(?:[!$&-.0-9;=?A-Z_a-z]|(?:\\%[a-fA-F0-9]{2}))+(?:\\:(?:[!$&-.0-9;=?A-Z_a-z]|(?:\\%[a-fA-F0-9]{2}))+)?\\@)?)?(?:(?:(?:[a-zA-Z0-9][-a-zA-Z0-9]*\\.)+(?:(?:aero|arpa|asia|a[cdefgilmnoqrstuwxz])|(?:biz|b[abdefghijmnorstvwyz])|(?:cat|com|coop|c[acdfghiklmnoruvxyz])|d[ejkmoz]|(?:edu|e[cegrstu])|f[ijkmor]|(?:gov|g[abdefghilmnpqrstuwy])|h[kmnrtu]|(?:info|int|i[delmnoqrst])|j[emop]|k[eghimnrwyz]|l[abcikrstuvy]|(?:mil|museum|m[acdeghklmnopqrstuvwxyz])|(?:name|net|n[acefgilopruz])|(?:org|om)|(?:pro|p[aefghklmnrstwy])|qa|r[eouw]|s[abcdeghijklmnortuvyz]|(?:tel|travel|t[cdfghjklmnoprtvwz])|u[agkmsyz]|v[aceginu]|w[fs]|y[etu]|z[amw]))|(?:(?:25[0-5]|2[0-4][0-9]|[0-1][0-9]{2}|[1-9][0-9]|[1-9])\\.(?:25[0-5]|2[0-4][0-9]|[0-1][0-9]{2}|[1-9][0-9]|[0-9])\\.(?:25[0-5]|2[0-4][0-9]|[0-1][0-9]{2}|[1-9][0-9]|[0-9])\\.(?:25[0-5]|2[0-4][0-9]|[0-1][0-9]{2}|[1-9][0-9]|[0-9])))(?:\\:\\d{1,5})?)(?:\\/(?:(?:[!#&-;=?-Z_a-z~])|(?:\\%[a-fA-F0-9]{2}))*)?)(?=\\b|\\s|$)/';
  $ms = preg_matches($re,$t);
  if (!$ms) {
    return $t;
  }

  $mlen = count($ms);
  $sp = preg_split($re,$t);
  $t = "";
  $sp[0] = string($sp[0]); // force undefined to ""
  for ($i=0;$i<$mlen;$i++) {
    $matchi = $ms[$i];
    $spliti = $sp[$i];
    $t = strcat($t, $spliti);
    $sp[$i+1] = string($sp[$i+1]); // force undefined to ""
    if (substr($sp[$i+1],0,1)=='/') { // regex omits end slash before </a
      $sp[$i+1] = substr($sp[$i+1],1,strlen($sp[$i+1])-1);
      $matchi = strcat($matchi,'/'); // explicitly include it in the match
    }
    $spe = substr($spliti,-2,2);
    // avoid double-linking, and don't link CSS @-rules, or attribute values
    if ((!$spe || !preg_match('/(?:\\=[\\"\\\']?|t;)/',$spe)) &&
        substr(trim($sp[$i+1]),0,3)!='</a' && 
        (!contains('@charset@font@font-face@import@media@namespace@page@',
                   strcat($matchi,'@'))))
    {
      $afterlink = substr($matchi,-1,1);
      if (contains('.!?,;"\')]}',$afterlink) && // trim punctuation from end
          ($afterlink!=')' || !contains($matchi,'('))) { // allow one paren pair
        $matchi = substr($matchi,0,-1);
      }
      else {
        $afterlink = "";
      }
      $fe = 0;
      if ($do_embed) {
         $fe = (substr($matchi,-4,1)=='.') ? 
                 substr($matchi,-4,4) :
                 substr($matchi,-5,5);
      }
      $wmatchi = webaddresstouri($matchi,true);
      if ($fe && 
          ($fe == '.jpeg' || $fe == '.jpg' || $fe == '.png' || $fe == '.gif'))
      {
        $t = strcat($t, '<a class="auto-link figure" href="',      
                    $wmatchi, '"><img src="', 
                    $wmatchi, '"/></a>', 
                    $afterlink);
      }
      else if (!strncmp($wmatchi,'http://vimeo.com/',17) && 
               ctype_digit(substr($wmatchi,17)))
      {
        $t = strcat($t, '<a class="auto-link" href="',
                    $wmatchi, '">', $matchi, '</a> <iframe class="vimeo-player auto-link figure" width="480" height="385" style="border:0"  src="http://player.vimeo.com/video/', 
                    substr($wmatchi,17), '"></iframe>', 
                    $afterlink);
      }
      else if (!strncmp($wmatchi,'http://youtu.be/',16) ||
               ((!strncmp($wmatchi,'http://youtube.com/',19) ||
                 !strncmp($wmatchi,'http://www.youtube.com/',23))
                 && ($yvid = offset('watch?v=',$matchi))!=0))
      {
        if (!strncmp($wmatchi,'http://youtu.be/',16)) {
          $yvid = substr($wmatchi,16);
        }
        else {
          $yvid = explode('&',substr($matchi, $yvid+8));
          $yvid = $yvid[0];
        }
        $t = strcat($t, '<a class="auto-link" href="',
                    $wmatchi, '">', $matchi, '</a> <iframe class="youtube-player auto-link figure" width="480" height="385" style="border:0"  src="http://www.youtube.com/embed/', 
                    $yvid, '"></iframe>', 
                    $afterlink);
      }
      else {
        $t = strcat($t, '<a class="auto-link" href="',
                    $wmatchi, '">', $matchi, '</a>', 
                    $afterlink);
      }
    }
    else {
      $t = strcat($t, $matchi);
    }
  }
  return strcat($t, $sp[$mlen]);
}


function note_length_check($note, $maxlen, $username) {
// checks to see if $note fits in $maxlen characters.
// if $username is non-empty, checks to see if a RT'd $note fits in $maxlen
// 0 - bad params or other precondition failure error
// 200 - exactly fits max characters with RT if username provided
// 206 - less than max chars with RT if username provided
// 207 - more than RT safe length, but less than tweet max
// 208 - tweet max length but with RT would be over
// 413 - (entity too large) over max tweet length
// strlen('RT @: ') == 6.
  if ($maxlen < 1) return 0;
  
  $note_size_check_u = $username ? 6 + strlen(string($username)) : 0;
  $note_size_check_n = strlen(string($note)) + $note_size_check_u;
  
  if ($note_size_check_n == $maxlen)                      return 200;
  if ($note_size_check_n < $maxlen)                       return 206;
  if ($note_size_check_n - $note_size_check_u < $maxlen)  return 207;
  if ($note_size_check_n - $note_size_check_u == $maxlen) return 208;
  return 413;
}

/* end falcon */


/* ------------------------------------------------------------------ */

/* end cassis.js */
// ?> -->