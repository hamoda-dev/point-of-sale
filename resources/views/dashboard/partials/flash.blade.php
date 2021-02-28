@if(session()->has("success_message"))
    <script>
        $.notify("{{ session()->get('success_message') }}", "success");
    </script>
@endif

@if(session()->has("error_message"))
    <script>
        $.notify("{{ session()->get('error_message') }}", "error");
    </script>
@endif
