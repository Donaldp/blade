<?php

namespace Don47\Grammar;

use ModulusPHP\Touch\Fluent;
use ModulusPHP\Touch\Grammar;

class Blade extends Grammar implements Fluent
{
  /**
   * (incomeplete)
   */
  public static $_SWITCH = false;

  public function handle()
  {
    // Control Structures

    /**
     * validation
     */
    $code = $this->translate('/\@\bvalidation\b\((.*)\)/', function($match) {
      return '<?php if (isset($validation['.$match[1].'])) :?>';
    });

    $code = $this->translate('/\{\{ \bvalidation\b(.*) \}\}/', function($match) {
      return '{{ % validation($validation, '.$match[1].') }}';
    });

    $code = $this->translate('/\@\bendvalidation\b/', function($match) {
      return "<?php endif; ?>";
    });

    /**
     * if
     * elseif
     * else
     * endif
     *
     * example:
     * @if ($name == 'Donald')
     *    <h1>Creator of modulusPHP</h1>
     * @endif
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
     *
     * example:
     * @isset($name)
     *    <h1>Hey, {{ $name }}</h1>
     * @endisset
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
     *
     * example:
     * @switch($name)
     *
     *    @case('Donald')
     *        <h1>Creator of modulusPHP</h1>
     *        @break
     *
     *    @case('Drake')
     *        <h1>Coolest artist</h1>
     *        @break
     *
     *    @default
     *        <h1>Nothing here</h1>
     *
     * @endswitch
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
     *
     * example:
     * @for ($i = 0; $i < 10; $i++)
     *    <h1>The current value is {{ $i }}</h1>
     * @endfor
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
     *
     * example:
     * @foreach ($names as $name)
     *    <h1>{{ $name }}</h1>
     * @endforeach
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
     *
     * example:
     * @while (true)
     *    <p>I'm looping forever.</p>
     * @endwhile
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

    /**
     * var
     *
     * example 1:
     * @var(age)
     *
     * example 2:
     * @var(age = 20)
     */
    $code = $this->translate('/@\bvar\b(.*)/', function($match) {
      return "<?php $$match[1];?>";
    });

    return $code;
  }
}