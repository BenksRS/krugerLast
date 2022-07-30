<div>
        {{--kk--}}
    @if(session()->has('alertAuth'))
        <div  class="alert alert-{{session('alertAuth')['class']}}" x-init="setTimeout(() => show = false, 3000)">
            {!! nl2br(session('alertAuth')['message']) !!}
        </div>
        <script>
            setTimeout(function() {
                $('.alert-success').fadeOut('fast');
            }, 2000);
        </script>
    @endif
</div>
