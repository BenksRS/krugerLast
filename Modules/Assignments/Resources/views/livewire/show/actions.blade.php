<div>

    @if($assignment->referral->status == 'BLOCKED')

        <div  class="alert alert-danger" x-init="setTimeout(() => show = false, 3000)">
            <b>{{$assignment->referral->full_name}} </b> is <b>BLOCKED</b> on the system!!!! Don't proceed without permission!
        </div>
        <script>
            setTimeout(function() {
                $('.alert-success').fadeOut('fast');
            }, 2000);
        </script>
    @endif
        @if(session()->has('missingAuth'))
            <div  class="alert alert-{{session('missingAuth')['class']}}" x-init="setTimeout(() => show = false, 3000)">
                {!! nl2br(session('missingAuth')['message']) !!}
            </div>
            <script>
                setTimeout(function() {
                    $('.alert-success').fadeOut('fast');
                }, 2000);
            </script>
        @endif

            @if(session()->has('noneed'))
                <div  class="alert alert-{{session('noneed')['class']}}" x-init="setTimeout(() => show = false, 3000)">
                    {!! nl2br(session('noneed')['message']) !!}
                </div>
                <script>
                    setTimeout(function() {
                        $('.alert-success').fadeOut('fast');
                    }, 2000);
                </script>
            @endif
        @if(session()->has('hasAuth'))
            <div  class="alert alert-{{session('hasAuth')['class']}}" x-init="setTimeout(() => show = false, 3000)">
                {!! nl2br(session('hasAuth')['message']) !!}
            </div>
            <script>
                setTimeout(function() {
                    $('.alert-success').fadeOut('fast');
                }, 2000);
            </script>
        @endif
</div>


