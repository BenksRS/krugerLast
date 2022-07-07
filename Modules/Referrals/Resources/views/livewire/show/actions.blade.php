<div>
    @if(session()->has('alert'))
        <div  class="alert alert-{{session('alert')['class']}}" x-init="setTimeout(() => show = false, 3000)">
            {!! nl2br(session('alert')['message']) !!}
        </div>
        <script>
            setTimeout(function() {
                $('.alert-success').fadeOut('fast');
            }, 2000);
        </script>
    @endif
</div>
