<?php
/* 
   cassis-lab.php Copyright 2018 Tantek Çelik http://tantek.com/ 
   Part of cassisproject.com
   license: https://creativecommons.org/licenses/by-sa/4.0/

This is a PHP-only staging file for functions that would work well 
as CASSIS functions but which I have not yet found use-cases 
for client-side usage.

All code is experimental at best!

*/

// ----------
// independent functions - only depend on PHP

// *heuristic* function. file issues for real world use-case fails.
function is_one_emoji($s) {
  $n = strlen($s);
  if ($n>25) return false;
  if (ord($s[0]) == 226) // older emoji with optional variant
    return (3 == $n || 
            (6 == $n && ord($s[3]) == 239 && ord($s[4]) == 184));
  if (ord($s[0]) != 240) return false;
  if (7 == $n && ord($s[4]) == 239 && ord($s[5]) == 184)
    return true; // modern emoji with simple variant
  if (8 == $n && 
      ord($s[4]) == 240 && ord($s[5]) == 159 &&  ord($s[6]) == 143) return true; // modern emoji with skin tone
  if (13 == $n &&
      ord($s[4]) == 226 && ord($s[5]) == 128 &&  ord($s[6]) == 141 &&
      ord($s[7]) == 226 && ord($s[8]) == 153 &&
      ord($s[10]) == 239 && ord($s[11]) == 184)
      return true; // modern emoji with gender variant
  $i = 0;
  while ($i<$n && 
         (ord($s[$i]) == 240 && 
          ($i+4 == $n ||
           ($i+6 < $n && 
            ord($s[$i+4]) == 226 && ord($s[$i+5]) == 128 && ord($s[$i+6]) == 141)))) {
        if ($i+4 == $n) return true; // modern composite emoji
        $i += 7;
  }
  return (ord($s[$i])==240 && $i+4==$n);
}



// ----------
// CASSIS dependent functions - depend on cassis.js behing loaded

/* auto_url_summary */
function auto_url_summary($u) {
  // in: $u is a post permalink url
  // out: text summary based on url
  $hn = hostname_of_uri($u);
  $ss = explode('.', $hn);
  $s = $ss[count($ss) - 2];
  if ($s == 'github') {
    // comment, issue, pull request
    if (fragment_of_uri($u) != "") {
      if (segment_of_uri(3, $u) == 'issues')
        return strcat('a comment on issue ',
                      segment_of_uri(4, $u), ' of GitHub project “',
                      segment_of_uri(2, $u), '”');
      if (segment_of_uri(3, $u) == 'pull')
        return strcat('a comment on pull request ',
                      segment_of_uri(4, $u), ' to GitHub project “',
                      segment_of_uri(2, $u), '”');
      return strcat('a comment on GitHub project “',
		            segment_of_uri(2, $u), '”');                 
    }
    
    if (segment_of_uri(3, $u) == 'issues') {
      if (segment_of_uri(4, $u) != "")
        return strcat('issue ', segment_of_uri(4, $u), 
                      ' of GitHub project “',
                      segment_of_uri(2, $u), '”');
      else
        return strcat('GitHub project “',
                      segment_of_uri(2, $u), '”');
    }            
    if (segment_of_uri(3, $u) == 'pull') 
      return strcat('pull request ', segment_of_uri(4, $u), 
                    ' to GitHub project “',
                    segment_of_uri(2, $u), '”');
  }
  if ($s == 'twitter') {
    return strcat('@', segment_of_uri(1, $u),'’s tweet');
  }
  if ($s == 'facebook') {
    if (segment_of_uri(1, $u) == 'events')
      return "a Facebook event";
    if (segment_of_uri(2, $u) == 'photos')
      return strcat(segment_of_uri(1, $u),'’s photo');
    if (segment_of_uri(2, $u) == 'posts')
      return strcat(segment_of_uri(1, $u),'’s post');
  }
  if ($s == 'eventbrite')
    return "an Eventbrite event";
  if ($s == 'upcoming' && segment_of_uri(1, $u) == 'event')
    return "an Upcoming event";
  if ($s == 'calagator' && segment_of_uri(1, $u) == 'events')
    return "a Calagator event";

  if ($s == 'indieweb') {
    if (segment_of_uri(1, $u) == 'events' && segment_of_uri(2, $u) != '')
      return "an IndieWeb event";
    if (count($ss) == 3 && ctype_digit($ss[0]))
      return "an IndieWeb event";      
    
    return "an IndieWeb page"; 
    // TBI different IndieWeb pages
  }
  
  // TBI: if $u has fragmention, synthesize quote from it
  // per http://www.kevinmarks.com/mentionquote.html
  return strcat(hostname_of_uri($u), 
                (path_of_uri($u)!='/') ? '’s post' : '');
}

?>
