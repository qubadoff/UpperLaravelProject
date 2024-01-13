@if(session()->has('success'))
<script>{!! notify('success', session('success')) !!}</script>
@endif

@if(session()->has('warning'))
<script>{!! notify('warning', session('warning')) !!}</script>
@endif
