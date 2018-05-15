<?php

namespace Don47\Grammer;

use App\Touch\Fluent;
use App\Touch\Grammer;

class Blade extends Grammer implements Fluent
{
  /**
   * (incomeplete)
   */
  public static $_SWITCH = false;

  public function handle()
  {
    // Control Structures

    /**
     * if
     * elseif
     * else
     * endif
     */
    $code = $this->translate('/\@\bif\b \((.*)\)/', function($match) {
      return "<?php if ($match[1]) : ?>";
    });

    $code = $this->translate('/\@\belseif\b \((.*)\)/', function($match) {
      return "<?php elseif ($match[1]) : ?>";
    });

    $code = $this->translate('/\@\belse\b/', function($match) {
      return "<?php else : ?>";
    });

    $code = $this->translate('/\@\bendif\b/', function($match) {
      return "<?php endif; ?>";
    });

    /**
     * isset
     * endisset
     */
    $code = $this->translate('/\@\bisset\b\((.*)\)/', function($match) {
      return "<?php if (isset($match[1])) :?>";
    });

    $code = $this->translate('/\@\bendisset\b/', function($match) {
      return "<?php endif; ?>";
    });

    /**
     * switch
     * case - case "red":
     * break - break;
     * default - default;
     * endswitch
     */
    $code = $this->translate('/\@\bswitch\b\((.*)\)/', function($match) {
      $this->$_SWITCH = true;
      return "<?php switch($match[1]) :";
    });

    $code = $this->translate('/\@\bcase\b\((.*)\)/', function($match) {
      if ($this->$_SWITCH == true) {
        $this->$_SWITCH = false;
        return "case $match[1] :?>";
      }

      return "<?php case $match[1] :?>";
    });

    $code = $this->translate('/\@\bbreak\b/', function($match) {
      return "<?php break; ?>";
    });

    $code = $this->translate('/\@\bdefault\b/', function($match) {
      return "<?php default; ?>";
    });

    $code = $this->translate('/\@\bendswitch\b/', function($match) {
      return "<?php endswitch; ?>";
    });

    /**
     * for
     * endfor
     */
    $code = $this->translate('/\@\bfor\b \((.*)\)/', function($match) {
      return "<?php for ($match[1]) : ?>";
    });

    $code = $this->translate('/\@\bendfor\b/', function($match) {
      return "<?php endfor; ?>";
    });

    /**
     * foreach
     * endforeach
     */
    $code = $this->translate('/\@\bforeach\b \((.*)\)/', function($match) {
      return "<?php foreach ($match[1]) : ?>";
    });

    $code = $this->translate('/\@\bendforeach\b/', function($match) {
      return "<?php endforeach; ?>";
    });

    /**
     * do
     * while
     * endwhile
     */
    $code = $this->translate('/\@\bdo\b (.*)/', function($match) {
      return "<?php do $match[1]; ?>";
    });

    $code = $this->translate('/\@\bwhile \((.*)\)/', function($match) {
      return "<?php while ($match[1]): ?>";
    });

    $code = $this->translate('/\@\bendwhile\b/', function($match) {
      return "<?php endwhile ; ?>";
    });

    /**
     * continue
     */
    $code = $this->translate('/\@\bcontinue\b/', function($match) {
      return "<?php continue ; ?>";
    });

    return $code;
  }
}