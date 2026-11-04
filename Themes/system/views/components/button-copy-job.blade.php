@props([
    'target',
    'label' => 'Copy',
	'color' => 'info',
	'size'  => 'sm'
])

@php
    $properties = $attributes->class(['btn', 'btn-' . $size, 'btn-' . $color])->merge(['type' => 'button']);
@endphp

<button {{ $properties }} data-copy-target="{{ $target }}" onclick="window.copyJobRow(this)">
    <i class="fa fa-fw fa-copy"></i>
</button>

@once
    <script>
        window.copyJobRow = function (button) {
            const element = document.querySelector(button.dataset.copyTarget);
            const selection = window.getSelection();

            if (!element) {
                alert('Content to copy was not found.');
                return;
            }

            const range = document.createRange();

            range.selectNodeContents(element);

            // Exclude the Actions cell from the selection.
            const actionCell = button.closest('td');

            if (actionCell && element.contains(actionCell)) {
                range.setEndBefore(actionCell);
            }

            selection.removeAllRanges();
            selection.addRange(range);

            if (!document.execCommand('copy')) {
                alert('Could not copy automatically. The content is selected, press Ctrl+C to copy it manually.');
            }
            selection.removeAllRanges();
        };
    </script>
@endonce