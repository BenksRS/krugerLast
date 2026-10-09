@props([
	'target',
	'label'   => 'Copy',
	'message' => 'Copied to clipboard!',
	'color'   => 'info',
	'size'    => 'md'
])

@php
   $properties = $attributes->class(['btn', 'btn-' . $size, 'btn-' . $color])->merge(['type' => 'button']);
@endphp

<button {{ $properties }} data-copy-target="{{ $target }}" data-copy-message="{{ $message }}" onclick="window.copyContent(this)">
   <i class="fa fa-fw fa-copy"></i> {{ $label }}
</button>

@once
   <script>
       window.copyContent = function (button) {
           const element = document.querySelector(button.dataset.copyTarget);

           if (!element) {
               alert('Content to copy was not found.');
               return;
           }

           const selection = window.getSelection();
           const range     = document.createRange();

           range.selectNodeContents(element);
           selection.removeAllRanges();
           selection.addRange(range);

           const finish = function (success) {
               // Small delay so the browser paints the selection before the alert blocks the page
               setTimeout(function () {
                   alert(success ? button.dataset.copyMessage : 'Could not copy the content.');
                   selection.removeAllRanges();
               }, 100);
           };

           let copied = false;

           try {
               copied = document.execCommand('copy');
           } catch (e) {
               copied = false;
           }

           if (copied) {
               finish(true);
           } else if (navigator.clipboard) {
               navigator.clipboard.writeText(selection.toString())
                        .then(function () { finish(true); })
                        .catch(function () { finish(false); });
           } else {
               finish(false);
           }
       };
   </script>
@endonce